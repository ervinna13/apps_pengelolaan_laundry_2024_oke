<?php
session_start();
// Include file koneksi
include('../koneksi/koneksi.php');

// Periksa apakah pengguna sudah login dan memiliki peran kasir
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'kasir') {
	header("Location: ../index.php"); // Redirect ke halaman login jika tidak memenuhi syarat
	exit();
}
// Check if the form is submitted
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Retrieve form data
	$id_member = htmlspecialchars($_POST['id_member']);
	$nama = htmlspecialchars($_POST['nama']);
	$alamat = $_POST['alamat'];
	$tlp = $_POST['tlp'];
	$jenis_kelamin = $_POST['jenis_kelamin'];

	// Insert data into the database
	$query = "INSERT INTO member (id_member, nama, alamat, tlp, jenis_kelamin) VALUES ('$id_member', '$nama','$alamat','$tlp', '$jenis_kelamin')";
	if ($conn->query($query) === TRUE) {
		echo '<script>alert("DATA PELANGGAN BERHASIL DITAMBAHKAN!"); window.location.href = "pelanggan.php";</script>';
	} else {
		echo "Error: " . $query . "<br>" . $conn->error;
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
							<h3 class="page-title mt-5">Tambah Pelanggan</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form action="" method="post">
							<div class="row formtype">
								<div class="col-md-12">
									<div class="form-group">
										<label>ID Pelanggan</label>
										<?php echo '<input class="form-control" type="text" readonly value="MEM' . rand(1000000000, 9999999999) . '" name="id_member" placeholder="id_member" required>'; ?>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>Nama</label>
										<input type="text" class="form-control" id="nama" name="nama"
											placeholder="Nama Pelanggan" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Jenis Kelamin</label><br>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="jenis_kelamin"
												id="laki-laki" value="Laki-laki" required>
											<label class="form-check-label" for="laki-laki">Laki-laki</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="jenis_kelamin"
												id="perempuan" value="Perempuan" required>
											<label class="form-check-label" for="perempuan">Perempuan</label>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="tlp">No. Telepon</label>
										<input type="tel" class="form-control" id="tlp" name="tlp" maxlength="13"
											oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
											required placeholder="Nomor Telepon">
										<!-- <small class="form-text text-muted">Hanya angka yang diizinkan.</small> -->
									</div>

								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Alamat</label>
										<textarea class="form-control" rows="5" id="alamat" name="alamat"
											placeholder="Alamat" required></textarea>
									</div>
								</div>
							</div>
							<a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
									class="fas fa-arrow-left"></i> Back
							</a>
							<button type="submit" name="submit" class="btn btn-primary buttonedit1">Tambah
								member</button>

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
	</script>
</body>

</html>