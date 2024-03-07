<?php
include('../koneksi/koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect ke halaman login jika tidak memenuhi syarat
    exit();
}

// Ambil data dari form
$start_date = $_POST['tanggal_dari'];
$end_date = $_POST['tanggal_sampai'];
// Gunakan parameter tanggal untuk mengambil data transaksi dari database
$query = mysqli_query($conn, "SELECT transaksi.*, member.nama AS nama_member, user.nama AS user, user.role AS role, detail_transaksi.qty AS qty,  paket.jenis AS jenis,  paket.harga AS harga, paket.nama_paket, outlet.nama AS nama_outlet
    FROM transaksi
    INNER JOIN user ON transaksi.id_user = user.id_user
    INNER JOIN member ON transaksi.id_member = member.id_member
    INNER JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
    INNER JOIN paket ON detail_transaksi.id_paket = paket.id_paket
    INNER JOIN outlet ON transaksi.id_outlet = outlet.id_outlet
    WHERE transaksi.dibayar = 'dibayar'
    AND transaksi.status IN ('selesai', 'diambil') 
    AND transaksi.tgl BETWEEN '$start_date' AND '$end_date'");

if (!$query) {
    // Handle error jika query tidak berhasil
    die("Error: " . mysqli_error($conn));
}

// Cek apakah ada transaksi yang ditemukan
$num_rows = mysqli_num_rows($query);


$querySistem = mysqli_query($conn, "SELECT * from sistem ");
if ($querySistem) {
    $sistem = mysqli_fetch_assoc($querySistem);
} else {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php include('../layouts/head.php'); ?>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .main-wrapper {
        margin-top: 20px;
    }

    .invoice-details h3 {
        margin-top: 0;
        font-size: 24px;
        color: #333;
    }

    .invoice-details ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
        padding: 10px;
        text-align: left;
    }

    td {
        padding: 10px;


    }

    .highlighted-row th {
        background-color: #f2f2f2;
        border: 1px solid #ddd;
        border-bottom: 2px solid black;


    }

    .highlighted td {
        border-bottom: 1px solid black;
        border: 1px solid #ddd;
    }
</style>

<body>
    <div class="main-wrapper">
        <!-- <div class="page-wrapper"> -->
        <div class=" container">
            <div class="page-header">
                <!-- <h2 class="card-title"><b>Laporan Transaksi</b></h2> -->
                <div class="row">
                    <div class="col-sm-6">
                        <h3><b>
                                <?= $sistem['apk_name']; ?>
                            </b></h3>
                        <span><i>
                                <?= $sistem['slogan']; ?>
                            </i></span>
                        <p>
                            <?= $sistem['alamat']; ?>
                        </p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <img src="../assets/img/logo2.png" class="inv-logo" alt="image">
                        <?php
                        $start_date_ = date('d F Y', strtotime($start_date));
                        $end_date_ = date('d F Y', strtotime($end_date));
                        ?>
                        <p>Periode:
                            <?= $start_date_ . ' s/d ' . $end_date_; ?>
                        </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="content mt-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <br>
                            <?php if ($num_rows > 0): ?>
                                <?php
                                $total_keseluruhan = 0; // Inisialisasi variabel total keseluruhan
                                ?>
                                <table>
                                    <thead>
                                        <tr class="highlighted-row">
                                            <th>No.</th>
                                            <th>Kode Invoice</th>
                                            <th>Nama Member</th>
                                            <th>Jenis Paket</th>
                                            <th>Nama Outlet</th>
                                            <th>Berat Cucian</th>
                                            <th>Kasir</th>
                                            <th>Waktu Transaksi</th>
                                            <th>Total Bayar</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($transaksi = mysqli_fetch_assoc($query)):
                                            ?>
                                            <tr class="highlighted">
                                                <td>
                                                    <?= $no++; ?>
                                                </td>
                                                <td>
                                                    <?= $transaksi['kode_invoice']; ?>
                                                </td>
                                                <td>
                                                    <?= $transaksi['nama_member']; ?>
                                                </td>
                                                <td>
                                                    <?= $transaksi['nama_paket']; ?>
                                                </td>
                                                <td>
                                                    <?= $transaksi['nama_outlet']; ?>
                                                </td>
                                                <td>
                                                    <?= $transaksi['qty']; ?>
                                                </td>
                                                <td>
                                                    <?= ucwords($transaksi['user']); ?>
                                                </td>
                                                <?php // Mendapatkan tanggal dari variabel $transaksi['tgl']
                                                        $tanggal = $transaksi['tgl'];

                                                        // Mengubah format tanggal ke format Indonesia
                                                        $tanggal_ = date('d F Y', strtotime($tanggal));
                                                        ?>
                                                <td>
                                                    <?= $tanggal_; ?>
                                                </td>
                                                <?php
                                                $jumlah = $transaksi['qty'];
                                                $harga_paket = $transaksi['harga'];
                                                $pajak = $transaksi['pajak'] / 100;
                                                $biaya_tambahan = $transaksi['biaya_tambahan'];
                                                $total = $harga_paket * $jumlah;
                                                $diskon = $transaksi['diskon'] / 100 * $total;
                                                // $total_ = number_format($total);
                                                $total_harga = ($jumlah * $harga_paket) - $diskon + $biaya_tambahan;
                                                $total_harga1= $total_harga + ($pajak * $total_harga);
                                                $total_keseluruhan += $total_harga1;

                                                $total_harga_ = number_format($total_harga1);
                                                ?>

                                                <td>Rp.
                                                    <?= $total_harga_; ?>
                                                </td>

                                            </tr>

                                        <?php endwhile; ?>
                                        <tr class="highlighted">
                                            <td colspan="8" align="center"><strong>Total Keseluruhan</strong></td>
                                            <td><strong>Rp.
                                                    <?= number_format($total_keseluruhan); ?>
                                                </strong></td>
                                        </tr>
                                    </tbody>

                                </table>
                            <?php else: ?>
                                <p>Data transaksi tidak tersedia untuk rentang tanggal yang diminta.</p>
                            <?php endif; ?>

                        </div>
                        <?php if ($num_rows > 0): ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <!-- <p>Penerima</p><br><br><br>
                                <p><b>
                                        <?= ucwords($transaksi['nama_member']); ?>
                                    </b></p> -->
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <p>
                                            <?= ucwords($transaksi['role']); ?>
                                        </p><br><br><br>
                                        <p><b>
                                                <?= ucwords($transaksi['user']); ?>
                                            </b></p>
                                    </div>
                                </div>
                                <br>
                                <p class="text-center">Dicetak pada: <b>
                                        <?= date(' d F Y'); ?>
                                    </b><i>&commat;
                                        <?= $sistem['apk_name']; ?>
                                    </i>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></> -->
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
    <!-- <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/datatables.min.js"></script> -->
    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../assets/plugins/raphael/raphael.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <script>
        window.addEventListener("load", function () {
            window.print();
        });
    </script>
</body>

</html>