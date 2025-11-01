<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['midtrans'] = array(
    'server_key'   => getenv('MIDTRANS_SERVER_KEY') ?: '',
    'client_key'   => getenv('MIDTRANS_CLIENT_KEY') ?: '',
    'is_production'=> (strtolower(getenv('MIDTRANS_IS_PRODUCTION') ?: 'false') === 'true'),
    'snap_redirect_success' => base_url('index.php/pembayaran/success'),
    'notification_url' => base_url('index.php/pembayaran/midtrans_notif')
);
