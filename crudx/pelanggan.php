<?php
	$err_msg = "";
	$kode_pelanggan = $nama_pelanggan = $alamat = "";

	if (isset($_POST["btnsimpan"])):

		// Tangkap data dari formulir
		$nama_pelanggan = $_POST['nama_pelanggan'];
		$alamat = $_POST['alamat'];

		if (isset($_GET["aksi"])):
			$aksi = $_GET["aksi"];
			if ($aksi=="ubah"):
				$kode_pelanggan = $_GET['kode_pelanggan'];
				// Query untuk mengupdate data pelanggan berdasarkan kode pelanggan
				$sql = "UPDATE tbl_pelanggan SET nama_pelanggan = ?, alamat = ? WHERE kode_pelanggan = ?";

				// Gunakan prepared statement untuk keamanan
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("sss", $nama_pelanggan, $alamat, $kode_pelanggan);

				// Eksekusi query dan cek hasil
				if ($stmt->execute()) {
				    $err_msg = '<div class="alert alert-success">
							    <strong>Success!</strong> Data pelanggan berhasil diperbaharui!
							  </div>';
				} else {
				    $err_msg = '<div class="alert alert-danger">
		    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
				}
			endif;
		else:
			$kode_pelanggan = $_POST['kode_pelanggan'];	
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
		endif;

		// Tutup koneksi
		$stmt->close();

		echo '<meta http-equiv="refresh" content="2;url=admin.php?page=main_crudx&hal=pelanggan.php">';
	endif;

	// Query untuk mendapatkan kode pelanggan terakhir
	$sql = "SELECT MAX(kode_pelanggan) AS max_kode FROM tbl_pelanggan";
	$result = $conn->query($sql);

	if ($result) {
	    $row = $result->fetch_assoc();
	    $max_kode = $row['max_kode']; // Contoh: "P0003"

	    // Jika belum ada data, mulai dari P0001
	    if ($max_kode) {
	        $angka = intval(substr($max_kode, 1)) + 1; // Ambil angka lalu tambahkan 1
	        $kode_pelanggan = "P" . str_pad($angka, 4, "0", STR_PAD_LEFT); // Format P000X
	    } else {
	        $kode_pelanggan = "P0001"; // Jika belum ada data, mulai dari P0001
	    }
	}

	// Pastikan parameter kode_pelanggan tersedia
	if (isset($_GET["aksi"])):
		$aksi = $_GET["aksi"];
		$kode_pelanggan = $_GET['kode_pelanggan'];

		if ($aksi=="ubah"):
			$sql = "SELECT * FROM tbl_pelanggan WHERE kode_pelanggan = ?";

		    // Gunakan prepared statement untuk keamanan
		    $stmt = $conn->prepare($sql);
		    $stmt->bind_param("s", $kode_pelanggan);

		    // Eksekusi query dan cek hasil
		    if ($stmt->execute()) {
		        $result = $stmt->get_result();
		        if ($result->num_rows > 0) {
		            // Ambil data pelanggan ke dalam variabel
		            $row = $result->fetch_assoc();
		            $kode_pelanggan = $row['kode_pelanggan'];
		            $nama_pelanggan = $row['nama_pelanggan'];
		            $alamat = $row['alamat'];
		        } else {
		            echo "Data pelanggan tidak ditemukan!";
		        }
		    } 
		endif;

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
		    echo '<meta http-equiv="refresh" content="2;url=admin.php?page=main_crudx&hal=pelanggan.php">';
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
			<input <?= (!empty($kode_pelanggan)) ? "readonly" : "" ?> value="<?= $kode_pelanggan ?>" type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" maxlength="5" required>
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
                                <a href='admin.php?page=main_crudx&hal=pelanggan.php&aksi=edit&kode_pelanggan=" . urlencode($row['kode_pelanggan']) . "' class='btn btn-warning btn-sm'>
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
	function confirmUpdate(kode_pelanggan) {
	    if (confirm("Apakah Anda yakin ingin menghapus pelanggan dengan kode " + kode_pelanggan + "?")) {
	        window.location.href = "admin.php?page=main_crudx&hal=pelanggan.php&aksi=hapus&kode_pelanggan=" + kode_pelanggan;
	    }
	}
</script>

<?php
	$conn->close();
?>