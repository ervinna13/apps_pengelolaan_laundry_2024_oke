<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: index.php");
	exit();
}

// Ambil data role dari database
$query_role = "SELECT * FROM role";
$result_role = mysqli_query($conn, $query_role);

// Ambil data outlet dari database
$query_outlet = "SELECT * FROM outlet";
$result_outlet = mysqli_query($conn, $query_outlet);

// Proses form tambah user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Ambil data dari form
	$role = $_POST['role'];
	$id_user = $_POST['id_user'];
	$nama = $_POST['nama'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$outlet = $_POST['outlet'];

	// Tambahkan user ke database
	if ($role != 'admin') {
		$insert_query = "INSERT INTO user (id_user, role, nama, username, password, id_outlet) VALUES ('$id_user', '$role', '$nama', '$username', '$password', '$outlet')";
	} else {
		$insert_query = "INSERT INTO user (id_user, role, nama, username, password) VALUES ('$id_user', '$role', '$nama', '$username', '$password')";
	}
	$insert_result = mysqli_query($conn, $insert_query);


	if ($insert_result) {
		echo '<script>alert("DATA USER BERHASIL DITAMBAHKAN!"); window.location.href = "user.php";</script>';
		exit();
	} else {
		// Handle error jika query insert tidak berhasil
		die("Error: " . mysqli_error($conn));
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../layouts/head.php'); ?>

<body>
	<div class="main-wrapper">
		<?php include('../layouts/header.php'); ?>
		<?php include('../layouts/sidebar.php'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title mt-5">Tambah User</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form action="" method="post">
							<div class="row formtype">
								<div class="col-md-12">
									<div class="form-group">
										<label for="role">Role</label>
										<select class="form-control" id="role" name="role" required>
											<?php
											$enum_values = mysqli_fetch_assoc(mysqli_query($conn, "SHOW COLUMNS FROM user LIKE 'role'"))['Type'];
											preg_match('/enum\((.*)\)$/', $enum_values, $matches);
											$enum = str_getcsv($matches[1], ",", "'");
											foreach ($enum as $value) {
												echo '<option value="' . $value . '">' . $value . '</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group" id="outlet_group" style="display: none;">
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
									<div class="form-group" id="id_user_group" style="display: none;">
										<label for="id_user">ID User</label>
										<input type="text" class="form-control" id="id_user" name="id_user" readonly>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="nama">Nama</label>
										<input type="text" class="form-control" id="nama" name="nama" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="username">Username</label>
										<input type="text" class="form-control" id="username" name="username" readonly>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="password">Password</label>
										<input type="text" class="form-control" id="password" name="password" readonly>
									</div>
								</div>
							</div>
							<a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
									class="fas fa-arrow-left"></i> Back
							</a>
							<button type="submit" class="btn btn-success">Tambah User</button>
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
	<script>
		$(document).ready(function () {
			$("#nama").on("input", function () {
				generateUser();
			});
			$("#role").change(function () {
				if ($(this).val() !== 'admin') {
					$("#outlet_group").show();
				} else {
					$("#outlet_group").hide();
				}
			});
		});

		function generateUser() {
			var selectedRole = $("#role").val();
			var randomNum = Math.floor(Math.random() * 10000000000);
			var randomUser = Math.floor(Math.random() * 1000000);
			var randomPw = Math.floor(Math.random() * 10000);

			var generatedIdUser = selectedRole.substring(0, 3) + randomNum;
			$("#id_user").val(generatedIdUser);

			// Ambil nama dari input dan pisahkan menggunakan spasi
			var nama = $("#nama").val();
			var namaDepan = nama.trim().split(" ")[0]; // Ambil bagian depan dari nama
			var generatedUsername = namaDepan.toLowerCase() + randomUser; // Ubah menjadi huruf kecil
			$("#username").val(generatedUsername); // Set nilai username pada elemen input


			var generatedPassword = selectedRole.substring(0, 3) + $("#nama").val().substring(0, 3).toLowerCase() + randomPw;
			$("#password").val(generatedPassword);
		}
	</script>
</body>

</html>