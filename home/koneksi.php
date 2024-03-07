<?php
// Konfigurasi Database
$host = "localhost";
$username = "root";
$password = "";
$database = "databases_2024_pengelolaan_laundry";

// Membuat Koneksi
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa Koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
function getRoles($conn) {
    $roles = array();
    $sql = "SHOW COLUMNS FROM user LIKE 'role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $type = $row['Type'];
        preg_match('/enum\((.*)\)$/', $type, $matches);
        $enum = explode(',', $matches[1]);
        foreach ($enum as $value) {
            $roles[] = trim($value, "'");
        }
    }

    return $roles;
}
?>