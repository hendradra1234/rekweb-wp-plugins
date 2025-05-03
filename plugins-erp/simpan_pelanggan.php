<?php

defined('ABSPATH') || exit;

function form_pelanggan_handle_submission() {
    if (isset($_POST['simpan_pelanggan'])) {
        $table_name = $wpdb->prefix . 'pelanggan_custom_erp';

        $kode   = sanitize_text_field($_POST['kode_pelanggan']);
        $nama   = sanitize_text_field($_POST['nama_pelanggan']);
        $alamat = sanitize_textarea_field($_POST['alamat']);

        // Cek duplikat
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE kode_pelanggan = %s",
            $kode
        ));

        if ($exists > 0) {
            echo '<div class="alert alert-danger mt-3">Kode pelanggan sudah terdaftar.</div>';
        } else {
            $wpdb->insert($table_name, [
                'kode_pelanggan' => $kode,
                'nama_pelanggan' => $nama,
                'alamat' => $alamat
            ]);
            echo '<div class="alert alert-success mt-3">Data pelanggan berhasil disimpan.</div>';
        }
    }
}