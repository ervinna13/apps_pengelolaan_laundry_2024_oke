<?php

session_start();
$conn = new mysqli("localhost", "root", "", "databases_2024_pengelolaan_laundry");

$id_user = $_SESSION['id_user'];
$query_user = "SELECT user.role, password, user.nama AS user_nama, user.username, outlet.nama AS nama_outlet 
                FROM user 
                INNER JOIN outlet ON user.id_outlet = outlet.id_outlet
                WHERE user.id_user = '$id_user'";
$result_user = mysqli_query($conn, $query_user);

if (!$result_user) {
    echo "Error: " . $query_user . "<br>" . mysqli_error($conn);
    exit();
}

$row_user = mysqli_fetch_assoc($result_user);
$nama = $row_user['user_nama']; // Gunakan alias yang diberikan pada kolom 'nama'
$username = $row_user['username'];
$role = $row_user['role'];
$password = $row_user['password'];
$outlet = $row_user['nama_outlet'];

$querySistem = mysqli_query($conn, "SELECT * from sistem ");
if ($querySistem) {
    $sistem = mysqli_fetch_assoc($querySistem);
} else {
    die("Error: " . mysqli_error($conn));
}

// Proses penyimpanan perubahan jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Jika form 'edit_tentang' disubmit
    if (isset($_POST['edit_tentang'])) {
        $apk_name = $_POST['apk_name'];
        $slogan = $_POST['slogan'];
        $email = $_POST['email'];
        $tlp_ = $_POST['tlp_'];
        $alamat = $_POST['alamat'];

        // Update data tentang
        $updateTentang = mysqli_query($conn, "UPDATE sistem SET apk_name = '$apk_name', tlp_ = '$tlp_', alamat = '$alamat', email = '$email', slogan = '$slogan'");
        if ($updateTentang) {
            echo '<script>alert("Data tentang berhasil diubah!"); window.location.href = "profil.php";</script>';
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    // Jika form 'edit_biaya' disubmit
    if (isset($_POST['edit_biaya'])) {
        $pajak = $_POST['pajak'];
        $antar = $_POST['antar'];
        $diskon_mb = $_POST['diskon_mb'];
        $antar_jemput = $_POST['antar_jemput'];

        // Update data biaya
        $updateBiaya = mysqli_query($conn, "UPDATE sistem SET pajak = '$pajak', antar = '$antar', diskon_mb = '$diskon_mb', antar_jemput = '$antar_jemput'");
        if ($updateBiaya) {
            echo '<script>alert("Data biaya berhasil diubah!"); window.location.href = "profil.php";</script>';
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

?>
<?php include('../layouts/head.php'); ?>

<body>
    <div class="main-wrapper">
        <?php include('../layouts/header.php'); ?>
        <?php include('../layouts/sidebar.php'); ?>
        <div class="page-wrapper" style="min-height: 654px;">
            <div class="content container-fluid">
                <div class="page-header mt-5">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title">Profile</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-header">
                            <div class="row align-items-center">
                                <div class="col-auto profile-image">
                                    <a href="#"> <img class="rounded-circle" alt="User Image"
                                            src="../assets/img/profiles/profil.png"> </a>
                                </div>
                                <div class="col ml-md-n2 profile-user-info">
                                    <h2 class="user-name mb-3">
                                        <?= ucwords($username); ?>
                                    </h2>
                                    <h6 class="text-muted mt-1">
                                        <?= $nama; ?>
                                    </h6>
                                    <div class="about-text">
                                        <?= $outlet; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-menu">
                            <ul class="nav nav-tabs nav-tabs-solid">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab"
                                        href="#per_details_tab">Tentang</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab"
                                        href="#password_tab">Profil</a> </li>
                            </ul>
                        </div>
                        <div class="tab-content profile-tab-cont">
                            <div class="tab-pane fade active show" id="per_details_tab">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title d-flex justify-content-between">
                                                    <span>Tentang</span>
                                                    <a class="edit-link" data-toggle="modal"
                                                        href="#edit_personal_details"><i
                                                            class="fa fa-edit mr-1"></i>Edit</a>
                                                </h5>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Nama Aplikasi</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5">
                                                        <?= $sistem['apk_name']; ?>
                                                    </p>
                                                </div>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Slogan</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5">
                                                        <?= $sistem['slogan']; ?>
                                                    </p>
                                                </div>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Email</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5">
                                                        <?= $sistem['email']; ?>
                                                    </p>
                                                </div>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Telp.</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5">
                                                        <?= $sistem['tlp_']; ?>
                                                    </p>
                                                </div>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Alamat</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5">
                                                        <?= $sistem['alamat']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="edit_personal_details" aria-hidden="true"
                                            style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Tentang</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"> <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST">
                                                            <div class="row form-row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Nama Aplikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            name="apk_name"
                                                                            value="<?= $sistem['apk_name']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Slogan</label>
                                                                        <input type="text" class="form-control"
                                                                            name="slogan"
                                                                            value="<?= $sistem['slogan']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input type="email" class="form-control"
                                                                            name="email"
                                                                            value="<?= $sistem['email']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Telp.</label>
                                                                        <input type="number" class="form-control"
                                                                            name="tlp_" value="<?= $sistem['tlp_']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 ">
                                                                    <div class="form-group">
                                                                        <label>Alamat</label>
                                                                        <input type="text" class="form-control"
                                                                            name="alamat"
                                                                            value="<?= $sistem['alamat']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           <button type="submit" class="btn btn-primary btn-block" name="edit_tentang">Simpan Perubahan Tentang</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title d-flex justify-content-between">
                                                    <span>Biaya</span>
                                                    <a class="edit-link" data-toggle="modal"
                                                        href="#edit_personal_detail"><i
                                                            class="fa fa-edit mr-1"></i>Edit</a>
                                                </h5>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Pajak</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5">
                                                        <?= $sistem['pajak']; ?><span>%</span>
                                                    </p>
                                                </div>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Diskon</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5">
                                                        <?= $sistem['diskon_mb']; ?><span>%</span>
                                                    </p>
                                                </div>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Biaya Antar</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5"><span>Rp. </span>
                                                        <?= number_format($sistem['antar']); ?>
                                                    </p>
                                                </div>
                                                <div class="row mt-5">
                                                    <p class="col-sm-5  mb-0 mb-sm-3">Biaya Antar-Jemput</p>
                                                    <p class="col-sm-2 text-sm-left">:</p>
                                                    <p class="col-sm-5"><span>Rp. </span>
                                                        <?= number_format($sistem['antar_jemput']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="edit_personal_detail" aria-hidden="true"
                                            style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Biaya</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"> <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST">
                                                                <div class="row form-row">
                                                                    <div class="col-12 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Pajak Persen</label>
                                                                            <input type="number" class="form-control"
                                                                                name="pajak"
                                                                                value="<?= $sistem['pajak']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Diskon Persen</label>
                                                                            <input type="number" class="form-control"
                                                                                name="diskon_mb"
                                                                                value="<?= $sistem['diskon_mb']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Biaya Antar</label>
                                                                            <input type="number" class="form-control"
                                                                                name="antar"
                                                                                value="<?= $sistem['antar']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Biaya Antar-Jemput</label>
                                                                            <input type="text" class="form-control"
                                                                                name="antar_jemput"
                                                                                value="<?= $sistem['antar_jemput']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-block" name="edit_biaya">Simpan Perubahan Biaya</button>
                                                            </form>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="password_tab" class="tab-pane fade">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Profil</h5>
                                        <div class="row">
                                            <div class="col-md-10 col-lg-6">
                                                <form>
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" readonly
                                                            value="<?= ucwords($nama); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" class="form-control"
                                                            value="<?= ucwords($username); ?>" readonly>
                                                    </div>
                                                    <!-- <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="text" class="form-control"
                                                            value="<?= $password; ?>" readonly>
                                                    </div> -->

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../layouts/footer.php'); ?>
</body>

</html>