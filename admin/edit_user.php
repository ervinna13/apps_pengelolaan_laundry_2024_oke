<?php
session_start();
// Sertakan file koneksi
include('../koneksi/koneksi.php');

// Check jika pengguna belum ../index, redirect ke halaman ../index
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
// Proses edit data customer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $id_outlet =  $_POST['nama_outlet'];

    // Update data customer dalam database
    $query = "UPDATE user SET 
                nama = '$nama',
                username = '$username',
                password = '$password',
                role = '$role', id_outlet = '$id_outlet'
                WHERE id_user = '$id_user'";

    if ($conn->query($query) === TRUE) {
        echo '<script>alert("DATA BERHASIL DIUBAH!"); window.location.href = "user.php";</script>';
        exit;
    } else {
        die("Error: " . mysqli_error($conn));
        // echo "Error: " . $query . "<br>" . $conn->error;
    }
}
// Ambil ID customer dari parameter URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_user = $_GET['id'];
    // Ambil data customer dari database berdasarkan ID
    $query = "SELECT * FROM user WHERE id_user = '$id_user'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Data user tidak ditemukan.";
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
                            <h3 class="page-title mt-5">Edit user</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="id_user">Id user</label>
                                        <input type="text" class="form-control" id="id_user" name="id_user"
                                            value="<?= $user['id_user']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama </label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="<?= $user['nama']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input class="form-control" id="username" name="username"
                                            required value="<?= $user['username']; ?>"></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control" id="password" name="password"
                                            required value="<?= $user['password']; ?>"></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <?php
                                            $enum_values = mysqli_fetch_assoc(mysqli_query($conn, "SHOW COLUMNS FROM user LIKE 'role'"))['Type'];
                                            preg_match('/enum\((.*)\)$/', $enum_values, $matches);
                                            $enum = str_getcsv($matches[1], ",", "'");
                                            foreach ($enum as $value) {
                                                echo '<option value="' . $value . '"';
                                                if ($value === $user['role']) {
                                                    echo ' selected';
                                                }
                                                echo '>' . $value . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group" id="outlet_group" <?php if ($user['role'] === 'admin') echo 'style="display: none;"'; ?>>
                                        <label for="nama_outlet">Nama outlet</label>
                                        <select name="nama_outlet" id="nama_outlet" class="form-control">
                                            <option value=""></option>
                                            <?php
                                            $query = "SELECT * FROM outlet";
                                            $result = mysqli_query($conn, $query);
                                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <option value="<?= $row['id_outlet'] ?>" <?php if ($row['id_outlet'] == $user['id_outlet']) {
                                                                                              echo 'selected';
                                                                                          } ?>> <?= $row['nama'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
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
        $(document).ready(function () {
            $("#role").change(function () {
                if ($(this).val() !== 'admin') {
                    $("#outlet_group").show();
                } else {
                    $("#outlet_group").hide();
                }
            }).change(); // Untuk memastikan kondisi div outlet sesuai dengan role yang terpilih saat halaman dimuat
        });
    </script>
</body>
</html>
