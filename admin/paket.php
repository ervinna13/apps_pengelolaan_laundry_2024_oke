<?php
include('../koneksi/koneksi.php');
session_start();
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
								<h4 class="card-title float-left mt-2">Paket</h4>
								<a href="tambah_paket.php" class="btn btn-primary float-right veiwbutton"> <i class="fas fa-plus-circle"></i></a>
								<button  class="btn btn-primary float-right veiwbutton " style="margin-right: 10px;"  onclick="window.location.reload();">
									<i class="fas fa-sync-alt"></i> 
								</button>
							</div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
								<table id="userTable" class="display" style="width:100%"><thead>
											<tr>
												<th>No.</th>
												<th>ID paket</th>
												<th>Nama Outlet</th>
												<th>Jenis</th>
												<th>Nama Paket</th>
												<th>Harga</th>
												<th>Estimasi Kerja</th>
												<th>foto</th>
												<th class="text-right">Aksi</th>
											</tr>
										</thead>
										<tbody>

											<?php

											$query = "SELECT * FROM paket  INNER JOIN outlet ON paket.id_outlet=outlet.id_outlet";
											$result = mysqli_query($conn, $query);

											$nomor = 1;
											while ($row = mysqli_fetch_assoc($result)) {
												echo '<tr>';
												echo '<td>' . $nomor . '</td>';
												echo '<td >' . $row['id_paket'] . '</td>';
												echo '<td >' . $row['nama'] . '</td>';
												echo '<td >' . $row['jenis'] . '</td>';
												echo '<td >' . $row['nama_paket'] . '</td>';
												echo '<td> Rp. ' . number_format($row['harga'], 0, ',', '.') . '</td>';
												echo '<td >' . $row['estimasi'] . ' hari'.'</td>';
												echo '<td><img src="../uploads/' . $row['foto_pkt'] . '" alt="paket Image" style="width: 100px; height: 100px;"></td>';
												echo
													'<td class="text-right">
                                                        <div class="dropdown dropdown-action"> 
                                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v ellipse_color"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right"> 
                                                                <a class="dropdown-item" href="detail_paket.php?id=' . $row['id_paket'] . '"><i class="fas fa-info-circle m-r-5"></i> Detail</a> 
                                                                <a class="dropdown-item" href="edit_paket.php?id=' . $row['id_paket'] . '"><i class="fas fa-pencil-alt m-r-5"></i> Edit</a> 
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_paket_' . $row['id_paket'] . '">
                                                                    <i class="fas fa-trash-alt m-r-5"></i> Delete
                                                                </a>
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
			<?php
			$query = "SELECT * FROM paket";
			$result = mysqli_query($conn, $query);
			while ($row = mysqli_fetch_assoc($result)) {
				?>
				<div id="delete_paket_<?php echo $row['id_paket']; ?>" class="modal fade delete-modal" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-body text-center">
								<img src="../assets/img/sent.png" alt="" width="50" height="46">
								<h3 class="delete_class">Apakah kamu yakin ingin menghapus data <b>
										<?php echo $row['nama_paket']; ?>
									</b> ini?</h3>
								<input type="hidden" id="deletepaketId_<?php echo $row['id_paket']; ?>"
									value="<?php echo $row['id_paket']; ?>">
								<div class="m-t-20">
									<a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
									<button type="button" class="btn btn-danger"
										onclick="deletepaket('<?php echo $row['id_paket']; ?>')">Delete</button>
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
		$('#delete_paket_<?php echo $row['id_paket']; ?>').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var id_paket = button.data('id');
			document.getElementById('deletepaketId_<?php echo $row['id_paket']; ?>').value = id_paket;
		});

		function deletepaket(id_paket) {
			// Lakukan penghapusan dengan menggunakan id_paket
			// Tambahkan kode penghapusan sesuai dengan logika bisnis Anda
			window.location.href = "hapus_paket.php?id=" + id_paket;

			// Tutup modal setelah penghapusan (sesuai kebutuhan)
			$('#delete_paket_' + id_paket).modal('hide');
		}
	</script>
	<script>
		 $(document).ready(function () {
            $('#userTable').DataTable();})
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