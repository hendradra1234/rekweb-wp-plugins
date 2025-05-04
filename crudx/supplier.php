<?php
	$err_msg = "";
	$kode_supplier = $nama_supplier = $alamat = "";

	if (isset($_POST["btnsimpan"])):

		// Tangkap data dari formulir
		$nama_supplier = $_POST['nama_supplier'];
		$alamat = $_POST['alamat'];

		if (isset($_GET["aksi"])):
			$aksi = $_GET["aksi"];
			if ($aksi=="ubah"):
				$kode_supplier = $_GET['kode_supplier'];
				// Query untuk mengupdate data Supplier berdasarkan kode Supplier
				$sql = "UPDATE tbl_supplier SET nama_supplier = ?, alamat = ? WHERE kode_supplier = ?";

				// Gunakan prepared statement untuk keamanan
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("sss", $nama_supplier, $alamat, $kode_supplier);

				// Eksekusi query dan cek hasil
				if ($stmt->execute()) {
				    $err_msg = '<div class="alert alert-success">
							    <strong>Success!</strong> Data Supplier berhasil diperbaharui!
							  </div>';
				} else {
				    $err_msg = '<div class="alert alert-danger">
		    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
				}
			endif;
		else:
			$kode_supplier = $_POST['kode_supplier'];
			// Query untuk menyimpan data
			$sql = "INSERT INTO tbl_supplier (kode_supplier, nama_supplier, alamat) VALUES (?, ?, ?)";

			// Gunakan prepared statement untuk keamanan
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("sss", $kode_supplier, $nama_supplier, $alamat);

			// Eksekusi query dan cek hasil
			if ($stmt->execute()) {
			    $err_msg = '<div class="alert alert-success">
						    <strong>Success!</strong> Data Supplier berhasil disimpan!
						  </div>';
			} else {
			    $err_msg = '<div class="alert alert-danger">
	    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
			}
		endif;
		// Tutup koneksi
		$stmt->close();

		echo '<meta http-equiv="refresh" content="2;url=admin.php?page=main_crudx&hal=supplier.php">';
	endif;

	// Query untuk mendapatkan kode Supplier terakhir
	$sql = "SELECT MAX(kode_supplier) AS max_kode FROM tbl_supplier";
	$result = $conn->query($sql);

	if ($result) {
	    $row = $result->fetch_assoc();
	    $max_kode = $row['max_kode']; // Contoh: "P0003"

	    // Jika belum ada data, mulai dari P0001
	    if ($max_kode) {
	        $angka = intval(substr($max_kode, 1)) + 1; // Ambil angka lalu tambahkan 1
	        $kode_supplier = "B" . str_pad($angka, 4, "0", STR_PAD_LEFT); // Format P000X
	    } else {
	        $kode_supplier = "B0001"; // Jika belum ada data, mulai dari P0001
	    }
	}
	// Pastikan parameter kode_supplier tersedia
	if (isset($_GET["aksi"])):
		$aksi = $_GET["aksi"];
		$kode_supplier = $_GET['kode_supplier'];

		if ($aksi=="ubah"):
			$sql = "SELECT * FROM tbl_supplier WHERE kode_supplier = ?";

		    // Gunakan prepared statement untuk keamanan
		    $stmt = $conn->prepare($sql);
		    $stmt->bind_param("s", $kode_supplier);

		    // Eksekusi query dan cek hasil
		    if ($stmt->execute()) {
		        $result = $stmt->get_result();
		        if ($result->num_rows > 0) {
		            // Ambil data Supplier ke dalam variabel
		            $row = $result->fetch_assoc();
		            $kode_supplier = $row['kode_supplier'];
		            $nama_supplier = $row['nama_supplier'];
		            $alamat = $row['alamat'];
		        } else {
		            echo "Data Supplier tidak ditemukan!";
		        }
		    } 
		endif;

		if ($aksi=="hapus"):
			// Query untuk menghapus data
		    $sql = "DELETE FROM tbl_supplier WHERE kode_supplier = ?";

		    // Gunakan prepared statement untuk keamanan
		    $stmt = $conn->prepare($sql);
		    $stmt->bind_param("s", $kode_supplier);

		    // Eksekusi query dan cek hasil
		    if ($stmt->execute()) {
		        $err_msg = '<div class="alert alert-success">
					    <strong>Success!</strong> Data Supplier berhasil dihapus!
					  </div>';
		    } else {
		        $err_msg = '<div class="alert alert-danger">
    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
		    }

		    // Tutup koneksi
		    $stmt->close();
		    echo '<meta http-equiv="refresh" content="2;url=admin.php?page=main_crudx&hal=supplier.php">';
		endif;
	endif;
?>


<div class="container mt-5">
	<?= $err_msg ?>
    <h2 class="text-center">Form Isian Data Supplier</h2>
    <form method="POST">
        <!-- Kode Supplier -->
        <div class="form-group">
            <label for="kode_supplier">Kode Supplier</label>
            <input <?= (!empty($kode_supplier)) ? "readonly" : "" ?> value="<?= $kode_supplier ?>" type="text" class="form-control" id="kode_supplier" name="kode_supplier" maxlength="5" required>
        </div>

        <!-- Nama Supplier -->
        <div class="form-group">
            <label for="nama_supplier">Nama Supplier</label>
            <input value="<?= $nama_supplier ?>" type="text" class="form-control" id="nama_supplier" name="nama_supplier" maxlength="60" required>
        </div>

        <!-- alamat Supplier -->
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $alamat ?></textarea>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" name="btnsimpan" class="btn btn-primary">Simpan Data</button>
    </form>

    <?php
    	$sql = "SELECT * FROM tbl_supplier";
		$result = $conn->query($sql);
    ?>

    <h2 class="text-center">Data Supplier</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
            	<th>Aksi</th>
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>
                                <a href='admin.php?page=main_crudx&hal=supplier.php&aksi=ubah&kode_supplier=" . urlencode($row['kode_supplier']) . "' class='btn btn-warning btn-sm'>
                                    <i class='fa fa-edit'></i> Ubah
                                </a>
                                <button onclick='confirmDelete(\"" . $row['kode_supplier'] . "\")' class='btn btn-danger btn-sm'>
                                    <i class='fa fa-trash'></i> Hapus
                                </button>
                              </td>";
                    echo "<td>" . htmlspecialchars($row['kode_supplier']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_supplier']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>Tidak ada data Supplier</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
	function confirmDelete(kode_supplier) {
	    if (confirm("Apakah Anda yakin ingin menghapus Supplier dengan kode " + kode_supplier + "?")) {
	        window.location.href = "admin.php?page=main_crudx&hal=supplier.php&aksi=hapus&kode_supplier=" + kode_supplier;
	    }
	}
</script>

<?php
	$conn->close();
?>