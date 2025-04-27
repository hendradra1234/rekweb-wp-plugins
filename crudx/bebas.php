<?php
  /*
    Plugin Name: CRUDX Plugin
    Plugin URI: https://id.wordpress.org/plugins/crudx/
    Description: Saya belajar membuat plugin CRUD pertama di backend Wordpress
    Version: 0.1
    Author: Yohanes Setiawan Japriadi
    Author URI: https://www.facebook.com/kelasberat88
    License: GPL2
  */
?>

<?php
  function modulapa() {
  	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	// Periksa koneksi
	if ($conn->connect_error) {
	    die("Koneksi gagal: " . $conn->connect_error);
	}
    include "utama.php";
  }
?>

<?php
  function menukik() {
    add_menu_page(
      'Menu Plugin ISB', # Title
      'crud', # Nama Menu yang tampil
      'read', # Capability
      'tes_plungin',# Nama Link
      'crud_module' #Nama Link atau page yang di panggil
    );
  }

  add_action('admin_menu', 'menukik');
?>