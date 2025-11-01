<?php
class IntrusionDetection
{
    public function check_request()
    {
        // Daftar pola serangan yang dapat dideteksi
        $patterns = [
            '/union.*select.*from.*information_schema.tables/i', // SQL Injection
            '/<script.*>/i', // Cross-site Scripting (XSS)
            '/\.\.\/\.\.\//', // Directory Traversal
            '/base64_decode/i', // Encoded data, sering digunakan pada serangan
            '/select.*from.*users/i', // Menyerang tabel users
            // Tambahkan pola lain sesuai kebutuhan
        ];

        // Ambil request URI dan input user dengan pengecekan null
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $input = file_get_contents('php://input') ?: ''; // Untuk POST request

        // Cek apakah ada pola yang cocok di dalam URI atau input
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $uri) || preg_match($pattern, $input)) {
                // Log serangan atau tampilkan pesan error
                log_message('error', 'Intrusion detected: ' . $uri);
                show_error('Suspicious activity detected. Your access is logged.', 403);
            }
        }
    }
}
