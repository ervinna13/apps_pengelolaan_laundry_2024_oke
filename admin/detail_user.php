<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_user = $_GET['id'];

    // Ambil data user dari database berdasarkan id_user
    $query = "SELECT * FROM user WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        // Jika role adalah admin, maka tidak perlu mencari nama outlet
        if ($user['role'] === 'admin') {
            $user['nama_outlet'] = 'N/A';
        } else {
            // Ambil nama outlet dari tabel outlet
            $query_outlet = "SELECT nama FROM outlet WHERE id_outlet = '{$user['id_outlet']}'";
            $result_outlet = mysqli_query($conn, $query_outlet);
            if ($result_outlet) {
                $outlet = mysqli_fetch_assoc($result_outlet);
                $user['nama_outlet'] = $outlet['nama'];
            } else {
                // Handle error jika query tidak berhasil
                die("Error: " . mysqli_error($conn));
            }
        }
    } else {
        // Handle error jika query tidak berhasil
        die("Error: " . mysqli_error($conn));
    }
} else {
    // Redirect jika parameter id tidak tersedia
    header("Location: user.php");
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
                            <h3 class="page-title mt-5">Detail user</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit user -->
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="id_user">Id user</label>
                                        <input type="text" class="form-control" id="id_user" name="id_user"
                                            value="<?= $user['id_user']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama </label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="<?= $user['nama']; ?>" readonly>
                                    </div>
                                    
                                        <div class="form-group">
                                            <label>username</label><br>
                                            <input type="text" class="form-control" id="username" name="username"
                                            value="<?= $user['username']; ?>" readonly>
                                        </div>
                                        
                                    <div class="form-group">
                                        <label for="password">password</label>
                                        <input class="form-control" id="password" name="password"
                                            readonly value="<?= $user['password']; ?>">
                                    </div>
                                    <div class="form-group" <?php if ($user['role'] === 'admin') echo 'style="display: none;"'; ?> id="outlet_group">
    <label for="nama_outlet">Nama Outlet</label>
    <input type="text" class="form-control" id="nama_outlet" name="nama_outlet"
        value="<?= $user['nama_outlet']; ?>" readonly>
</div>


                                    <div class="form-group">
                                        <label for="id_outlet">Role</label>
                                        <input type="text" class="form-control" id="role" name="role"
                                            value="<?= $user['role']; ?>"  readonly>
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