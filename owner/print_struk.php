<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Laundry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 200px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        .logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo img {
            max-width: 80px;
        }
        .info {
            margin-bottom: 10px;
        }
        .info p {
            margin: 5px 0;
        }
        .details {
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        .details p {
            margin: 5px 0;
        }
        .btn-print {
            display: block;
            width: 100%;
            padding: 8px 0;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container" id="printableArea">
        <div class="logo">
            <img src="logo_laundry.png" alt="Logo Laundry">
        </div>
        <div class="info">
            <p>Tanggal: 2024-02-09</p>
            <p>Nama Pelanggan: John Doe</p>
            <p>Nomor Invoice: 123456</p>
        </div>
        <div class="details">
            <p>Detail Pembayaran:</p>
            <p>1. Cuci Baju - Rp 10.000</p>
            <p>2. Setrika Baju - Rp 5.000</p>
            <p>Total: Rp 15.000</p>
            <p>Metode Pembayaran: Tunai</p>
            <p>Terima kasih telah menggunakan layanan kami.</p>
        </div>
        <button class="btn-print" onclick="printReceipt()">Cetak Struk</button>
    </div>

    <script>
        function printReceipt() {
            var printContents = document.getElementById("printableArea").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>
