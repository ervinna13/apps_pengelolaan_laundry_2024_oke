<?php
session_start();
// Sertakan file koneksi
include('../koneksi/koneksi.php');

// Check jika pengguna belum login, redirect ke halaman login
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Proses edit data customer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_member = $_POST['id_member'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $tlp = $_POST['tlp'];

    // Update data customer dalam database
    $query = "UPDATE member SET 
                nama = '$nama',
                jenis_kelamin = '$jenis_kelamin',
                alamat = '$alamat',
                tlp = '$tlp'
                WHERE id_member = '$id_member'";

    if ($conn->query($query) === TRUE) {
        echo '<script>alert("DATA BERHASIL DIUBAH!"); window.location.href = "pelanggan.php";</script>';
        exit;
    } else {
        die("Error: " . mysqli_error($conn));
        // echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Ambil ID customer dari parameter URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_member = $_GET['id'];

    // Ambil data customer dari database berdasarkan ID
    $query = "SELECT * FROM member WHERE id_member = '$id_member'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc();
    } else {
        echo "Data Pelanggan tidak ditemukan.";
        exit;
    }
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
                            <h3 class="page-title mt-5">Edit Pelanggan</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit member -->
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="id_member">Id Pelanggan</label>
                                        <input type="text" class="form-control" id="id_member" name="id_member"
                                            value="<?= $member['id_member']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="<?= $member['nama']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="laki-laki" value="Laki-laki" <?php echo ($member['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="perempuan" value="Perempuan" <?php echo ($member['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat"
                                            required><?= $member['alamat']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tlp">No. Telepon</label>
                                        <input type="text" class="form-control" id="tlp" name="tlp" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
                                            value="<?= $member['tlp']; ?>" required maxlength="13">
                                    </div>
                                    <a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
									class="fas fa-arrow-left"></i> Back
							</a>
                                    <button type="submit" name="submit" class="btn btn-info">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Sisipkan Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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