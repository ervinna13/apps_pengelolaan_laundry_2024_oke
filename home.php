<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaundryUK - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* CSS styling untuk header dan footer */
        header {
            background-color: #009688;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            z-index: 999; /* untuk mengatasi tumpukan */
            top: 0;
        }
        footer {
            background-color: #009688;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
            bottom: 0;
        }

        /* CSS styling untuk navbar */
        nav {
            background-color: #f2f2f2;
            /* overflow: hidden; */
            position: fixed;
            width: 100%;
            /* z-index: 998;  */
            top: 50px; /* Tinggi header */
        }


        nav a {
            color: #333;
            text-align: center;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }
        
        body {
            margin-top: 70px; /* Adjust body margin for fixed header */
            /* margin-bottom: 70px;  */
        }
    </style>
</head>
<body>

<header>
    <img src="assets/img/l1.png" alt="LaundryUK Logo" style="height: 50px;"> <!-- Ubah path_to_your_logo dengan path sebenarnya -->
    <h1 style="margin-top: 5px;">LaundryUK</h1>
</header>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#home"><i class="fas fa-home"></i> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#outlet"><i class="fas fa-store"></i> Outlet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#transaction"><i class="fas fa-exchange-alt"></i> Proses Transaksi</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container" style="padding-top: 100px;">
    <h2>Home</h2>
    <p>Selamat datang di LaundryUK. Silakan temukan produk kami atau proses transaksi Anda.</p>
</div>

<div id="outlet" class="container">
    <h2>Outlet</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="outlet-box">
                <h3>Outlet A</h3>
                <p>Outlet A adalah tempat terbaik untuk mendapatkan pelayanan laundry dengan kualitas terbaik.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="outlet-box">
                <h3>Outlet B</h3>
                <p>Outlet B menawarkan layanan laundry cepat dan efisien untuk kebutuhan Anda sehari-hari.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="outlet-box">
                <h3>Outlet C</h3>
                <p>Outlet C memberikan pengalaman laundry yang menyenangkan dengan harga terjangkau.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="outlet-box">
                <h3>Outlet A</h3>
                <p>Outlet A adalah tempat terbaik untuk mendapatkan pelayanan laundry dengan kualitas terbaik.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="outlet-box">
                <h3>Outlet B</h3>
                <p>Outlet B menawarkan layanan laundry cepat dan efisien untuk kebutuhan Anda sehari-hari.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="outlet-box">
                <h3>Outlet C</h3>
                <p>Outlet C memberikan pengalaman laundry yang menyenangkan dengan harga terjangkau.</p>
            </div>
        </div>
    </div>
</div>
<div id="transaction" class="container">
    <h2>Proses Transaksi</h2>
    <div class="search-container">
        <input type="text" placeholder="Masukkan Kode Invoice" name="search">
        <button type="submit"><i class="fa fa-search"></i> Cari</button>
    </div>
</div>
<footer class=" text-white">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <p>Hak Cipta &copy; 2024 LaundryUK. Dibuat oleh ManikCodes.</p>
            </div>
        </div>
    </div>
</footer>
<!-- Bootstrap JS and Font Awesome JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
