<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Menu Master -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="masterDropdown" data-toggle="dropdown">Master</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="admin.php?page=utama&hal=pelanggan.php" target="contentFrame">Pelanggan</a>
                        <a class="dropdown-item" href="admin.php?page=utama&hal=barang.php" target="contentFrame">Barang</a>
                        <a class="dropdown-item" href="admin.php?page=utama&hal=supplier.php" target="contentFrame">Supplier</a>
                    </div>
                </li>

                <!-- Menu Transaksi -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="transaksiDropdown" data-toggle="dropdown">Transaksi</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="admin.php?page=utama&hal=pemesanan.php" target="contentFrame">Pemesanan</a>
                        <a class="dropdown-item" href="admin.php?page=utama&hal=invoice.php" target="contentFrame">Cetak Invoice</a>
                    </div>
                </li>

                <!-- Menu Laporan -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" data-toggle="dropdown">Laporan</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="admin.php?page=utama&hal=laporan_penjualan.php" target="contentFrame">Laporan Penjualan</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container mt-3">
        <?php
            if (isset($_GET["hal"]) && (!empty($_GET["hal"]))):
                include($_GET["hal"]);
            endif;
        ?>
        <!--<iframe name="contentFrame" width="100%" height="500px" style="border:none;"></iframe>-->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
