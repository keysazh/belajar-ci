<?php

if (!function_exists('hitung_diskon')) {
    /**
     * Hitung diskon berdasarkan total pembelian (Tiered Discount)
     *
     * @param float $totalHarga
     * @return array Array berisi 'persen' dan 'nominal'
     */
    function hitung_diskon($totalHarga)
    {
        $persen = 0;

        // Penentuan persentase berdasarkan range harga sesuai soal kuis
        if ($totalHarga >= 50000000) {
            $persen = 15;
        } elseif ($totalHarga >= 30000000) {
            $persen = 10;
        } elseif ($totalHarga >= 10000000) {
            $persen = 5;
        } else {
            $persen = 0;
        }

        // Hitung nominal Rupiah dari diskon
        $nominal = ($persen / 100) * $totalHarga;

        return [
            'persen'  => $persen,
            'nominal' => $nominal
        ];
    }
}