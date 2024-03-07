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
								<h4 class="card-title float-left mt-2">transaksi</h4>
								<a href="tambah_transaksi.php" class="btn btn-primary float-right veiwbutton"> <i
										class="fas fa-plus-circle"></i></a>
								<button class="btn btn-primary float-right veiwbutton " style="margin-right: 10px;"
									onclick="window.location.reload();">
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
									<table id="userTable" class="display" style="width:100%" style="overflow: auto;" class="display" style="width:100%">
										<thead>

											<tr>
												<th>No.</th>
												<th>Kode Invoice</th>
												<th>Nama Member</th>
												<th>Jenis Paket</th>
												<th>Nama Outlet</th>
												<th>Berat Cucian</th>
												<th>Total Bayar</th>
												<th>Status</th>
												<!-- <th>Ubah Status</th>
	<th>Bayar Transaksi</th> -->
												<th class="text-right">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$nomor = 1;
											$query = mysqli_query($conn, "SELECT transaksi.*, member.nama AS nama_member, detail_transaksi.qty AS qty,  paket.jenis AS jenis,  paket.harga AS harga, paket.nama_paket, outlet.nama AS nama_outlet
FROM transaksi
INNER JOIN member ON transaksi.id_member = member.id_member
INNER JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
INNER JOIN paket ON detail_transaksi.id_paket = paket.id_paket
INNER JOIN outlet ON transaksi.id_outlet = outlet.id_outlet");

											while ($row = mysqli_fetch_assoc($query)) {
												echo '<tr>';
												echo '<td>' . $nomor . '</td>';
												echo '<td>' . $row['kode_invoice'] . '</td>';
												echo '<td>' . $row['nama_member'] . '</td>';
												echo '<td>' . $row['nama_paket'] . '</td>';
												echo '<td>' . $row['nama_outlet'] . '</td>';
												echo '<td>' . $row['qty'] . ' ' . $row['jenis'] . '</td>';
												$harga_paket = $row['harga'];
												$total = $row['qty'] * $harga_paket;
												$diskon = $row['diskon'];
												$diskon_ = $total * $diskon / 100;
												$pajak = $row['pajak'];
												$pajak_ = $total * $pajak / 100;
												$biaya_tambahan = $row['biaya_tambahan'];
												$total_harga = $total - $diskon_ + $biaya_tambahan + $pajak_;
												$total_harga_ = number_format($total_harga, 2, ',', '.');
												echo '<td> Rp. ' . $total_harga_ . '</td>';
												$status = $row['status'];
												$status_bayar = $row['dibayar'];
												echo '<td>';

												// Tombol status
												if ($status == 'baru') {
													echo '<a href="" class="btn btn-outline-secondary active">Baru</a>';
												} elseif ($status == 'diambil') {
													echo '<a href="" class="btn btn-outline-success active">Diambil</a>';
												} elseif ($status == 'proses') {
													echo '<a href="" class="btn btn-outline-warning active">Proses</a>';
												} elseif ($status == 'selesai') {
													echo '<a href="" class="btn btn-outline-info active">Selesai</a>';
												}
												echo '<br>';
												echo '<br>';
												if ($status_bayar == 'dibayar') {
													echo '<a href="" class="btn btn-outline-success active">Dibayar</a>';
												} elseif ($status_bayar == 'belum_dibayar') {
													echo '<a href="" class="btn btn-outline-danger active">Belum Bayar</a>';
												}

												echo '</td>';

												echo '</td>';

												echo '<td class="text-right">
<div class="dropdown dropdown-action"> <a href="#"
class="action-icon dropdown-toggle" data-toggle="dropdown"
aria-expanded="false"><i
class="fas fa-ellipsis-v ellipse_color"></i></a>
<div class="dropdown-menu dropdown-menu-right">
<a class="dropdown-item"
href="detail_transaksi.php?id=' . $row['id_transaksi'] . '"><i
class="fas fa-info-circle m-r-5"></i> Detail</a>
<a class="dropdown-item"
href="edit_transaksi.php?id=' . $row['id_transaksi'] . '"><i
class="fas fa-pencil-alt m-r-5"></i> Edit</a>
 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_transaksi_' . $row['id_transaksi'] . '">
                                                                    <i class="fas fa-trash-alt m-r-5"></i> Delete
                                                                </a>

</div>
</div>
</td>';
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
			$query = "SELECT * FROM transaksi";
			$result = mysqli_query($conn, $query);
			while ($row = mysqli_fetch_assoc($result)) {
				?>
				<div id="delete_transaksi_<?php echo $row['id_transaksi']; ?>" class="modal fade delete-modal" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-body text-center">
								<img src="../assets/img/sent.png" alt="" width="50" height="46">
								<h3 class="delete_class">Apakah kamu yakin ingin menghapus data <b>
										<?php echo $row['kode_invoice']; ?>
									</b> ini?</h3>
								<input type="hidden" id="deletetransaksiId_<?php echo $row['id_transaksi']; ?>"
									value="<?php echo $row['id_transaksi']; ?>">
								<div class="m-t-20">
									<a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
									<button type="button" class="btn btn-danger"
										onclick="deletetransaksi('<?php echo $row['id_transaksi']; ?>')">Delete</button>
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
		$('#delete_transaksi_<?php echo $row['id_transaksi']; ?>').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var id_transaksi = button.data('id');
			document.getElementById('deletetransaksiId_<?php echo $row['id_transaksi']; ?>').value = id_transaksi;
		});

		function deletetransaksi(id_transaksi) {
			// Lakukan penghapusan dengan menggunakan id_transaksi
			// Tambahkan kode penghapusan sesuai dengan logika bisnis Anda
			window.location.href = "hapus_transaksi.php?id=" + id_transaksi;

			// Tutup modal setelah penghapusan (sesuai kebutuhan)
			$('#delete_transaksi_' + id_transaksi).modal('hide');
		}
	</script>
	<script>
		$(document).ready(function () {
			$('#userTable').DataTable();
		})
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