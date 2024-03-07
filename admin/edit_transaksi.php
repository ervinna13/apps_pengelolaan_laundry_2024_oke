<?php
include('../koneksi/koneksi.php');
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah ID transaksi ada dalam request dan tidak kosong
    if (isset($_POST['id_transaksi']) && !empty($_POST['id_transaksi'])) {
        $id_transaksi = $_POST['id_transaksi'];

        // Ambil nilai status dan status bayar dari form
        $status = $_POST['status'];
        $dibayar = $_POST['dibayar'];

        // Buat query UPDATE untuk memperbarui status, status bayar, dan tanggal bayar transaksi
        $query_update_transaksi = "UPDATE transaksi 
                           SET status = '$status', 
                               dibayar = '$dibayar'";

        // Jika status bayar berubah, update juga tanggal bayar
        if ($dibayar == 'dibayar') {
            $query_update_transaksi .= ", tgl_bayar = NOW()";
        }

        $query_update_transaksi .= " WHERE id_transaksi = '$id_transaksi'";

        // Lakukan update data
        if ($conn->query($query_update_transaksi) === TRUE) {
            // Redirect sesuai kondisi
            if ($status == 'dibayar') {
                // Arahkan ke halaman print struk
                header("Location: print_laporan.php?id_transaksi=$id_transaksi");
            } else {
                // Arahkan ke halaman transaksi
                header("Location: transaksi.php");
            }
            exit;
        } else {
            // Tampilkan pesan error jika query tidak berhasil
            echo "Error: " . $query_update_transaksi . "<br>" . $conn->error;
        }
    } else {
        // Tampilkan pesan error jika ID transaksi tidak ada dalam request
        echo "Invalid request!";
    }
} else {
    // Tampilkan pesan error jika request bukan metode POST
    // echo "Invalid request method!";
}



