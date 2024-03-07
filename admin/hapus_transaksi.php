<?php
session_start();
// Sertakan file koneksi
include('../koneksi/koneksi.php');

// Periksa apakah pengguna tidak masuk, redirect ke halaman login
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_transaksi = $_GET['id'];

    // Hapus terlebih dahulu entri terkait dari tabel detail_transaksi
    $query_delete_detail_transaksi = "DELETE FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'";
    if ($conn->query($query_delete_detail_transaksi) === TRUE) {
        // Setelah menghapus entri terkait dari detail_transaksi, baru hapus entri dari tabel transaksi
        $query_delete_transaksi = "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'";
        if ($conn->query($query_delete_transaksi) === TRUE) {
            // Redirect kembali ke halaman transaksi.php dengan pesan sukses
            echo '<script>alert("DATA BERHASIL DIHAPUS!"); window.location.href = "transaksi.php";</script>';
            exit;
        } else {
            echo "Error: " . $query_delete_transaksi . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $query_delete_detail_transaksi . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>