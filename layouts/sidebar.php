<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?>>
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                </li>
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <li class="list-divider"></li>
                    <li class="submenu">
                        <a href="#"><i class="fas fa-suitcase"></i><span>Master Data</span><span class="menu-arrow"></span></a>
                        <ul class="submenu_class" style="display: none;">
                            <li ><a href="outlet.php" <?php if (basename($_SERVER['PHP_SELF']) == 'outlet.php') echo 'class="active"'; ?>>Data Outlet</a></li>
                            <li><a href="paket.php"  <?php if (basename($_SERVER['PHP_SELF']) == 'paket.php') echo 'class="active"'; ?>>Data Paket</a></li>
                            <li ><a href="user.php" <?php if (basename($_SERVER['PHP_SELF']) == 'user.php') echo 'class="active"'; ?>>Data Pengguna</a></li>
                        </ul>
                    </li>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'pelanggan.php') echo 'class="active"'; ?>>
                        <a href="pelanggan.php"><i class="fas fa-user"></i><span>Registrasi Pelanggan</span></a>
                    </li>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'transaksi.php') echo 'class="active"'; ?>>
                        <a href="transaksi.php"><i class="fas fa-book"></i><span>Entri Transaksi</span></a>
                    </li>
                <?php } elseif ($_SESSION['role'] == 'kasir') { ?>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'pelanggan.php') echo 'class="active"'; ?>>
                        <a href="pelanggan.php"><i class="fas fa-user"></i><span>Registrasi Pelanggan</span></a>
                    </li>
                    <li <?php if (basename($_SERVER['PHP_SELF']) == 'transaksi.php') echo 'class="active"'; ?>>
                        <a href="transaksi.php"><i class="fas fa-book"></i><span>Entri Transaksi</span></a>
                    </li>
                <?php } ?>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'laporan.php') echo 'class="active"'; ?>>
                    <a href="laporan.php"><i class="fe fe-table"></i><span>Laporan</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
