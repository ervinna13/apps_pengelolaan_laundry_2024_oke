<?php
include('../koneksi/koneksi.php');
session_start(); ?>
<?php include 'head.php'; ?>

<body>
    <?php
    include 'header.php';

    ?>
    <section class="service_area">
        <div class="container">
            <div class="banner_text">
                <h3>Paket</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="paket.php">Paket</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!--================Welcome Area =================-->
    <section class="product_details_area p_100">
        <div class="container">

            <div class="cake_feature_inner">
                <div class="main_title">
                    <h2>Berbagai paket yang tersedia...</h2>
                    <h5>Total paket keseluruhan :
                        <?php
                        // Query untuk mendapatkan jumlah paket dari database
                        $querypaket = "SELECT COUNT(*) AS totalpaket FROM paket";
                        $resultpaket = $conn->query($querypaket);

                        if ($resultpaket) {
                            $rowpaket = $resultpaket->fetch_assoc();
                            $totalpaket = $rowpaket['totalpaket'];

                            // Menampilkan jumlah paket dalam HTML
                            echo $totalpaket;
                        } else {
                            // Menampilkan pesan kesalahan jika query tidak berhasil
                            echo '<h3>Error</h3>';
                        }
                        ?>
                        paket...
                    </h5>
                </div>
                <div class="cake_feature_slider owl-carousel">
                    <?php

                    // Query untuk mengambil data paket dari tabel
                    $sql = "SELECT paket.*, outlet.nama FROM paket INNER JOIN outlet ON paket.id_outlet = outlet.id_outlet ";
                    $result = $conn->query($sql);

                    // Periksa apakah ada data yang diambil
                    if ($result->num_rows > 0) {
                        $counter = 1; // Inisialisasi nomor berurutan
                        // Loop melalui setiap baris data
                        while ($row = $result->fetch_assoc()) {
                            // Tampilkan informasi paket dalam HTML
                            echo '<div class="item">';
                            echo '<div class="cake_feature_item">';
                            echo '<div class="cake_img">';
                            echo '<img src="../uploads/' . $row['foto_pkt'] . '" alt="" style="width: 270px; height: 210px;>'; // asumsi kolom gambar di tabel paket
                            echo '</div>';
                            echo '<div class="cake_text">';
                            echo '<h4>' . $counter . '</h4>'; // Tampilkan nomor berurutan
                            echo '<h3>' . $row['nama_paket'] . '</h3>'; // asumsi kolom nama_paket di tabel paket
                            echo '<h5>' . $row['nama'] . '</h5>'; // asumsi kolom no_telepon di tabel paket
                            echo '<h6>Rp. ' . $row['harga'] . '</h6>';
                            echo '</div>';
                            echo '<br>';
                            echo '<a class="pest_btn" href="detail_paket.php?id=' . $row['id_paket'] . '"> ' .'lihat detail' . '</a>';

                            echo '</div>';
                            echo '</div>';
                            $counter++; // Tingkatkan nomor berurutan
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>

                </div>
            </div>
        </div>
    </section>
    <!--================End Welcome Area =================-->

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