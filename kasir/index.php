<?php
// Set zona waktu menjadi Waktu Indonesia Barat
date_default_timezone_set('Asia/Jakarta');

// Inisialisasi array untuk menyimpan jumlah transaksi per bulan
$dataTransaksiBulan = array(
	'Januari' => 0,
	'Februari' => 0,
	'Maret' => 0,
	'April' => 0,
	'Mei' => 0,
	'Juni' => 0,
	'Juli' => 0,
	'Agustus' => 0,
	'September' => 0,
	'Oktober' => 0,
	'November' => 0,
	'Desember' => 0
);
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'kasir') {
	header("Location: ../index.php");
	exit();
}

$id_user = $_SESSION['id_user'];
$query_user = "SELECT user.role, password, user.nama AS user_nama, user.username, outlet.nama AS nama_outlet 
                FROM user 
                INNER JOIN outlet ON user.id_outlet = outlet.id_outlet
                WHERE user.id_user = '$id_user'";
$result_user = mysqli_query($conn, $query_user);

if (!$result_user) {
    echo "Error: " . $query_user . "<br>" . mysqli_error($conn);
    exit();
}

$row_user = mysqli_fetch_assoc($result_user);
$nama = $row_user['user_nama']; // Gunakan alias yang diberikan pada kolom 'nama'
$username = $row_user['username'];
$role = $row_user['role'];
$password = $row_user['password'];
$outlet = $row_user['nama_outlet'];

