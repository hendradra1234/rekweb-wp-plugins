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
  function crud_module() {
  	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	// Periksa koneksi
	if ($conn->connect_error) {
	    die("Koneksi gagal: " . $conn->connect_error);
	}
    include "utama.php";
  }
?>

<?php
  function mainMenu() {
    add_menu_page(
      'Menu Plugin ISB', # Title
      'crudx', # Nama Menu yang tampil
      'read', # Capability
      'main_Crudx',# Nama Link
      'crud_module' #Nama Link atau page yang di panggil
    );
  }

  add_action('admin_menu', 'mainMenu');
?>