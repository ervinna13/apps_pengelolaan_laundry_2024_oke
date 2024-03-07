<?php
session_start();
// Sertakan file koneksi
include('../koneksi/koneksi.php');

// Check jika pengguna belum ../index, redirect ke halaman ../index
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'kasir') {
    header('Location: ../index.php');
    exit;
}
// Proses edit data customer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_paket = $_POST['id_paket'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $estimasi = $_POST['estimasi'];
    $satuan = $_POST['satuan'];

    // Update data paket dalam database
    $query = "UPDATE paket SET 
                id_outlet = '$nama',
                jenis = '$jenis',
                nama_paket = '$nama_paket',
                harga = '$harga',
                estimasi = '$estimasi $satuan' 
                WHERE id_paket = '$id_paket'";

    if ($conn->query($query) === TRUE) {
        echo '<script>alert("DATA BERHASIL DIUBAH!"); window.location.href = "paket.php";</script>';
        exit;
    } else {
        die("Error: " . mysqli_error($conn));
        // echo "Error: " . $query . "<br>" . $conn->error;
    }
}
// Ambil ID customer dari parameter URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_paket = $_GET['id'];
    // Ambil data customer dari database berdasarkan ID
    $query = "SELECT * FROM paket WHERE id_paket = '$id_paket'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $paket = $result->fetch_assoc();
    } else {
        echo "Data paket tidak ditemukan.";
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
                            <h3 class="page-title mt-5">Edit paket</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="id_paket">Id paket</label>
                                        <input type="text" class="form-control" id="id_paket" name="id_paket"
                                            value="<?= $paket['id_paket']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama outlet</label>
                                        <select name="nama" id="nama" class="form-control">
                                            <option value=""></option> <!-- Opsi kosong -->
                                            <?php
                                            $query = "SELECT * FROM outlet";
                                            $result = mysqli_query($conn, $query);
                                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <option value="<?= $row['id_outlet'] ?>" <?php if ($row['id_outlet'] == $paket['id_outlet']) {
                                                      echo 'selected';
                                                  } ?>>  <?= $row['nama'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis">Jenis</label>
                                        <select class="form-control" id="jenis" name="jenis" required>
                                            <option value=""> <--- Silahkan Pilih Jenis Paket ---> </option>
                                            <option value="kiloan" <?php if ($paket['jenis'] == 'kiloan')
                                                echo 'selected'; ?>>Kiloan</option>
                                            <option value="selimut" <?php if ($paket['jenis'] == 'selimut')
                                                echo 'selected'; ?>>Selimut</option>
                                            <option value="bed_cover" <?php if ($paket['jenis'] == 'bed_cover')
                                                echo 'selected'; ?>>Bed Cover</option>
                                            <option value="kaos" <?php if ($paket['jenis'] == 'kaos')
                                                echo 'selected'; ?>>
                                                Kaos</option>
                                            <option value="lain" <?php if ($paket['jenis'] == 'lain')
                                                echo 'selected'; ?>>
                                                Lain-lain</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_paket">Nama Paket</label>
                                        <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                            value="<?= $paket['nama_paket']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="number" class="form-control" id="harga" name="harga"
                                            value="<?= $paket['harga']; ?>">
                                    </div>
                                    <?php
                                    // Ambil nilai estimasi dari database berdasarkan id_paket
                                    if (isset($_GET['id'])) {
                                        $id_paket = $_GET['id'];

                                        // Query untuk mengambil nilai estimasi dari database berdasarkan id_paket
                                        $query = "SELECT estimasi FROM paket WHERE id_paket = '$id_paket'";
                                        $result = mysqli_query($conn, $query);

                                        if ($result) {
                                            $row = mysqli_fetch_assoc($result);
                                            $estimasi_dari_database = $row['estimasi'];

                                            // Pisahkan nilai dan satuan jika estimasi tidak kosong
                                            if (!empty($estimasi_dari_database)) {
                                                $estimasi_array = explode(" ", $estimasi_dari_database);
                                                $nilai_estimasi = $estimasi_array[0];
                                                $satuan_estimasi = isset($estimasi_array[1]) ? $estimasi_array[1] : ''; // Pengecekan apakah ada satuan
                                            } else {
                                                // Estimasi belum diisi, tetapkan nilai kosong
                                                $nilai_estimasi = '';
                                                $satuan_estimasi = '';
                                            }
                                        } else {
                                            echo "Error: " . mysqli_error($conn);
                                        }
                                    }
                                    ?>

                                    <div class="form-group">
                                        <label for="estimasi">Estimasi Pengerjaan:</label>
                                        <div style="display: flex; align-items: center;">
                                            <input class="form-control" type="number" id="estimasi" name="estimasi"
                                                min="1" required placeholder="Estimasi"
                                                value="<?php echo $nilai_estimasi; ?>">
                                            <select class="form-control col-md-4" id="satuan" name="satuan" required>
                                                <option value="menit" <?php if ($satuan_estimasi == 'menit')
                                                    echo 'selected'; ?>>Menit</option>
                                                <option value="jam" <?php if ($satuan_estimasi == 'jam')
                                                    echo 'selected'; ?>>Jam</option>
                                                <option value="hari" <?php if ($satuan_estimasi == 'hari')
                                                    echo 'selected'; ?>>Hari</option>
                                            </select>
                                        </div>
                                    </div>


                                    <a href="paket.php" class="btn btn-primary"><i class="fa fa-backward"></i>
                                        KEMBALI
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