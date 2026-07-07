<?php

if (!function_exists('hitung_biaya_admin')) {
    function hitung_biaya_admin($total_harga) {
        if ($total_harga <= 20000000) {
            return $total_harga * 0.005; // 0.5%
        } else {
            return $total_harga * 0.0075; // 0.75%
        }
    }
}

if (!function_exists('hitung_diskon_kupon')) {
    function hitung_diskon_kupon($total_harga, $kupon_code) {
        $kupon = strtoupper(trim($kupon_code));
        if ($kupon === 'HEMAT') {
            return $total_harga * 0.15; // 15%
        } elseif ($kupon === 'SUPER') {
            return $total_harga * 0.20; // 20%
        }
        return 0; // Kode salah / tidak valid
    }
}

if (!function_exists('hitung_cashback')) {
    function hitung_cashback($total_harga) {
        if ($total_harga > 10000000) {
            return $total_harga * 0.02; // 2%
        }
        return 0;
    }
}