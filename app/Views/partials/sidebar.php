<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="<?= base_url(); ?>" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <?php if (session()->get('role_id') == 1) : ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-television"></i>
                        <span class="nav-text">Master</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?= base_url(); ?>/master/produk">Produk</a></li>
                        <li><a href="<?= base_url(); ?>/master/kelolameja">Kelola Meja</a></li>
                        <li><a href="<?= base_url(); ?>/master/kategori">Kategori</a></li>

                    </ul>
                </li>
            <?php endif; ?>
            <?php if (session()->get('role_id') == 1 or session()->get('role_id') == 2) : ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-notepad"></i>
                        <span class="nav-text">Penjualan</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?= base_url(); ?>/penjualan/inputPenjualan">Input Penjualan</a></li>
                        <?php if (session()->get('role_id') == 1) : ?>
                            <li><a href="<?= base_url(); ?>/penjualan/dataPenjualan">Data Penjualan</a></li>
                        <?php endif; ?>
                        <li><a href="<?= base_url(); ?>/penjualan/transaksiPenjualan">Transaksi Penjualan</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (session()->get('role_id') == 1) : ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-users"></i>
                        <span class="nav-text">Users</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?= base_url(); ?>/users">Data User</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (session()->get('role_id') == 3 or session()->get('role_id') == 5) : ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-database"></i>
                        <span class="nav-text">Dapur</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?= base_url(); ?>/dapur">Kelola Pesanan</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-clipboard"></i>
                    <span class="nav-text">Transaksi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url(); ?>/transaksi">Status Pemesanan</a></li>
                </ul>
            </li>
            <?php if (session()->get('role_id') == 4) : ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-television"></i>
                        <span class="nav-text">Kasir</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?= base_url(); ?>/kasir/pembayaran">Pembayaran</a></li>
                    </ul>
                </li>
            <?php endif; ?>

        </ul>

        <br>
        <br>

        <div class="copyright">
            <p><strong>RestoServe - Mie Aceh TitiBobrok</strong> <br>© <?= date('Y'); ?> All Rights Reserved</p>
            <p>Made with <i class="fa fa-heart"></i> by AqilMustaqim</p>
        </div>
    </div>
</div>