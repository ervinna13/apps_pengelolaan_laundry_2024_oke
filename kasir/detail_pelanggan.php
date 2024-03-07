<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_member = $_GET['id'];

    // Ambil data member dari database berdasarkan id_member
    $query = "SELECT * FROM member WHERE id_member = '$id_member'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $member = mysqli_fetch_assoc($result);
    } else {
        // Handle error jika query tidak berhasil
        die("Error: " . mysqli_error($conn));
    }
} else {
    // Redirect jika parameter id tidak tersedia
    header("Location: pelanggan.php");
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
                            <h3 class="page-title mt-5">Detail pelanggan</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit member -->
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="id_member">Id Pelanggan</label>
                                        <input type="text" class="form-control" id="id_member" name="id_member"
                                            value="<?= $member['id_member']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="<?= $member['nama']; ?>" readonly>
                                    </div>
                                    
                                        <div class="form-group">
                                            <label>Jenis Kelamin</label><br>
                                            <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                            value="<?= $member['jenis_kelamin']; ?>" readonly>
                                        </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat"
                                            readonly><?= $member['alamat']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tlp">No. Telepon</label>
                                        <input type="text" class="form-control" id="tlp" name="tlp"
                                            value="<?= $member['tlp']; ?>" maxlength="13" readonly>
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