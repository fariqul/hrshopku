<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Xendit configuration
$config['xendit'] = array(
    // Isi dengan API key Xendit Anda (secret key)
    'api_key' => '',
    // Token yang akan digunakan Xendit saat memanggil webhook (jika Anda mengatur token di dashboard)
    'webhook_token' => '',
    // URL callback (optional) - endpoint yang Xendit akan panggil setelah status berubah
    'callback_url' => base_url('index.php/pembayaran/webhook')
);
