<?php
// Pastikan session dimulai
session_start();

// Include file koneksi
include('./koneksi/koneksi.php');

// Tambahkan pemeriksaan sesi di sini
if (isset($_SESSION['id_user'])) {
  // Jika pengguna sudah login, arahkan ke halaman sesuai peran (role)
  if ($_SESSION['role'] === 'admin') {
    echo '<script>alert("Anda sudah login sebagai Admin!"); window.location.href = "admin";</script>';
  } elseif ($_SESSION['role'] === 'kasir') {
    echo '<script>alert("Anda sudah login  sebagai Kasir!"); window.location.href = "kasir";</script>';
  } elseif ($_SESSION['role'] === 'owner') {
    echo '<script>alert("Anda sudah login  sebagai Owner!"); window.location.href = "owner";</script>';
  } else {
    header('Location: dashboard.php');
  }
  exit; // Pastikan untuk keluar setelah mengarahkan
}

// Proses Login jika ada data POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Lakukan pengecekan terhadap database untuk mencocokkan informasi login
  $sql = "SELECT * FROM user WHERE username = '$username'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Verifikasi password
    if ($password==$row['password']) {
      // Jika username dan password cocok, set session dan redirect ke halaman sesuai dengan peran (role)
      $_SESSION['id_user'] = $row['id_user'];
      $_SESSION['role'] = $row['role'];

      // Redirect sesuai dengan peran
      if ($_SESSION['role'] === 'admin') {
        echo '<script>alert("Login Berhasil sebagai Admin!"); window.location.href = "admin";</script>';
      } elseif ($_SESSION['role'] === 'kasir') {
        echo '<script>alert("Login Berhasil sebagai Kasir!"); window.location.href = "kasir";</script>';
      } elseif ($_SESSION['role'] === 'owner') {
        echo '<script>alert("Login Berhasil sebagai Owner!"); window.location.href = "owner";</script>';
      } else {
        header('Location: dashboard.php');
      }
      exit(); // Pastikan untuk keluar setelah mengarahkan
    } else {
      echo '<script>alert("Username atau Password salah!"); window.location.href = "index.php";</script>';
    }
  } else {
    echo '<script>alert("Username tidak ditemukan!"); window.location.href = "index.php";</script>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/stylee.css" />
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.png">
  <title>Log In</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form method="post" action="" class="sign-in-form">
          <h2 class="title">Log In</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required />
          </div>
          <input type="submit" value="Login" class="btn solid" />

        </form>

      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Log In Tersedia!</h3>
          <p>
            Silahkan Log In dengan username dan password yang terdaftar!
          </p>

        </div>
        <img src="assets/img/logo2.png" class="image" alt="" />
      </div>

    </div>
  </div>
</body>

</html>