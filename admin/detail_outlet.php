<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_outlet = $_GET['id'];

    // Ambil data outlet dari database berdasarkan id_outlet
    $query = "SELECT * FROM outlet WHERE id_outlet = '$id_outlet'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $outlet = mysqli_fetch_assoc($result);
    } else {
        // Handle error jika query tidak berhasil
        die("Error: " . mysqli_error($conn));
    }
} else {
    // Redirect jika parameter id tidak tersedia
    header("Location: outlet.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
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
                            <h3 class="page-title mt-5">Detail Outlet</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit outlet -->
                                <form action="" method="POST" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label for="id_outlet">Id Outlet</label>
                                        <input type="text" class="form-control" id="id_outlet" name="id_outlet"
                                            value="<?= $outlet['id_outlet']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Outlet</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="<?= $outlet['nama']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat"
                                            readonly><?= $outlet['alamat']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tlp">No. Telepon</label>
                                        <input type="text" class="form-control" id="tlp" name="tlp"
                                            value="<?= $outlet['tlp']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Foto</label>
                                        <br>
                                        <img id="preview" src="../uploads/<?= $outlet['foto']; ?>" alt="Foto Outlet"
                                            style="width: 100px; height: auto;">
                                        <br>
                                        <label for="current_foto">Nama Foto: </label>
                                        <span id="current_foto">
                                            <?= $outlet['foto']; ?>
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