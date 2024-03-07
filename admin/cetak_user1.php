<?php
include('../koneksi/koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect ke halaman login jika tidak memenuhi syarat
    exit();
}


$query = mysqli_query($conn, "SELECT user.*, outlet.nama AS nama_outlet FROM user LEFT JOIN outlet ON user.id_outlet = outlet.id_outlet");


if (!$query) {
    // Handle error jika query tidak berhasil
    die("Error: " . mysqli_error($conn));
}

// Cek apakah ada transaksi yang ditemukan
$num_rows = mysqli_num_rows($query);

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
        border-bottom: 1px solid black;
        border: 1px solid #ddd;
    }
</style>

<body>
    <div class="main-wrapper">
        <!-- <div class="page-wrapper"> -->
        <div class=" container">
            <div class="page-header">
                <!-- <h4 class="card-title">Aplikasi Laundry</h4> -->
            </div>
            <br>
            <div class="content mt-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="row text-center">
                                <?php
                                $querySistem = mysqli_query($conn, "SELECT * from sistem ");
                                if ($querySistem) {
                                    $sistem = mysqli_fetch_assoc($querySistem);
                                } else {
                                    die("Error: " . mysqli_error($conn));
                                } ?>
                                <div class="col-sm-12">
                                    <h4 class="card-title font-weight-bold">
                                        <?= $sistem['apk_name']; ?>
                                    </h4>
                                </div>
                                <div class="col-sm-12">
                                    <img src="../assets/img/logo2.png" class="inv-logo" alt="image">
                                </div>
                                <div class="col-sm-12">
                                    <div class="slogan-right font-weight-bold">
                                        Bersih - Rapi - Wangi
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="slogan-right">
                                        Jln. Mekar Melati, Desa Ladang Peris, Kec. Bajubang, Kab. Batanghari, Jambi
                                    </div>
                                </div>

                            </div>
                            <br>
                            <h4 class="card-title">Data User</h4>
                            <br>
                            <?php if ($num_rows > 0): ?>

                                <table>
                                    <thead>
                                        <tr class="highlighted-row">
                                            <th>No.</th>
                                            <th>ID User</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Nama Outlet</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($user = mysqli_fetch_assoc($query)):
                                            ?>
                                            <tr class="highlighted">
                                                <td>
                                                    <?= $no++; ?>
                                                </td>
                                                <td>
                                                    <?= $user['id_user']; ?>
                                                </td>
                                                <td>
                                                    <?= $user['nama']; ?>
                                                </td>
                                                <td>
                                                    <?= $user['username']; ?>
                                                </td>
                                                <td>
                                                    <?= $user['password']; ?>
                                                </td>
                                                <td>
                                                    <?= $user['nama_outlet']; ?>
                                                </td>
                                                <td>
                                                    <?= ucwords($user['role']); ?>
                                                </td>


                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>

                                </table>
                            <?php else: ?>
                                <p>Data transaksi tidak tersedia untuk rentang tanggal yang diminta.</p>
                            <?php endif; ?>

                        </div>
                        <?php if ($num_rows > 0): ?>
                            <div class="card-body">

                                <br>
                                <p class="text-center">Dicetak pada: <b>
                                        <?= date(' d F Y'); ?>
                                    </b><i>&commat;
                                        Laundryuk
                                    </i>
                                </p>
                            </div>
                        <?php endif; ?>
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