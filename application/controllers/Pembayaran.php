<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pembelian_model');
        $this->load->model('Pembayaran_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
        $this->config->load('midtrans', TRUE);
    }

    public function index($idpem) {
        if (!$this->session->userdata('pengguna')) {
            $this->session->set_flashdata('error', 'Anda belum login.');
            redirect('login');
        }
    
        $id_login = $this->session->userdata('pengguna')['id'];
        $detpem = $this->Pembelian_model->getPembelian_ById($idpem);
    
        if (!$detpem || $id_login != $detpem['id']) {
            $this->session->set_flashdata('error', 'Gagal.');
            redirect('riwayat');
        }
    
        $deadline = date('Y-m-d H:i', strtotime($detpem['waktu'] . ' +1 day'));
        if (date('Y-m-d H:i') >= $deadline) {
            $this->session->set_flashdata('error', 'Waktu pembayaran telah habis.');
            redirect('riwayat');
        }
    
        $data['detail'] = $detpem;
        $data['produk'] = $this->Pembelian_model->getProdukByPembelian($idpem);
        $data['deadline'] = $deadline;
    
        $this->load->view('pembayaran', $data);
    }

    /**
     * Create Midtrans Snap transaction (QRIS available in Snap) and redirect user
     */
    public function create_midtrans($idpem)
    {
        // Pastikan user login dan berhak melakukan pembayaran
        if (!$this->session->userdata('pengguna')) {
            $this->session->set_flashdata('error', 'Anda belum login.');
            redirect('login');
        }

        $id_login = $this->session->userdata('pengguna')['id'];
        $detpem = $this->Pembelian_model->getPembelian_ById($idpem);
        if (!$detpem || $id_login != $detpem['id']) {
            $this->session->set_flashdata('error', 'Gagal.');
            redirect('riwayat');
        }

        // Ambil konfigurasi Midtrans
        $cfg = $this->config->item('midtrans');

        $amount = (float) ($detpem['totalbeli'] ?? $detpem['total_bayar'] ?? 0);
        if ($amount <= 0) {
            $this->session->set_flashdata('error', 'Jumlah pembayaran tidak valid.');
            redirect('pembayaran/index/' . $idpem);
        }

        // Setup Midtrans config
        \Midtrans\Config::$serverKey = $cfg['server_key'];
        \Midtrans\Config::$isProduction = (bool)$cfg['is_production'];
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $order_id = 'order-'.$idpem.'-'.time();
        $transaction_details = array(
            'order_id' => $order_id,
            'gross_amount' => (int)$amount
        );

        $customer_details = array(
            'first_name' => $detpem['nama'] ?? 'Customer',
            'email' => $detpem['email'] ?? null,
            'phone' => $detpem['telepon'] ?? null
        );

        $params = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            // Snap will show available methods incl. QRIS
            'enabled_payments' => array('qris')
        );

        try {
            $snap = \Midtrans\Snap::createTransaction($params);
            if (!empty($snap->redirect_url)) {
                // simpan referensi order_id
                $this->Pembelian_model->insertPembayaran([
                    'idbeli' => $idpem,
                    'nama' => 'Midtrans Snap',
                    'tanggal' => date('Y-m-d H:i:s'),
                    'bukti' => $order_id
                ]);
                redirect($snap->redirect_url);
                return;
            }
        } catch (Exception $e) {
            log_message('error', 'Midtrans error: '.$e->getMessage());
        }

        $this->session->set_flashdata('error', 'Gagal membuat transaksi Midtrans.');
        redirect('pembayaran/index/' . $idpem);
    }

    /**
     * Endpoint webhook untuk menerima notifikasi dari Xendit
     */
    public function midtrans_notif()
    {
        // Konfigurasi Midtrans
        $cfg = $this->config->item('midtrans');
        \Midtrans\Config::$serverKey = $cfg['server_key'];
        \Midtrans\Config::$isProduction = (bool)$cfg['is_production'];

        $notif = new \Midtrans\Notification();
        $transaction = $notif->transaction_status;
        $order_id    = $notif->order_id; // format: order-{idpem}-{ts}

        if (preg_match('/order-(\d+)-/', $order_id, $m)) {
            $idpem = $m[1];
            if (in_array($transaction, array('capture','settlement'))) {
                $this->Pembelian_model->updateStatusPembelian($idpem, 'Sudah Terbayar');
            } elseif ($transaction === 'expire') {
                $this->Pembelian_model->updateStatusPembelian($idpem, 'Kadaluarsa');
            } elseif (in_array($transaction, array('deny','cancel','failure'))) {
                $this->Pembelian_model->updateStatusPembelian($idpem, 'Gagal');
            } else { // pending
                $this->Pembelian_model->updateStatusPembelian($idpem, 'Menunggu Pembayaran');
            }
        }

        http_response_code(200);
        echo 'OK';
    }

    /**
     * Success redirect after payment
     */
    public function success($idpem)
    {
        // user returned from Xendit after successful payment
        $this->session->set_flashdata('success', 'Pembayaran terverifikasi. Terima kasih.');
        redirect('riwayat');
    }
    

    public function uploadBukti($idpem)
    {
        // Pastikan pengguna sudah login
        if (!$this->session->userdata('pengguna')) {
            $this->session->set_flashdata('error', 'Anda belum login.');
            redirect('login');
        }
    
        $id_login = $this->session->userdata('pengguna')['id'];
    
        // Ambil detail pembelian
        $detpem = $this->Pembelian_model->getPembelianById($idpem);
    
        if (!$detpem || $id_login != $detpem['id']) {
            $this->session->set_flashdata('error', 'Gagal.');
            redirect('riwayat');
        }
    
        // Validasi jika batas waktu sudah habis
        $deadline = date('Y-m-d H:i', strtotime($detpem['waktu'] . ' +1 day'));
        if (date('Y-m-d H:i') >= $deadline) {
            $this->session->set_flashdata('error', 'Waktu pembayaran telah habis.');
            redirect('riwayat');
        }
    
        // Validasi input
        $this->form_validation->set_rules('nama', 'Nama Rekening', 'required');
        $this->form_validation->set_rules('tanggaltransfer', 'Tanggal Transfer', 'required');
    
        if (empty($_FILES['bukti']['name'])) {
            $this->form_validation->set_rules('bukti', 'Bukti Pembayaran', 'required');
        }
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pembayaran/index/' . $idpem);
        }
    
        // Proses upload file
        $config['upload_path']   = './assets/foto/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size']      = 2048; // Maksimal 2MB
        $config['file_name']     = 'bukti_' . $idpem . '_' . time();
    
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('bukti')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('pembayaran/index/' . $idpem);
        }
    
        // Jika berhasil upload, ambil data file
        $fileData = $this->upload->data();
        $filePath = $fileData['file_name'];
    
        // Simpan data ke database
        $data = [
            'idbeli'           => $idpem,
            'nama'             => $this->input->post('nama'),
            'tanggaltransfer'  => $this->input->post('tanggaltransfer'),
            'bukti'            => $filePath,
            'tanggal'          => date('Y-m-d H:i:s'),  // Tanggal pembayaran saat ini
        ];
    
        // Simpan data pembayaran ke tabel pembayaran
        if ($this->Pembelian_model->insertPembayaran($data)) {
            // Update status pembelian
            $this->Pembelian_model->updateStatusPembelian($idpem, 'Sudah Upload Bukti Pembayaran');
            $this->session->set_flashdata('success', 'Bukti pembayaran berhasil diunggah. Silakan tunggu konfirmasi.');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    
        redirect('riwayat');
    }
    
    
}
