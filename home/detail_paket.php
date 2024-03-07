<?php

include('../koneksi/koneksi.php');
session_start(); 

if (isset($_GET['id'])) {
    $id_paket = $_GET['id'];
    $id_paket = mysqli_real_escape_string($conn, $id_paket); 

    $query = "SELECT paket.*, outlet.nama FROM paket INNER JOIN outlet ON paket.id_outlet = outlet.id_outlet WHERE paket.id_paket='$id_paket';";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $paket = mysqli_fetch_assoc($result);
    } else {
        echo "Failed to fetch data: " . mysqli_error($conn);
        exit;
    }
} else {
    // Redirect or show an error message
    echo "Gagal";
    exit;
} ?>

<?php include 'head.php'; ?>

<body>
    <?php
    include 'header.php';

    ?>
    <section class="service_area">
        <div class="container">
            <div class="banner_text">
                <h3>Detail Paket</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="paket.php">Detail Paket</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!--================Product Details Area =================-->
    <section class="product_details_area p_100">
        <div class="container">
            <div class="row product_d_price">
                <div class="col-lg-6">
                    <div class="product_img">
                    <img class="img-fluid" src="../uploads/<?= $paket['foto_pkt']; ?>" alt="" style="width: 500px; height:420px;"> 
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product_details_text">
                        <h4> <?= $paket['nama_paket']; ?></h4>
                        <p> Outlet  : <?= $paket['nama']; ?>
                            <br>
                            Jenis   : <?= $paket['jenis']; ?>
                            <br>
                            Estimasi Pengerjaan : <?= $paket['estimasi']; ?> hari
                        </p>
                        <h5>Harga   : <span>Rp.  <?= number_format($paket['harga'], 0, ',', '.'); ?></span></h5>
                        <!-- <div class="quantity_box">
                            <label for="quantity">Quantity :</label>
                            <input type="text" placeholder="1" id="quantity">
                        </div>
                        <a class="pink_more" href="#">Add to Cart</a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Details Area =================-->
    <?php include 'footer.php'; ?>

    <!--================Search Box Area =================-->
    <div class="search_area zoom-anim-dialog mfp-hide" id="test-search">
        <div class="search_box_inner">
            <h3>Search</h3>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="icon icon-Search"></i></button>
                </span>
            </div>
        </div>
    </div>
    <!--================End Search Box Area =================-->

    <?php include 'script.php'; ?>
</body>

</html>