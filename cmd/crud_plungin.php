<?php
  /*
    Plugin Name:Customer-ERP
    Plugin URI: https://id.wordpress.org/hendrakho
    Description: Wordpress Plungin
    Version: 0.1
    Author: Hendra
    Author URI: https://www.facebook.com/hendrakho
    License: GPL2
  */
  register_activation_hook(__FILE__, 'form_pelanggan_install');
    function form_pelanggan_install() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'pelanggan';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            kode_pelanggan VARCHAR(5) PRIMARY KEY,
            nama_pelanggan VARCHAR(60),
            alamat TEXT
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
?>

<?php
  function crud_module() {
    include "main.php";
  }
?>

<?php
  function menus() {
    add_menu_page(
      'Menu Test Plungin', # Title
      'Customer-ERP', # Nama Menu yang tampil
      'read', # Capability
      'tes_plungin',# Nama Link
      'crud_module' #Nama Link atau page yang di panggil
    );
  }

  add_action('admin_menu', 'menus');
?>