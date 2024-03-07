<?php
// Include file koneksi
include('./koneksi.php');
session_start();

// Hentikan sesi
session_unset();
session_destroy();

// Redirect ke halaman login

header('Location: index.php');
exit;

