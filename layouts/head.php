<?php 
include '../koneksi/koneksi.php'; 

$querySistem = mysqli_query($conn, "SELECT * from sistem ");
if ($querySistem) {
    $sistem = mysqli_fetch_assoc($querySistem);
} else {
    die("Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?= $sistem['apk_name']; ?></title>
	<!-- <link rel="shortcut icon" type="image/x-icon" href="../assets/img/ly1.png"> -->
	<link rel="shortcut icon" type="image/x-icon" href="../assets/img/logo2.png">
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="../assets/css/feathericon.min.css">
	<link rel="stylehseet" href="https://cdn.oesmith.co.uk/morris-0.5.1.css">
	<link rel="stylesheet" href="../assets/plugins/morris/morris.css">
	<link rel="stylesheet" href="../assets/css/style.css">
</head>