if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $query = mysqli_query($conn, "SELECT transaksi.*, member.nama AS nama_member, detail_transaksi.qty AS qty,  paket.jenis AS jenis,  paket.harga AS harga, paket.nama_paket, outlet.nama AS nama_outlet
    FROM transaksi
    INNER JOIN member ON transaksi.id_member = member.id_member
    INNER JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
    INNER JOIN paket ON detail_transaksi.id_paket = paket.id_paket
    INNER JOIN outlet ON transaksi.id_outlet = outlet.id_outlet
    WHERE transaksi.id_transaksi = '$id_transaksi'");
    if ($query) {
        $transaksi = mysqli_fetch_assoc($query);
    } else {
        // Handle error jika query tidak berhasil
        die("Error: " . mysqli_error($conn));
    }
} else {
    // Redirect jika parameter id tidak tersedia
    header("Location: transaksi.php");
    exit();
}
?>
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
                            <h3 class="page-title mt-5">Edit transaksi</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Form edit transaksi -->
                                <form method="POST" action=" ">
                                    <?php ?>
                                    <div class="form-group" style="display:none;">
                                        <label for="id_transaksi">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="id_transaksi" name="id_transaksi"
                                            value="<?= $transaksi['id_transaksi']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="berat_cucian">Waktu Transaksi</label>
                                        <input class="form-control" id="berat_cucian" name="berat_cucian"
                                            value=" <?= $transaksi['tgl']; ?> " readonly>

                                    </div>
                                    <div class="form-group">
                                        <label for="nama_member">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama_member" name="nama_member"
                                            value="<?= $transaksi['nama_member']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_outlet">Nama Outlet</label>
                                        <input type="text" class="form-control" id="nama_outlet" name="nama_outlet"
                                            value="<?= $transaksi['nama_outlet']; ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_paket">Berat Cucian</label>
                                        <input class="form-control" id="nama_paket" name="nama_paket"
                                            value=" <?= $transaksi['nama_paket']; ?> " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="berat_cucian">Nama Paket</label>
                                        <input class="form-control" id="berat_cucian" name="berat_cucian"
                                            value=" <?= $transaksi['qty']; ?>  <?= $transaksi['jenis']; ?>" readonly>

                                    </div>
                                    <?php
                                    $jumlah = $transaksi['qty'];
                                    $harga_paket = $transaksi['harga'];
                                    $biaya_tambahan = $transaksi['biaya_tambahan'];
                                    $total = $harga_paket * $jumlah;
                                    $diskon = $transaksi['diskon'] / 100 * $total;
                                    $total_ = number_format($total);
                                    $total_harga = ($jumlah * $harga_paket) - $diskon + $biaya_tambahan;
                                    $total_harga_ = number_format($total_harga);
                                    $pajak = $transaksi['pajak'] / 100 * $total_harga;
                                    $total_harga1 = $total_harga + $pajak; ?>
                                    <div class="form-group">
                                        <label for="harga">Total Bayar</label>
                                        <input type="text" class="form-control" id="harga" name="harga"
                                            value="Rp.  <?= number_format($total_harga1, 2, '.', ''); ?>" readonly>
                                    </div>

                                    <?php if ($transaksi['status'] != 'diambil'): ?>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="baru" <?php if ($transaksi['status'] == 'baru')
                                                    echo 'selected'; ?>>Baru</option>
                                                <option value="proses" <?php if ($transaksi['status'] == 'proses')
                                                    echo 'selected'; ?>>Proses</option>
                                                <option value="selesai" <?php if ($transaksi['status'] == 'selesai')
                                                    echo 'selected'; ?>>Selesai</option>
                                                <option value="diambil" <?php if ($transaksi['status'] == 'diambil')
                                                    echo 'selected'; ?>>Diambil</option>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <input class="form-control" id="status" name="status"
                                                value="<?= $transaksi['status']; ?>" readonly>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($transaksi['dibayar'] != 'dibayar'): ?>
                                        <div class="form-group">
                                            <label for="dibayar">Status Bayar</label>
                                            <select class="form-control" id="dibayar" name="dibayar" required>
                                                <option value="dibayar" <?php if ($transaksi['dibayar'] == 'dibayar')
                                                    echo 'selected'; ?>>Dibayar</option>
                                                <option value="belum_dibayar" <?php if ($transaksi['dibayar'] == 'belum_dibayar')
                                                    echo 'selected'; ?>>Belum
                                                    Dibayar</option>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group">
                                            <label for="dibayar">Status Bayar</label>
                                            <input class="form-control" id="dibayar" name="dibayar"
                                                value="<?= $transaksi['dibayar']; ?>" readonly>
                                        </div>
                                    <?php endif; ?>

                                    <hr>
                                    <a onclick="window.history.back()" type="button" class="btn btn-secondary"><i
                                            class="fas fa-arrow-left"></i> Back
                                    </a>
                                    <button id="submitBtn" type="submit" name="submit" class="btn btn-info">Update</button>

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
    <!-- Modal Konfirmasi Pembayaran -->
    <div class="modal fade" id="konfirmasiPembayaranModal" tabindex="-1" role="dialog"
        aria-labelledby="konfirmasiPembayaranModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="konfirmasiPembayaranModalLabel">Konfirmasi Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Total yang harus dibayar: <span id="totalHargaModal"></span></p>
                    <p>Tunai: <input type="number" id="jumlahUangDibayar" class="form-control" placeholder="Jumlah uang"
                            name="" required></p>
                    <p>Kembaliannya: <span id="kembalian"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="konfirmasiPembayaranButton">Konfirmasi
                        Pembayaran</button>
                </div>
            </div>
        </div>
    </div>
    <script>
       // Event listener saat input jumlah uang yang akan dibayar berubah
		document.getElementById("jumlahUangDibayar").addEventListener("input", function () {
			// Ambil nilai total harga dari elemen HTML
			var totalHarga = parseFloat(document.getElementById("totalHargaModal").innerText.replace("Rp. ", ""));
			// Ambil nilai jumlah uang yang akan dibayar
			var jumlahUangDibayar = parseFloat(this.value);

			// Hitung kembalian
			var kembalian = jumlahUangDibayar - totalHarga;

			// Tampilkan kembalian
			document.getElementById("kembalian").innerText = "Rp. " + kembalian.toFixed(2);
		});
        // Event listener saat opsi pembayaran dipilih
        document.getElementById("dibayar").addEventListener("change", function () {
            // Ambil nilai status pembayaran yang dipilih
            var status_pembayaran = this.value;
            // Jika status pembayaran adalah "dibayar", tampilkan modal konfirmasi
            if (status_pembayaran === "dibayar") {
                // Ambil total harga dari elemen HTML
                var totalHarga = document.getElementById("harga").value;
                // Tampilkan total harga dalam modal
                document.getElementById("totalHargaModal").innerText = totalHarga;
                // Tampilkan modal konfirmasi
                $('#konfirmasiPembayaranModal').modal('show');
            }
        });
        // Event listener untuk menangkap aksi ketika modal ditutup
        $('#konfirmasiPembayaranModal').on('hidden.bs.modal', function () {
            // Periksa apakah tombol konfirmasi pembayaran belum diklik
            var isConfirmed = document.getElementById("konfirmasiPembayaranButton").getAttribute("data-confirmed");
            // Jika tombol konfirmasi belum diklik dan modal ditutup, ubah status pembayaran kembali menjadi "belum_dibayar"
            if (!isConfirmed || isConfirmed !== "true") {
                // Ubah opsi pembayaran menjadi "belum_dibayar"
                document.getElementById("dibayar").value = "belum_dibayar";
            }
        });
        // Event listener saat tombol konfirmasi pembayaran diklik
        document.getElementById("konfirmasiPembayaranButton").addEventListener("click", function () {
            // Set nilai data-confirmed menjadi "true" saat tombol diklik
            this.setAttribute("data-confirmed", "true");
        });
        // Event listener saat tombol konfirmasi pembayaran diklik
		document.getElementById("konfirmasiPembayaranButton").addEventListener("click", function () {
			// Ambil nilai total harga dari elemen HTML
			var totalHarga = parseFloat(document.getElementById("totalHargaModal").innerText.replace("Rp. ", ""));
			// Ambil nilai jumlah uang yang akan dibayar
			var jumlahUangDibayar = parseFloat(document.getElementById("jumlahUangDibayar").value);

			// Hitung kembalian
			var kembalian = jumlahUangDibayar - totalHarga;

			// Tampilkan kembalian dalam modal
			document.getElementById("kembalian").innerText = "Rp. " + kembalian.toFixed(2);

			// Lakukan aksi konfirmasi pembayaran di sini
			// Misalnya, mengirimkan data ke server atau menampilkan pesan konfirmasi
			alert("Pembayaran berhasil dikonfirmasi!");

			// Tutup modal setelah konfirmasi
			$('#konfirmasiPembayaranModal').modal('hide');

			// Klik tombol submit secara otomatis
			document.getElementById("submitBtn").click();

		});
    </script>



    <script>
        $(function () {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
        });
    </script>
</body>

</html>