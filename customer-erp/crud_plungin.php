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
  global $wpdb;
  register_activation_hook(__FILE__, 'form_db_erp_install');
    function form_db_erp_install() {
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
  function erp_crud_module() {
    include "main.php";
  }
?>

<?php
  function customer_erp_menus() {
    add_menu_page(
      'Customer ERP Plungin', # Title
      'Customer-ERP', # Nama Menu yang tampil
      'read', # Capability
      'customer_erp_plungin',# Nama Link
      'erp_crud_module' #Nama Link atau page yang di panggil
    );
  }

  add_action('customer_erp_menu', 'customer_erp_menus');
?>