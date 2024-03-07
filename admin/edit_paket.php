<?php
session_start();
// Sertakan file koneksi
include('../koneksi/koneksi.php');

// Check jika pengguna belum ../index, redirect ke halaman ../index
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_paket = $_POST['id_paket'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $estimasi = $_POST['estimasi'];

    // Cek apakah ada file foto yang diunggah
    if ($_FILES['foto']['name'] != '') {
        $foto = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $upload_path = '../uploads/';

        // Maksimum ukuran file (dalam bytes)
        $max_size = 1048576; // 1 MB

        // Memeriksa ekstensi file
        $allowed_ext = array('png', 'jpg', 'jpeg');
        $file_ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext)) {
            // Memeriksa ukuran file
            if ($_FILES['foto']['size'] <= $max_size) {
                // Pengaturan nama unik
                $foto_unik = uniqid() . '_' . $foto;

                // Pindahkan file foto yang diunggah ke folder uploads
                if (move_uploaded_file($tmp_name, $upload_path . $foto_unik)) {
                    // Update data customer dalam database termasuk foto baru
                    $query = "UPDATE paket SET 
                    id_outlet = '$nama',
                    jenis = '$jenis',
                    nama_paket = '$nama_paket',
                    harga = '$harga',
                    estimasi = '$estimasi',
                                foto_pkt = '$foto_unik'
                                WHERE id_paket = '$id_paket'";

                    if ($conn->query($query) === TRUE) {
                        echo '<script>alert("DATA BERHASIL DIUBAH!"); window.location.href = "paket.php";</script>';
                        exit;
                    } else {
                        die("Error: " . mysqli_error($conn));
                    }
                } else {
                    echo "Maaf, terjadi kesalahan saat mengunggah file.";
                }
            } else {
                echo "Ukuran file terlalu besar. Maksimum 1 MB.";
            }
        } else {
            echo "Format file tidak didukung. Harap unggah file dengan format PNG, JPG, atau JPEG.";
        }
    } else {
        // Update data customer dalam database tanpa mengubah foto
        $query = "UPDATE paket SET 
                   id_outlet = '$nama',
                    jenis = '$jenis',
                    nama_paket = '$nama_paket',
                    harga = '$harga',
                    estimasi = '$estimasi'
                    WHERE id_paket = '$id_paket'";

        if ($conn->query($query) === TRUE) {
            echo '<script>alert("DATA BERHASIL DIUBAH!"); window.location.href = "paket.php";</script>';
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
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
        echo "Data customer tidak ditemukan.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../layouts/head.php'); ?>

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
                                <!-- Form edit paket -->
                                <form action="" method="POST" enctype="multipart/form-data">

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
                                    <div class="form-group">
                                        <label for="estimasi">Estimasi Pengerjaan:</label>
                                        <div style="display: flex; align-items: center;">
                                            <input class="form-control" type="number" id="estimasi" name="estimasi"
                                                min="1"  value="<?= $paket['estimasi']; ?>">

                                        </div>
                                        <span style="color:red;">*Perkiraan Hari</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Foto</label>
                                        <br>
                                        <img id="preview" src="../uploads/<?= $paket['foto_pkt']; ?>" alt="Foto paket"
                                            style="width: 100px; height: auto;">
                                        <br>
                                        <label for="current_foto">Foto Lama: </label>
                                        <span id="current_foto">
                                            <?= $paket['foto_pkt']; ?>
                                        </span>

                                        <input type="file" class="form-control-file" id="foto" name="foto"
                                            onchange="previewImage()">
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

        function previewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("foto").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("preview").src = oFREvent.target.result;
            };
        }
    </script>
</body>

</html>