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
								<h4 class="card-title float-left mt-2">Laporan</h4>
								<button class="btn btn-primary float-right veiwbutton " style="margin-right: 10px;"
									onclick="window.location.reload();">
									<i class="fas fa-sync-alt"></i>
								</button>
								<form action="lapor.php" method="post" target="_blank" class="float-right">
									<label for="tanggal_dari">Dari Tanggal:</label>
									<input type="date" id="tanggal_dari" name="tanggal_dari" required>
									<label for="tanggal_sampai">Sampai Tanggal:</label>
									<input type="date" id="tanggal_sampai" name="tanggal_sampai" required>
									<button type="submit" style="margin-right: 10px;" class="btn btn-primary ml-2"><i
											class="fa fa-print"></i></button>
								</form>
								<!-- <form class="float-right" id="date-form">
													<label for="start-date" class="mr-2">Dari Tanggal:</label>
													<input type="date" id="start-date" name="start-date">
													<label for="end-date" class="mr-2 ml-2">Sampai Tanggal:</label>
													<input type="date" id="end-date" name="end-date">
													<button type="button float-right veiwbutton "
														style="margin-right: 10px;" class="btn btn-primary ml-2"
														onclick="filterByDate()"><i class="fa fa-print"></i></button>
												</form> -->
							</div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table id="userTable" class="display" style="width:100%">
										<thead>

											<tr>
												<th>No.</th>
												<th>Kode Invoice</th>
												<th>Waktu Transaksi</th>
												<th>Nama Member</th>
												<th>Jenis Paket</th>
												<th>Nama Outlet</th>
												<th>Tanggal Bayar</th>
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
INNER JOIN outlet ON transaksi.id_outlet = outlet.id_outlet
WHERE transaksi.dibayar = 'dibayar' 
");

											while ($row = mysqli_fetch_assoc($query)) {
												echo '<tr>';
												echo '<td>' . $nomor . '</td>';
												echo '<td>' . $row['kode_invoice'] . '</td>';
												echo '<td>' . $row['tgl'] . '</td>';
												echo '<td>' . $row['nama_member'] . '</td>';
												echo '<td>' . $row['nama_paket'] . '</td>';
												echo '<td>' . $row['nama_outlet'] . '</td>';
												echo '<td>' . $row['tgl_bayar'] . '</td>';
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
												echo '<br> ';
												echo '<br> ';
												if ($status_bayar == 'dibayar') {
													echo '<a href="" class="btn btn-outline-success active">Dibayar</a>';
												} elseif ($status_bayar == 'belum_dibayar') {
													echo '<a href="" class="btn btn-outline-danger active">Belum Bayar</a>';
												}

												echo '</td>';

												echo '</td>';

												echo '<td>
			<a href="print_laporan.php?id=' . $row['id_transaksi'] . '" target="_blank"
				class="btn btn-block btn-outline-primary active"><i class="fa fa-print"></i> </a>
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
			
		</div>
	</div>
	
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