<html>
<head>
  <title>Form Pelanggan</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="p-4">

  <div class="container">
    <h2 class="mb-4">Form Input Pelanggan</h2>
    <form action="simpan_pelanggan.php" method="post">
      
      <div class="form-group">
        <label for="kode_pelanggan">Kode Pelanggan</label>
        <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" maxlength="5" required>
      </div>

      <div class="form-group">
        <label for="nama_pelanggan">Nama Pelanggan</label>
        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" maxlength="60" required>
      </div>

      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>

</body>
</html>

