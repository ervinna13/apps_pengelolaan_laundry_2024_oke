<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $query = mysqli_query($conn, "SELECT transaksi.*, member.nama AS nama_member, detail_transaksi.qty AS qty,  paket.jenis AS jenis,  paket.harga AS harga, paket.nama_paket, outlet.nama AS nama_outlet
    FROM transaksi
    INNER JOIN member ON transaksi.id_member = member.id_member
    INNER JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
    INNER JOIN paket ON detail_transaksi.id_paket = paket.id_paket
    INNER JOIN outlet ON transaksi.id_outlet = outlet.id_outlet
    WHERE transaksi.id_transaksi = '$id_transaksi'");
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
?>
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
                            <h3 class="page-title mt-5">Detail transaksi</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit transaksi -->
                                <form method="POST">
                                    <?php ?>
                                    <div class="form-group">
                                        <label for="berat_cucian">Waktu Transaksi</label>
                                        <input class="form-control" id="berat_cucian" name="berat_cucian"
                                            value=" <?= $transaksi['tgl']; ?> " readonly>

                                    </div>
                                    <div class="form-group">
                                        <label for="nama_member">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama_member" name="nama_member"
                                            value="<?= $transaksi['nama_member']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_outlet">Nama Outlet</label>
                                        <input type="text" class="form-control" id="nama_outlet" name="nama_outlet"
                                            value="<?= $transaksi['nama_outlet']; ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_paket">Berat Cucian</label>
                                        <input class="form-control" id="nama_paket" name="nama_paket"
                                            value=" <?= $transaksi['nama_paket']; ?> " readonly>

                                    </div>
                                    <div class="form-group">
                                        <label for="berat_cucian">Nama Paket</label>
                                        <input class="form-control" id="berat_cucian" name="berat_cucian"
                                            value=" <?= $transaksi['qty']; ?>  <?= $transaksi['jenis']; ?>" readonly>

                                    </div>
                                    <?php
                                    $jumlah = $transaksi['qty'];
                                    $harga_paket = $transaksi['harga'];
                                    $biaya_tambahan = $transaksi['biaya_tambahan'];
                                    $total = $harga_paket * $jumlah;
                                    $diskon = $transaksi['diskon'] / 100 * $total;
                                    $total_ = number_format($total);
                                    $total_harga = ($jumlah * $harga_paket) - $diskon + $biaya_tambahan;
                                    $total_harga_ = number_format($total_harga);
                                    $pajak = $transaksi['pajak'] / 100 * $total_harga;
                                    $total_harga1 = $total_harga + $pajak;

                                    ?>
                                    <div class="form-group ">
                                        <label for="harga">Pajak</label>
                                        <input type="text" class="form-control" id="harga" name="harga"
                                            value="Rp. <?= number_format($pajak, 0, ',', '.'); ?>" readonly>
                                    </div>
                                    <div class="form-group ">
                                        <label for="harga">Diskon</label>
                                        <input type="text" class="form-control" id="harga" name="harga"
                                            value="Rp. <?= number_format($diskon, 0, ',', '.'); ?>" readonly>
                                    </div>
                                    <div class="form-group ">
                                        <label for="harga">Biaya Tambahan</label>
                                        <input type="text" class="form-control" id="harga" name="harga"
                                            value="Rp. <?= number_format($biaya_tambahan, 0, ',', '.'); ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Total Bayar</label>
                                        <input type="text" class="form-control" id="harga" name="harga"
                                            value="Rp. <?= number_format($total_harga1, 0, ',', '.'); ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <div>
                                            <?php
                                            $status = $transaksi['status'];
                                            $status_bayar = $transaksi['dibayar'];
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
                                            ?>
                                        </div>


                                    </div>
                                    <hr>
                                    <a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
                                            class="fas fa-arrow-left"></i> Back
                                    </a>
                                </form>
                            </div>
                        </div>
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