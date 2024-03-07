<?php
session_start();
// Include file koneksi
include('../koneksi/koneksi.php');

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: ../index.php"); // Redirect ke halaman login jika tidak memenuhi syarat
	exit();
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Mendapatkan data dari formulir
	$outlet = $_POST['outlet'];
	$id_paket = $_POST['id_paket'];
	$jenis = $_POST['jenis'];
	$nama_paket = $_POST['nama_paket'];
	$harga = $_POST['harga'];
	$estimasi = $_POST['estimasi'];

	// Proses unggah gambar
	if (isset($_FILES['foto_paket']) && $_FILES['foto_paket']['error'] === UPLOAD_ERR_OK) {
		$file_tmp = $_FILES['foto_paket']['tmp_name'];
		$file_name = $_FILES['foto_paket']['name'];
		$file_size = $_FILES['foto_paket']['size'];
		$file_type = $_FILES['foto_paket']['type'];

		// Izinkan hanya ekstensi gambar tertentu
		$allowed_extensions = array('jpg', 'jpeg', 'png');
		$file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

		if (!in_array($file_extension, $allowed_extensions)) {
			echo '<script>alert("Ekstensi file tidak diizinkan. Silakan unggah file gambar dengan ekstensi JPG, JPEG, dan PNG."); window.history.back() </script>';
			exit();
		}

		// Set maksimum ukuran file (1MB)
		$max_file_size = 1024 * 1024; // 1 MB

		if ($file_size > $max_file_size) {
			echo '<script>alert("Ukuran file terlalu besar. Maksimum ukuran file adalah 1MB."); </script>';
			exit();
		}

		// Generate nama file unik
		$unique_file_name = uniqid() . '_' . $file_name;

		// Tentukan folder untuk menyimpan gambar yang diunggah
		$upload_dir = '../uploads/';

		// Pindahkan file yang diunggah ke folder yang ditentukan
		if (move_uploaded_file($file_tmp, $upload_dir . $unique_file_name)) {
			// Masukkan data ke dalam database, termasuk nama file unik
			$query = "INSERT INTO paket (id_paket, id_outlet, jenis, nama_paket, harga, estimasi, foto_pkt) VALUES ('$id_paket', '$outlet', '$jenis', '$nama_paket', '$harga', '$estimasi', '$unique_file_name')";
			if ($conn->query($query) === TRUE) {
				echo '<script>alert("DATA paket BERHASIL DITAMBAHKAN!"); window.location.href = "paket.php";</script>';
			} else {
				echo "Error: " . $query . "<br>" . $conn->error;
			}
		} else {
			echo '<script>alert("Maaf, terjadi kesalahan saat mengunggah file."); </script>';
		}
	} else {

		echo '<script>alert("Mohon pilih file gambar untuk paket Anda."); </script>';
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('../layouts/head.php');
?>


<body>
	<div class="main-wrapper">
		<?php include('../layouts/header.php'); ?>
		<?php include('../layouts/sidebar.php'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title mt-5">Tambah paket</h3>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="row formtype">
								
							<div class="col-md-12">
									<div class="form-group" id="id_paket">
										<label for="id_paket">ID Paket</label>
										<?php echo '<input class="form-control" type="text" readonly value="PAK' . rand(1000000000, 9999999999) . '" name="id_paket" placeholder="id_paket" required>'; ?>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="outlet">Nama Outlet</label>
										<select class="form-control" id="outlet" name="outlet" required>
											<option value="outlet"><-- Pilih Nama Outlet --></option>
											<?php

											$query = "SELECT * FROM outlet";
											$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_assoc($result)) { ?>
												<option value="<?= $row['id_outlet'] ?>">
													<?= $row['nama'] ?>
												</option>
												<?php
											}
											?>

										</select>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label for="jenis">Jenis</label>
										<select class="form-control" id="jenis" name="jenis" required>
											<option><--- Silahkan Pilih Jenis Paket ---> </option>
											<option value="kiloan">Kiloan</option>
											<option value="selimut">Selimut</option>
											<option value="bed_cover">Bed Cover</option>
											<option value="kaos">Kaos</option>
											<option value="lain">Lain-lain</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="nama_paket">Nama Paket</label>
										<input type="text" class="form-control" id="nama_paket" name="nama_paket"
											placeholder="Isi Nama Paket" required>
									</div>
								</div>
								<div class="col-md-6">

									<div class="form-group">
										<label for="harga">Harga</label>
										<input type="number" class="form-control" id="harga" name="harga"
											placeholder="Isi Harga" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="estimasi">Estimasi Pengerjaan:</label>
										<div style="display: flex; align-items: center;">
											<input class="form-control" type="number" id="estimasi" name="estimasi"
												min="1" required placeholder="Estimasi">

										</div>
										<span style="color:red;">*Perkiraan Hari</span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="foto_paket">Gambar paket</label>
										<input type="file" class="form-control-file" id="foto_paket" name="foto_paket"
											accept="image/*" onchange="previewImage(this);">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<img id="preview" src="#" alt="Preview Gambar"
											style="display: none; width: 100px; height: 100px; margin-top: 10px;">
									</div>
								</div>
							</div>
							<a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
									class="fas fa-arrow-left"></i> Back
							</a>
							<button type="submit" name="submit" class="btn btn-primary buttonedit1">Tambah
								paket</button>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="../assets/js/jquery-3.5.1.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/moment.min.js"></script>
	<script src="../assets/js/bootstrap-datetimepicker.min.js"></script>
	<script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../assets/plugins/raphael/raphael.min.js"></script>
	<script src="../assets/js/script.js"></script>
	<script>
		$(function () {
			$('#datetimepicker3').datetimepicker({
				format: 'LT'
			});
		});
		// Fungsi untuk menampilkan gambar saat dipilih
		function previewImage(input) {
			var preview = document.getElementById('preview');
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					preview.src = e.target.result;
					preview.style.display = 'block';
				}

				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
</body>

</html>