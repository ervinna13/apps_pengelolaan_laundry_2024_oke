<?php
include '../koneksi/koneksi.php';

// Ambil nama pengguna berdasarkan ID pengguna yang disimpan dalam sesi
$id_user = $_SESSION['id_user'];
$query_user = "SELECT role, nama, username FROM user WHERE id_user = '$id_user'";
$result_user = mysqli_query($conn, $query_user);

if (!$result_user) {
	echo "Error: " . $query_user . "<br>" . mysqli_error($conn);
	exit();
}

$row_user = mysqli_fetch_assoc($result_user);
$nama = $row_user['nama'];
$username = $row_user['username'];
$role = $row_user['role'];

$querySistem = mysqli_query($conn, "SELECT * from sistem ");
if ($querySistem) {
	$sistem = mysqli_fetch_assoc($querySistem);
} else {
	die("Error: " . mysqli_error($conn));
}
?>
<div class="header">
	<div class="header-left">
		<a href="index.php" class="logo"> <img src="../assets/img/logo2.png" width="50" height="70" alt="logo"> <span
				class="logoclass">
				<?= $sistem['apk_name']; ?>
			</span> </a>
		<!-- <a href="index.php" class="logo logo-small"> <img src="../assets/img/ly1.png" alt="Logo" width="30" height="30">
		</a> -->
		<a href="index.php" class="logo logo-small"> <img src="../assets/img/logo2.png" alt="Logo" width="30"
				height="30">
		</a>
	</div>
	<a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
	<a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a>
	<ul class="nav user-menu">
		<li class="nav-item dropdown has-arrow">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img
						class="rounded-circle" src="../assets/img/profiles/profil.png" width="31" alt="admin"></span>
			</a>
			<div class="dropdown-menu">
				<div class="user-header">
					<div class="avatar avatar-sm"> <img src="../assets/img/profiles/profil.png" alt="User Image"
							class="avatar-img rounded-circle"> </div>
					<div class="user-text">
						<!-- <h6><?php echo $nama; ?></h6> -->
						<h6>
							<?= $role; ?>
						</h6>
						<p class="text-muted mb-0">
							<?= $nama; ?>
						</p>
					</div>
				</div>
				<?php if ($_SESSION['role'] == 'admin') { ?>
					<a class="dropdown-item" href="profil.php">Profile</a>
				<?php } ?>
				<!-- <a class="dropdown-item" href="settings.html">Account Settings</a>  -->
				<a class="dropdown-item" href="../logout.php">Logout</a>
			</div>
		</li>
	</ul>

</div>