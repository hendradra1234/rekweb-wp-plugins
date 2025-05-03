<?php
	$err_msg = "";
	$kode_barang = $nama_barang = $harga = "";

	if (isset($_POST["btnsimpan"])):

		// Tangkap data dari formulir
		
		$nama_barang = $_POST['nama_barang'];
		$harga = $_POST['harga'];

		if (isset($_GET["aksi"])):
			$aksi = $_GET["aksi"];
			if ($aksi=="ubah"):
				$kode_barang = $_GET['kode_barang'];
				// Query untuk mengupdate data Barang berdasarkan kode Barang
				$sql = "UPDATE tbl_barang SET nama_barang = ?, harga = ? WHERE kode_barang = ?";

				// Gunakan prepared statement untuk keamanan
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("sss", $nama_barang, $harga, $kode_barang);

				// Eksekusi query dan cek hasil
				if ($stmt->execute()) {
				    $err_msg = '<div class="alert alert-success">
							    <strong>Success!</strong> Data Barang berhasil diperbaharui!
							  </div>';
				} else {
				    $err_msg = '<div class="alert alert-danger">
		    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
				}
			endif;
		else:
			$kode_barang = $_POST['kode_barang'];	
			// Query untuk menyimpan data
			$sql = "INSERT INTO tbl_barang (kode_barang, nama_barang, harga) VALUES (?, ?, ?)";

			// Gunakan prepared statement untuk keamanan
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("sss", $kode_barang, $nama_barang, $harga);

			// Eksekusi query dan cek hasil
			if ($stmt->execute()) {
			    $err_msg = '<div class="alert alert-success">
						    <strong>Success!</strong> Data Barang berhasil disimpan!
						  </div>';
			} else {
			    $err_msg = '<div class="alert alert-danger">
	    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
			}
		endif;

		// Tutup koneksi
		$stmt->close();

		echo '<meta http-equiv="refresh" content="2;url=admin.php?page=main_crudx&hal=barang.php">';
	endif;

	// Query untuk mendapatkan kode Barang terakhir
	$sql = "SELECT MAX(kode_barang) AS max_kode FROM tbl_barang";
	$result = $conn->query($sql);

	if ($result) {
	    $row = $result->fetch_assoc();
	    $max_kode = $row['max_kode']; // Contoh: "P0003"

	    // Jika belum ada data, mulai dari P0001
	    if ($max_kode) {
	        $angka = intval(substr($max_kode, 1)) + 1; // Ambil angka lalu tambahkan 1
	        $kode_barang = "B" . str_pad($angka, 4, "0", STR_PAD_LEFT); // Format P000X
	    } else {
	        $kode_barang = "B0001"; // Jika belum ada data, mulai dari P0001
	    }
	} 
	
	// Pastikan parameter kode_barang tersedia
	if (isset($_GET["aksi"])):
		$aksi = $_GET["aksi"];
		$kode_barang = $_GET['kode_barang'];
		
		if ($aksi=="ubah"):
			$sql = "SELECT * FROM tbl_barang WHERE kode_barang = ?";

		    // Gunakan prepared statement untuk keamanan
		    $stmt = $conn->prepare($sql);
		    $stmt->bind_param("s", $kode_barang);

		    // Eksekusi query dan cek hasil
		    if ($stmt->execute()) {
		        $result = $stmt->get_result();
		        if ($result->num_rows > 0) {
		            // Ambil data Barang ke dalam variabel
		            $row = $result->fetch_assoc();
		            $kode_barang = $row['kode_barang'];
		            $nama_barang = $row['nama_barang'];
		            $harga = $row['harga'];
		        } else {
		            echo "Data Barang tidak ditemukan!";
		        }
		    } 
		endif;

		if ($aksi=="hapus"):
			// Query untuk menghapus data
		    $sql = "DELETE FROM tbl_barang WHERE kode_barang = ?";

		    // Gunakan prepared statement untuk keamanan
		    $stmt = $conn->prepare($sql);
		    $stmt->bind_param("s", $kode_barang);

		    // Eksekusi query dan cek hasil
		    if ($stmt->execute()) {
		        $err_msg = '<div class="alert alert-success">
					    <strong>Success!</strong> Data Barang berhasil dihapus!
					  </div>';
		    } else {
		        $err_msg = '<div class="alert alert-danger">
    						<strong>Danger!</strong> Terjadi kesalahan: ' . $stmt->error . '</div>';
		    }

		    // Tutup koneksi
		    $stmt->close();
		    echo '<meta http-equiv="refresh" content="2;url=admin.php?page=main_crudx&hal=barang.php">';
		endif;
	endif;

	
?>


<div class="container mt-5">
	<?= $err_msg ?>
    <h2 class="text-center">Form Isian Data Barang</h2>
    <form method="POST">
        <!-- Kode Barang -->
        <div class="form-group">
            <label for="kode_barang">Kode Barang</label>
            <input <?= (!empty($kode_barang)) ? "readonly" : "" ?> value="<?= $kode_barang ?>" type="text" class="form-control" id="kode_barang" name="kode_barang" maxlength="5" required>
        </div>

        <!-- Nama Barang -->
        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input value="<?= $nama_barang ?>" type="text" class="form-control" id="nama_barang" name="nama_barang" maxlength="60" required>
        </div>

        <!-- harga Barang -->
        <div class="form-group">
            <label for="harga">Harga</label>
            <input value="<?= $harga ?>" type="number" class="form-control" id="harga" name="harga"  required>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" name="btnsimpan" class="btn btn-primary">Simpan Data</button>
    </form>

    <?php
    	$sql = "SELECT * FROM tbl_barang";
		$result = $conn->query($sql);
    ?>

    <h2 class="text-center">Data Barang</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
            	<th>Aksi</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>
                                <a href='admin.php?page=main_crudx&hal=barang.php&aksi=ubah&kode_barang=" . urlencode($row['kode_barang']) . "' class='btn btn-warning btn-sm'>
                                    <i class='fa fa-edit'></i> Ubah
                                </a>
                                <button onclick='confirmDelete(\"" . $row['kode_barang'] . "\")' class='btn btn-danger btn-sm'>
                                    <i class='fa fa-trash'></i> Hapus
                                </button>
                              </td>";
                    echo "<td>" . htmlspecialchars($row['kode_barang']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                    echo "<td>Rp. " . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>Tidak ada data Barang</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
	function confirmDelete(kode_barang) {
	    if (confirm("Apakah Anda yakin ingin menghapus Barang dengan kode " + kode_barang + "?")) {
	        window.location.href = "admin.php?page=main_crudx&hal=barang.php&aksi=hapus&kode_barang=" + kode_barang;
	    }
	}
</script>

<?php
	$conn->close();
?>