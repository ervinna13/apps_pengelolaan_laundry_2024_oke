<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: ../index.php");
	exit();
}


// Proses form tambah diskon
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Ambil data dari form
	$id_diskon = $_POST['id_diskon'];
	$diskon = $_POST['diskon'];
	$total_harga = $_POST['total_harga'];

	// Tambahkan diskon ke database
	$insert_query = "INSERT INTO diskon (id_diskon, diskon, total_harga) VALUES ('$id_diskon', '$diskon', '$total_harga')";
	$insert_result = mysqli_query($conn, $insert_query);

	if ($insert_result) {
		echo '<script>alert("DATA DISKON BERHASIL DITAMBAHKAN!"); window.location.href = "diskon.php";</script>';
		// header("Location: data_diskon.php");
		exit();
	} else {
		// Handle error jika query insert tidak berhasil
		die("Error: " . mysqli_error($conn));
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
							<h3 class="page-title mt-5">Tambah diskon</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form action="" method="post">
							<div class="row formtype">
								<div class="col-md-12">
									<div class="form-group" id="id_diskon">
										<label for="id_diskon">ID diskon</label>
										<?php echo '<input class="form-control" type="text" readonly value="DIS' . rand(100, 999) . '" name="id_diskon" placeholder="id_diskon" required>'; ?>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group" id="diskon">
										<label for="diskon">Diskon (%)</label>
										<input type="text" class="form-control" id="diskon" name="diskon"
											placeholder="Diskon (%)" required>
									</div>
								</div>
								
								<div class="col-md-12">
									<div class="form-group">
										<label for="total_harga">Total Harga</label>
										<input type="number" class="form-control" id="total_harga" name="total_harga"
											placeholder="TOtal Harga" required>
									</div>
								</div>

							</div>
							<a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
									class="fas fa-arrow-left"></i> Back
							</a>
							<button type="submit" name="submit" class="btn btn-primary buttonedit1">Tambah
								Diskon</button>
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