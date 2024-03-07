<?php
include('../koneksi/koneksi.php');
// Mengatur zona waktu menjadi Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'owner') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $query = mysqli_query($conn, "SELECT transaksi.*,member.tlp AS tlp,user.nama AS user,user.role AS role, member.alamat AS alamat, member.nama AS nama_member, detail_transaksi.qty AS qty,  paket.jenis AS jenis,  paket.harga AS harga, paket.nama_paket, outlet.nama AS nama_outlet
    FROM transaksi
    INNER JOIN user ON transaksi.id_user = user.id_user
    INNER JOIN member ON transaksi.id_member = member.id_member
    INNER JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
    INNER JOIN paket ON detail_transaksi.id_paket = paket.id_paket
    INNER JOIN outlet ON transaksi.id_outlet = outlet.id_outlet");
    if ($query) {
        $transaksi = mysqli_fetch_assoc($query);
    } else {
        // Handle error jika query tidak berhasil
        die("Error: " . mysqli_error($conn));
    }
} else {
    // Redirect jika parameter id tidak tersedia
    header("Location: transaksi.php");
    exit();
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
        border-bottom: 2px solid black;
        border: 1px solid #ddd;
    }
</style>

<body>
    <div class="main-wrapper">
        <!-- <div class="page-wrapper"> -->
        <div class=" container">

            <br>
            <div class="content mt-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <h4 class="payslip-title text-center"></h4>
                            <br>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">

                                    <img src="../assets/img/logo2.png" class="inv-logo" alt="image">

                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">
                                            <?= $transaksi['kode_invoice']; ?>
                                        </h3>
                                        <ul class="list-unstyled">
                                            <?php // Mendapatkan tanggal dari variabel $transaksi['tgl']
                                            $tanggal = $transaksi['tgl'];

                                            // Mengubah format tanggal ke format Indonesia
                                            $tanggal_ = date('d F Y', strtotime($tanggal));
                                            ?>
                                            <li>
                                                Trx Date : <?= $tanggal_; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="">
                                        <table class="">
                                            <tr><b>KEPADA :</b>

                                                <br>
                                                <?= ucwords($transaksi['nama_member']); ?><br>

                                                <?= $transaksi['alamat']; ?><br>

                                                <?= $transaksi['tlp']; ?><br>

                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <table>
                                <thead>
                                    <tr class="highlighted-row">
                                        <th>No</th>
                                        <th>Jenis Paket</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    ?>
                                    <tr class="highlighted">
                                        <td>
                                            <?= $no; ?>
                                        </td>
                                        <td>
                                            <?= $transaksi['nama_paket']; ?> -
                                            <?= ucwords($transaksi['jenis']); ?>
                                        </td>

                                        <td> Rp.
                                            <?= number_format($transaksi['harga']); ?>
                                        </td>
                                        <td>
                                            <?= $transaksi['qty']; ?>
                                        </td>
                                        <?php
                                        $jumlah = $transaksi['qty'];
                                        $harga_paket = $transaksi['harga'];
                                        $diskon = $transaksi['diskon'];
                                        $pajak = $transaksi['pajak'];
                                        $biaya_tambahan = $transaksi['biaya_tambahan'];
                                        $total = $harga_paket * $jumlah;
                                        $total_ = number_format($total);
                                        $total_harga = $jumlah * $harga_paket - $diskon + $biaya_tambahan + $pajak;
                                        $total_harga_ = number_format($total_harga); ?>

                                        <td> Rp.
                                            <?= $total_; ?>
                                        </td>

                                    </tr>


                                    <tr>
                                        <td colspan="4" style="text-align: right;">Pajak:</td>
                                        <td>Rp.
                                            <?= number_format($pajak); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">Diskon:</td>
                                        <td>Rp.
                                            <?= number_format($diskon); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">Biaya Tambahan:</td>
                                        <td>Rp.
                                            <?= number_format($biaya_tambahan); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;"><b>Total Bayar :</b></td>
                                        <td><b>Rp.
                                                <?= number_format($total_harga); ?>
                                            </b>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php
                                $no++;
                                ?>
                            </table>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4 text-center">
                                    <!-- <p>Penerima</p><br><br><br>
                                    <p><b><?= ucwords($transaksi['nama_member']); ?></b></p> -->
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
                                </b><i>&commat;<?= $transaksi['nama_outlet']; ?></i> 
                            </p>
                        </div>
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