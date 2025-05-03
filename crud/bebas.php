<?php
  /*
    Plugin Name: CRUDX Koe
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
      'judulnya nek ape', #title dokumen
      'CRUD', #nama menu yang tampil
      'edit_posts', #capabilities
      'utama', #nama link atau page yang dipanggil tapi bukan nama file
      'modulapa' #nama fungsi modul yang dikerjakan
    );
  }

  add_action('admin_menu', 'menukik');
?>