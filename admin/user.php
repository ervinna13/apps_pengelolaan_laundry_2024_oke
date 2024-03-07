<?php
include('../koneksi/koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
	header("Location: ../index.php"); // Redirect ke halaman login jika tidak memenuhi syarat
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include('../layouts/head.php'); ?>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
</head>

<body>
	<div class="main-wrapper">
		<?php include('../layouts/header.php'); ?>
		<?php include('../layouts/sidebar.php'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<div class="mt-5">
								<h4 class="card-title float-left mt-2">User</h4>
								<a href="tambah_user.php" class="btn btn-primary float-right veiwbutton"> <i
										class="fas fa-plus-circle"></i></a>
								<button class="btn btn-primary float-right veiwbutton" style="margin-right: 10px;"
									class="btn btn-primary" onclick="window.location.reload();">
									<i class="fas fa-sync-alt"></i>
								</button>
								<a href="cetak_user1.php" target="_blank"
									class="btn btn-primary float-right veiwbutton" style="margin-right: 10px;"><i class="fa fa-print"></i> </a>

							</div>

						</div>
					</div>
				</div>

				<br>
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table id="userTable" class="display" style="width:100%">
										<thead>
											<tr>
												<th>No.</th>
												<th>ID User</th>
												<th>Nama</th>
												<th>Username</th>
												<th>Password</th>
												<th>Nama Outlet</th>
												<th>Role</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
										<tbody>

											<?php

											$query = "SELECT user.*, outlet.nama AS nama_outlet FROM user LEFT JOIN outlet ON user.id_outlet = outlet.id_outlet";
											$result = mysqli_query($conn, $query);
											$nomor = 1;
											while ($row = mysqli_fetch_assoc($result)) {
												echo '<tr>';
												echo '<td>' . $nomor . '</td>';
												echo '<td >' . $row['id_user'] . '</td>';
												echo '<td >' . $row['nama'] . '</td>';
												echo '<td >' . $row['username'] . '</td>';
												echo '<td >' . $row['password'] . '</td>';
												echo '<td >' . $row['nama_outlet'] . '</td>';
												echo '<td >' . $row['role'] . '</td>';
												echo
													'<td class="text-right">
                                                        <div class="dropdown dropdown-action"> 
                                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v ellipse_color"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right"> 
                                                                <a class="dropdown-item" href="detail_user.php?id=' . $row['id_user'] . '"><i class="fas fa-info-circle m-r-5"></i> Detail</a> 
                                                                <a class="dropdown-item" href="edit_user.php?id=' . $row['id_user'] . '"><i class="fas fa-pencil-alt m-r-5"></i> Edit</a> 
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user_' . $row['id_user'] . '">
                                                                    <i class="fas fa-trash-alt m-r-5"></i> Delete
                                                                </a>
																<a href="cetak_user.php?id=' . $row['id_user'] . '" target="_blank"
				class="btn btn-block btn-outline-primary active"><i class="fa fa-print"></i> </a>
                                                            </div>
                                                        </div>
                                                    </td>';
												echo '</tr>';
												echo '</tr>';
												$nomor++;
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
			<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
			<!-- Modal Konfirmasi Hapus -->
			<?php
			$query = "SELECT * FROM user";
			$result = mysqli_query($conn, $query);
			while ($row = mysqli_fetch_assoc($result)) {
				?>
				<div id="delete_user_<?php echo $row['id_user']; ?>" class="modal fade delete-modal" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-body text-center">
								<img src="../assets/img/sent.png" alt="" width="50" height="46">
								<h3 class="delete_class">Apakah kamu yakin ingin menghapus data <b>
										<?php echo $row['nama']; ?>
									</b> ini?</h3>
								<input type="hidden" id="deleteuserId_<?php echo $row['id_user']; ?>"
									value="<?php echo $row['id_user']; ?>">
								<div class="m-t-20">
									<a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
									<button type="button" class="btn btn-danger"
										onclick="deleteuser('<?php echo $row['id_user']; ?>')">Delete</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>

		</div>
	</div>
	<script>
		$(document).ready(function () {
			$('#userTable').DataTable();
		})
	</script>
	<script>
		$('#delete_user_<?php echo $row['id_user']; ?>').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var id_user = button.data('id');
			document.getElementById('deleteuserId_<?php echo $row['id_user']; ?>').value = id_user;
		});

		function deleteuser(id_user) {
			// Lakukan penghapusan dengan menggunakan id_user
			// Tambahkan kode penghapusan sesuai dengan logika bisnis Anda
			window.location.href = "hapus_user.php?id=" + id_user;

			// Tutup modal setelah penghapusan (sesuai kebutuhan)
			$('#delete_user_' + id_user).modal('hide');
		}
	</script>
	<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../assets/plugins/raphael/raphael.min.js"></script>
	<script src="../assets/plugins/morris/morris.min.js"></script>
	<script src="../assets/js/chart.morris.js"></script>
	<script src="../assets/js/script.js"></script>
</body>

</html>