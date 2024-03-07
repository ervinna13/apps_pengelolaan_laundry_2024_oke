
<?php
session_start();
// Sertakan file koneksi
include('../koneksi/koneksi.php');

// Periksa apakah pengguna tidak masuk, redirect ke halaman login
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_member = $_GET['id'];
    $query = "DELETE FROM member WHERE id_member = '$id_member'";
    if ($conn->query($query) === TRUE) {
        // Redirect kembali ke halaman index_customer.php dengan pesan sukses
        echo '<script>alert("DATA BERHASIL DIHAPUS!"); window.location.href = "pelanggan.php";</script>';
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>