?>
<?php include('../layouts/head.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<body>
	<div class="main-wrapper">
		<?php include('../layouts/header.php'); ?>
		<?php include('../layouts/sidebar.php'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12 mt-5">
							<h3 class="page-title mt-3">Selamat Datang <?= $nama; ?>!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">Dashboard</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card board1 fill">
							<div class="card-body">
								<div class="dash-widget-header">
									<div>
										<h3 class="card_widget_header">
											<?php
											// Query untuk mendapatkan jumlah Pelanggan dari database
											$queryPelanggan = "SELECT COUNT(*) AS totalPelanggan FROM member";
											$resultPelanggan = $conn->query($queryPelanggan);

											// Query untuk mendapatkan jumlah User dari database
											$queryUser = "SELECT COUNT(*) AS totalUser FROM user";
											$resultUser = $conn->query($queryUser);

											if ($resultPelanggan && $resultUser) {
												$rowPelanggan = $resultPelanggan->fetch_assoc();
												$totalPelanggan = $rowPelanggan['totalPelanggan'];

												$rowUser = $resultUser->fetch_assoc();
												$totalUser = $rowUser['totalUser'];

												// Menampilkan jumlah Pelanggan dan User dalam HTML
												echo '<h3>' . $totalPelanggan .  '</h3>';
											} else {
												// Menampilkan pesan kesalahan jika query tidak berhasil
												echo '<h3>Error</h3>';
											}
											?>
										</h3>
										<h6 class="text-muted">Total Member</h6>
									</div>

									<div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg
												xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-user-plus">
												<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
												<circle cx="8.5" cy="7" r="4"></circle>
												<line x1="20" y1="8" x2="20" y2="14"></line>
												<line x1="23" y1="11" x2="17" y2="11"></line>
											</svg></span> </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card board1 fill">
							<div class="card-body">
								<div class="dash-widget-header">
									<div>
										<h3 class="card_widget_header">
											<?php
											// Query untuk mendapatkan jumlah Transaksi dari database
											$queryTransaksi = "SELECT COUNT(*) AS totalTransaksi FROM transaksi";
											$resultTransaksi = $conn->query($queryTransaksi);

											if ($resultTransaksi) {
												$rowTransaksi = $resultTransaksi->fetch_assoc();
												$totalTransaksi = $rowTransaksi['totalTransaksi'];

												// Menampilkan jumlah Transaksi dalam HTML
												echo '<h3>' . $totalTransaksi . '</h3>';
											} else {
												// Menampilkan pesan kesalahan jika query tidak berhasil
												echo '<h3>Error</h3>';
											}
											?>
										</h3>
										<h6 class="text-muted">Total Transaksi</h6>
									</div>
									<div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg
												xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-dollar-sign">
												<line x1="12" y1="1" x2="12" y2="23"></line>
												<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
											</svg></span> </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card board1 fill">
							<div class="card-body">
								<div class="dash-widget-header">
									<div>
										<h3 class="card_widget_header">
											<?php
											// Query untuk mendapatkan jumlah Paket dari database
											$queryPaket = "SELECT COUNT(*) AS totalPaket FROM paket";
											$resultPaket = $conn->query($queryPaket);

											if ($resultPaket) {
												$rowPaket = $resultPaket->fetch_assoc();
												$totalPaket = $rowPaket['totalPaket'];

												// Menampilkan jumlah Paket dalam HTML
												echo '<h3>' . $totalPaket . '</h3>';
											} else {
												// Menampilkan pesan kesalahan jika query tidak berhasil
												echo '<h3>Error</h3>';
											}
											?>
										</h3>
										<h6 class="text-muted">Total Produk</h6>
									</div>
									<div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg
												xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-file-plus">
												<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
												</path>
												<polyline points="14 2 14 8 20 8"></polyline>
												<line x1="12" y1="18" x2="12" y2="12"></line>
												<line x1="9" y1="15" x2="15" y2="15"></line>
											</svg></span> </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card board1 fill">
							<div class="card-body">
								<div class="dash-widget-header">
									<div>
										<h3 class="card_widget_header">
											<?php
											// Query untuk mendapatkan jumlah Outlet dari database
											$queryOutlet = "SELECT COUNT(*) AS totalOutlet FROM outlet";
											$resultOutlet = $conn->query($queryOutlet);

											if ($resultOutlet) {
												$rowOutlet = $resultOutlet->fetch_assoc();
												$totalOutlet = $rowOutlet['totalOutlet'];

												// Menampilkan jumlah Outlet dalam HTML
												echo '<h3>' . $totalOutlet . '</h3>';
											} else {
												// Menampilkan pesan kesalahan jika query tidak berhasil
												echo '<h3>Error</h3>';
											}
											?>
										</h3>
										<h6 class="text-muted">Total Outlet</h6>
									</div>
									<div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg
												xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-globe">
												<circle cx="12" cy="12" r="10"></circle>
												<line x1="2" y1="12" x2="22" y2="12"></line>
												<path
													d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
												</path>
											</svg></span> </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-lg-6">
						<div class="card card-chart">
							<div class="card-body booking_card">
								<div class="card-header">
									<h4 class="card-title">Transaksi Periode
										<?php $tahun_sekarang = date("Y");
										echo $tahun_sekarang; ?>
									</h4>
								</div>
								<div style="width: 100%;">
									<canvas id="grafikBatang"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-6">
						<div class="card card-chart">
							<div class="card-header">
								<h4 class="card-title">Transaksi per outlet ( Tahun 
									<?php
									// $bulan_ini = date('F');  $bulan_ini; 
									$tahun_sekarang = date("Y");
										echo $tahun_sekarang; ?>
								
									)
								</h4>
							</div>
							<div style="width: 100%;">
								<canvas id="grafikDonat"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table id="transaksi_id"
										class="datatable table table-stripped table table-hover table-center mb-0">

										<thead>
											<tr>
												<th>No.</th>
												<th>Tanggal Transaksi</th>
												<th>Nama Member</th>
												<th>Paket</th>
												<th>Total Bayar</th>
												<th>Status</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$nomor = 1;
											$query = mysqli_query($conn, "SELECT transaksi.*, detail_transaksi.*, paket.*, member.*, 
								 ((paket.harga * detail_transaksi.qty) + transaksi.biaya_tambahan +(transaksi.pajak / 100 * (paket.harga * detail_transaksi.qty))  - (transaksi.diskon / 100 * paket.harga)) AS total
											FROM detail_transaksi
											 JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi
											 JOIN paket ON detail_transaksi.id_paket = paket.id_paket
											 JOIN outlet ON transaksi.id_outlet = outlet.id_outlet
											LEFT JOIN member ON transaksi.id_member = member.id_member
											WHERE transaksi.status = 'baru' 
											");

											while ($row = mysqli_fetch_assoc($query)) {
												echo '<tr>';
												echo '<td>' . $nomor . '</td>';
												echo '<td>' . $row['tgl'] . '</td>';
												echo '<td>' . $row['nama'] . '</td>';
												echo '<td>' . $row['nama_paket'] . '</td>';

												echo '<td> Rp. ' . number_format($row['total'], 2, ',', '.') . '</td>';
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
												echo ' ';
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
													<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_asset" data-id="' . $row['id_transaksi'] . '">
													<i class="fas fa-trash-alt m-r-5"></i> Delete
												</a>
												<a class="dropdown-item" href="print_laporan.php?id=' . $row['id_transaksi'] . '" target="_blank"
															><i class="fa fa-print"></i> Print </a>
													
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
		</div>

	</div>
	<?php
	// Query untuk mengambil data transaksi dari database
	$tahun_sekarang = date("Y");
	$query = "SELECT MONTH(tgl) AS bulan, COUNT(*) AS total_transaksi 
              FROM transaksi 
              WHERE YEAR(tgl) = $tahun_sekarang 
              GROUP BY MONTH(tgl)";
	$result = mysqli_query($conn, $query);

	// Inisialisasi array untuk data grafik batang
	$data_grafik = array();

	// Mengisi array dengan data transaksi per bulan
	while ($row = mysqli_fetch_assoc($result)) {
		$bulan = $row['bulan'];
		switch ($bulan) {
			case 1:
				$dataTransaksiBulan['Januari'] = $row['total_transaksi'];
				break;
			case 2:
				$dataTransaksiBulan['Februari'] = $row['total_transaksi'];
				break;
			case 3:
				$dataTransaksiBulan['Maret'] = $row['total_transaksi'];
				break;
			case 4:
				$dataTransaksiBulan['April'] = $row['total_transaksi'];
				break;
			case 5:
				$dataTransaksiBulan['Mei'] = $row['total_transaksi'];
				break;
			case 6:
				$dataTransaksiBulan['Juni'] = $row['total_transaksi'];
				break;
			case 7:
				$dataTransaksiBulan['Juli'] = $row['total_transaksi'];
				break;
			case 8:
				$dataTransaksiBulan['Agustus'] = $row['total_transaksi'];
				break;
			case 9:
				$dataTransaksiBulan['September'] = $row['total_transaksi'];
				break;
			case 10:
				$dataTransaksiBulan['Oktober'] = $row['total_transaksi'];
				break;
			case 11:
				$dataTransaksiBulan['November'] = $row['total_transaksi'];
				break;
			case 12:
				$dataTransaksiBulan['Desember'] = $row['total_transaksi'];
				break;
		}
	}
	?>
	<?php
	// Mengambil data transaksi untuk bulan ini
	$tahun_sekarang = date("Y");
	$bulan_ini = date('Y-m');
	$query_donat = "SELECT outlet.nama, COUNT(*) as total_transaksi 
                    FROM transaksi 
                    JOIN outlet ON transaksi.id_outlet = outlet.id_outlet
					WHERE YEAR(tgl) = $tahun_sekarang 
                    -- WHERE DATE_FORMAT(transaksi.tgl, '%Y-%m') = '$bulan_ini' 
                    GROUP BY transaksi.id_outlet";
	$result_donat = mysqli_query($conn, $query_donat);

	// Array untuk menyimpan data outlet dan jumlah transaksinya
	$outlets_donat = array();
	$total_transaksis_donat = array();

	// Memasukkan data ke dalam array
	while ($row = mysqli_fetch_assoc($result_donat)) {
		$outlets_donat[] = $row['nama'];
		$total_transaksis_donat[] = $row['total_transaksi'];
	}
	?>

	<script>
		// Data outlet dan jumlah transaksi
		var outlets_donat = <?php echo json_encode($outlets_donat); ?>;
		var total_transaksis_donat = <?php echo json_encode($total_transaksis_donat); ?>;

		// Inisialisasi Chart.js untuk Doughnut Chart
		var ctx_donut = document.getElementById('grafikDonat').getContext('2d');
		var donutChart = new Chart(ctx_donut, {
			type: 'doughnut',
			data: {
				labels: outlets_donat,
				datasets: [{
					label: 'Jumlah Transaksi Bulan <?php echo $bulan_ini; ?>',
					data: total_transaksis_donat,
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false
			}
		});
	</script>
	<script>
		// Label bulan sesuai dengan urutan yang diinginkan
		var labelsBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

		// Data untuk grafik batang
		var dataBatang = {
			labels: labelsBulan,
			datasets: [{
				label: 'Jumlah Transaksi',
				data: <?php echo json_encode(array_values($dataTransaksiBulan)); ?>,
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		};

		// Konfigurasi untuk grafik batang
		var configBatang = {
			type: 'bar',
			data: dataBatang,
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		};

		// Gambar grafik batang
		var grafikBatang = new Chart(
			document.getElementById('grafikBatang'),
			configBatang
		);
	</script>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<!-- <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></> -->
	<script src="../assets/js/jquery-3.5.1.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>

	<link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
	<!-- <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>

	<script src="../assets/plugins/datatables/datatables.min.js"></script> -->
	<script></script>
	<script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../assets/plugins/raphael/raphael.min.js"></script>
	<script src="../assets/js/script.js"></script>
</body>

</html>