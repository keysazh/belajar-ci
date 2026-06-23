<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="<?= base_url('/') ?>">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="<?= base_url('keranjang') ?>">
                <i class="bi bi-cart-check"></i>
                <span>Keranjang</span>
            </a>
        </li><li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'profil') ? "" : "collapsed" ?>" href="<?= base_url('profil') ?>">
                <i class="bi bi-person"></i>
                <span>Profil Pengguna</span>
            </a>
        </li><?php if (session()->get('role') == 'admin') : ?>
            <li class="nav-item">
                <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="<?= base_url('produk') ?>">
                    <i class="bi bi-receipt"></i>
                    <span>Produk</span>
                </a>
            </li><?php endif; ?>
            <li class="nav-item">
                <a class="nav-link <?php echo (uri_string() == 'history') ? "" : "collapsed" ?>" href="history">
                    <i class="bi bi-person"></i>
                    <span>History</span>
                </a>
            </li><!-- End History Nav -->

    </ul>

</aside>