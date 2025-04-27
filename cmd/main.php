<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi</title>
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body, html {
      height: 100%;
    }
    #main-content {
      height: calc(100vh - 56px); /* 56px adalah tinggi navbar */
    }
    iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
  </style>
</head>
<body>

  <!-- Navigasi -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Aplikasi</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">

        <!-- Master -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="masterDropdown" data-toggle="dropdown">Master</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="admin.php?page=utama&dest=pelanggam.php" target="content-frame">Pelanggan</a>
            <a class="dropdown-item" href="admin.php?page=utama&dest=barang.php" target="content-frame">Barang</a>
            <a class="dropdown-item" href="admin.php?page=utama&dest=supplier.php" target="content-frame">Supplier</a>
          </div>
        </li>

        <!-- Transaksi -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="transaksiDropdown" data-toggle="dropdown">Transaksi</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="admin.php?page=utama&dest=pemesanan.php" target="content-frame">Pemesanan</a>
            <a class="dropdown-item" href="admin.php?page=utama&dest=cetak_invoice.php" target="content-frame">Cetak Invoice</a>
          </div>
        </li>

        <!-- Laporan -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" data-toggle="dropdown">Laporan</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="laporan_penjualan.php" target="content-frame">Laporan Penjualan</a>
          </div>
        </li>

      </ul>
    </div>
  </nav>

  <!-- Konten -->
  <div id="main-content">
        <?php
            if (isset($_GET["dest"]) && (!empty($_GET["dest"]))):
                include($_GET["dest"]);
            endif;
        ?>
    <!-- <iframe name="content-frame" src=""></iframe> -->
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>