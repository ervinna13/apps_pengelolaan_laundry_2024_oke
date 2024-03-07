
<?php
$conn = new mysqli("localhost", "root", "", "databases_2024_pengelolaan_laundry");

session_start(); ?>
<?php include 'head.php'; ?>

<body>
    <?php
    include 'header.php';

    ?>
    <section class="service_area">
        <div class="container">
            <div class="banner_text">
                <h3>Lihat Proses</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="lihat_proses.php">Lihat Proses</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!--================Product Area =================-->
    <section class="product_area p_100">
        <div class="container">
            <div class="row product_inner_row">
                <div class="col-lg-12">
                    <div class="product_left_sidebar">
                        <aside class="left_sidebar search_widget">

                            <div class="input-group">
                                <input type="text" class="form-control" id="search-input"
                                    placeholder="Enter Search Keywords" aria-label="search" aria-describedby="search">
                                <div class="input-group-append">
                                    <button class="btn" type="button"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </aside>
                        <div id="table-container" class="table-responsive" style="display: none;">
                            <table class="table table-striped" id="outlet-table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kode Invoice</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Estimasi Selesai</th>
                                        <th>Paket</th>
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $queryTran = "SELECT 
                                                detail_transaksi.*,
                                                transaksi.*,
                                                paket.*,
                                                member.*,
                                                ((paket.harga * detail_transaksi.qty) + transaksi.biaya_tambahan +(transaksi.pajak / 100 * (paket.harga * detail_transaksi.qty)) - (transaksi.diskon / 100 * paket.harga)) AS total
                                            FROM 
                                                detail_transaksi
                                            JOIN 
                                                transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi
                                            JOIN 
                                                paket ON detail_transaksi.id_paket = paket.id_paket
                                            LEFT JOIN 
                                                member ON transaksi.id_member = member.id_member;
                                            ";
                                    $tranResult = $conn->query($queryTran);
                                    // Pastikan query berhasil dieksekusi
                                    if ($tranResult && $tranResult->num_rows > 0) {
                                        while ($transaksi = $tranResult->fetch_assoc()) { ?>
                                             <tr>
                                                <td>
                                                    <?php echo $transaksi['nama']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $transaksi['kode_invoice']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $transaksi['tgl']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $transaksi['nama_paket']; ?></label>
                                                </td>
                                                <td> Rp. 
                                                    <?php echo number_format($transaksi['total']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $transaksi['batas_waktu']; ?>
                                                </td>

                                                <td>
                                                    <?php echo $transaksi['status']; ?><br>
                                                    <?php echo $transaksi['dibayar']; ?>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results"; // Pesan jika tidak ada hasil dari query
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!--================End Product Area =================-->

    <?php include 'footer.php'; ?>
    <script>
        document.getElementById('search-input').addEventListener('input', function () {
            let searchQuery = this.value.toLowerCase();
            let tableContainer = document.getElementById('table-container');
            let rows = tableContainer.getElementsByTagName('tr');

            if (searchQuery.trim() === '') {
                tableContainer.style.display = 'none'; // Sembunyikan tabel jika input kosong
                return;
            }

            tableContainer.style.display = 'block'; // Tampilkan tabel jika input tidak kosong

            for (let i = 1; i < rows.length; i++) {
                let row = rows[i];
                let rowData = row.innerText.toLowerCase();
                if (rowData.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    </script>
    <!--================End Search Box Area =================-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Rev slider js -->
    <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <!-- Extra plugin js -->
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
    <script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
    <script src="vendors/isotope/isotope.pkgd.min.js"></script>
    <script src="vendors/datetime-picker/js/moment.min.js"></script>
    <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
    <script src="vendors/lightbox/simpleLightbox.min.js"></script>

    <script src="js/theme.js"></script>
    <?php include 'script.php'; ?>
</body>

</html>