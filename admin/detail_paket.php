<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_paket = $_GET['id'];

    // Ambil data paket dari database berdasarkan id_paket
    $query = "SELECT paket.*, outlet.nama AS nama_outlet 
    FROM paket 
    INNER JOIN outlet ON paket.id_outlet = outlet.id_outlet 
    WHERE paket.id_paket = '$id_paket'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $paket = mysqli_fetch_assoc($result);
    } else {
        // Handle error jika query tidak berhasil
        die("Error: " . mysqli_error($conn));
    }
} else {
    // Redirect jika parameter id tidak tersedia
    header("Location: paket.php");
    exit();
}
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
                            <h3 class="page-title mt-5">Detail paket</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit paket -->
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="id_paket">Id paket</label>
                                        <input type="text" class="form-control" id="id_paket" name="id_paket"
                                            value="<?= $paket['id_paket']; ?>" readonly>
                                    </div>
                                    <?php ?>
                                    <div class="form-group">
                                        <label for="nama_outlet">Nama Outlet</label>
                                        <input type="text" class="form-control" id="nama_outlet" name="nama_outlet"
                                            value="<?= $paket['nama_outlet']; ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis">Jenis</label>
                                        <input class="form-control" id="jenis" name="jenis"
                                            value=" <?= $paket['jenis']; ?>" readonly>

                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control" id="harga" name="harga"
                                            value="Rp. <?= number_format($paket['harga'], 0, ',', '.'); ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="estimasi">Estimasi</label>
                                        <input class="form-control" id="estimasi" name="estimasi"
                                            value=" <?= $paket['estimasi']; ?> Hari" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Foto</label>
                                        <br>
                                        <img id="preview" src="../uploads/<?= $paket['foto_pkt']; ?>" alt="Foto paket"
                                            style="width: 100px; height: auto;">
                                        <br>
                                        <label for="current_foto">Nama Foto: </label>
                                        <span id="current_foto">
                                            <?= $paket['foto_pkt']; ?>
                                        </span>
                                    </div>
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