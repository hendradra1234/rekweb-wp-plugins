<?php
	$err_msg = "";
	if (isset($_POST["btnsimpan"])):
		// Tangkap data dari formulir
		$kode_pelanggan = $_POST['kode_pelanggan'];
		$nama_pelanggan = $_POST['nama_pelanggan'];
		$alamat = $_POST['alamat'];

		// Query untuk menyimpan data
		$sql = "INSERT INTO tbl_pelanggan (kode_pelanggan, nama_pelanggan, alamat) VALUES (?, ?, ?)";

		// Gunakan prepared statement untuk keamanan
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $kode_pelanggan, $nama_pelanggan, $alamat);

		// Eksekusi query dan cek hasil
		if ($stmt->execute()) {
		    $err_msg = '<div class="alert alert-success">
					    <strong>Success!</strong> Data pelanggan berhasil disimpan!
					  </div>';
		} else {
		    $err_msg = '<div class="alert alert-danger">
    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
		}

		// Tutup koneksi
		$stmt->close();
	endif;

	// Pastikan parameter kode_pelanggan tersedia
	if (isset($_GET["aksi"])):
		$aksi = $_GET["aksi"];
		$kode_pelanggan = $_GET['kode_pelanggan'];
		if ($aksi=="hapus"):
			// Query untuk menghapus data
		    $sql = "DELETE FROM tbl_pelanggan WHERE kode_pelanggan = ?";

		    // Gunakan prepared statement untuk keamanan
		    $stmt = $conn->prepare($sql);
		    $stmt->bind_param("s", $kode_pelanggan);

		    // Eksekusi query dan cek hasil
		    if ($stmt->execute()) {
		        $err_msg = '<div class="alert alert-success">
					    <strong>Success!</strong> Data pelanggan berhasil dihapus!
					  </div>';
		    } else {
		        $err_msg = '<div class="alert alert-danger">
    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
		    }

		    // Tutup koneksi
		    $stmt->close();
		endif;
	endif;
?>


<div class="container mt-5">
	<?= $err_msg ?>
    <h2 class="text-center">Form Isian Data Pelanggan</h2>
    <form method="POST">
        <!-- Kode Pelanggan -->
        <div class="form-group">
            <label for="kode_pelanggan">Kode Pelanggan</label>
            <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" maxlength="5" required>
        </div>

        <!-- Nama Pelanggan -->
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" maxlength="60" required>
        </div>

        <!-- Alamat Pelanggan -->
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" name="btnsimpan" class="btn btn-primary">Simpan Data</button>
    </form>

    <?php
    	$sql = "SELECT * FROM tbl_pelanggan";
		$result = $conn->query($sql);
    ?>

    <h2 class="text-center">Data Pelanggan</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
            	<th>Aksi</th>
                <th>Kode Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>
                                <a href='edit_pelanggan.php?kode_pelanggan=" . urlencode($row['kode_pelanggan']) . "' class='btn btn-warning btn-sm'>
                                    <i class='fa fa-edit'></i> Ubah
                                </a>
                                <button onclick='confirmDelete(\"" . $row['kode_pelanggan'] . "\")' class='btn btn-danger btn-sm'>
                                    <i class='fa fa-trash'></i> Hapus
                                </button>
                              </td>";
                    echo "<td>" . htmlspecialchars($row['kode_pelanggan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_pelanggan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>Tidak ada data pelanggan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
	function confirmDelete(kode_pelanggan) {
	    if (confirm("Apakah Anda yakin ingin menghapus pelanggan dengan kode " + kode_pelanggan + "?")) {
	        window.location.href = "admin.php?page=utama&hal=pelanggan.php&aksi=hapus&kode_pelanggan=" + kode_pelanggan;
	    }
	}
</script>

<?php
	$conn->close();
?>