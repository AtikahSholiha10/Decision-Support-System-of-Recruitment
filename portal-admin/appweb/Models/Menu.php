<div class="left-side-menu" style="background-color: #10c469 !important;">
    <div class="h-100" data-simplebar>
        <!-- User box -->
        <div class="user-box text-center">
            <img src="<?= $url_images ?>/avatar/<?= $_SESSION['_avatar__'] ?>" alt="<?= $_SESSION['_nama__'] ?>" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
            <div class="dropdown">
                <a href="<?= $base_url_admin ?>/#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"  aria-expanded="false"><?= $_SESSION['_nama__'] ?></a>
            </div>

            <ul class="list-inline border-bottom pb-3">
                <li class="list-inline-item">
                    <a href="<?= $base_url_admin ?>/keluar-admin">
                        <i class="mdi mdi-power fw-bolder text-danger"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!--- Sidemenu -->
        <?php
            switch ($_SESSION['_level__']) {
                case 'Administrator':
        ?>

        <div id="sidebar-menu">
            <ul id="side-menu">
                <li>
                    <a href="<?= $base_url_admin ?>/dashboard" class="<?php if($_GET['module']=='dashboard'){ echo 'text-light'; } ?>">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title bg-body text-success">MENU UTAMA</li>
                <li>
                    <a href="<?= $base_url_admin ?>/pelamar" class="<?php if($_GET['module']=='pelamar'){ echo 'text-light'; } ?>">
                        <i class="fas fa-user-edit"></i>
                        <span> Data Penilaian </span>
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url_admin ?>/penerimaan" class="<?php if($_GET['module']=='penerimaan'){ echo 'text-light'; } ?>">
                        <i class="fas fa-file-signature"></i>
                        <span> Data Penerimaan </span>
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url_admin ?>/user" class="<?php if($_GET['module']=='user'){ echo 'text-light'; } ?>">
                        <i class="fas fa-users"></i>
                        <span> Data Pelamar </span>
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url_admin ?>/perhitungan" class="<?php if($_GET['module']=='perhitungan'){ echo 'text-light'; } ?>">
                        <i class="fas fa-pencil-ruler"></i>
                        <span> Perhitungan </span>
                    </a>
                </li>

                <li class="menu-title bg-body text-success">FITUR WEBSITE</li>
                <li>
                    <a href="<?= $base_url_admin ?>/pengaturan" class="<?php if($_GET['module']=='pengaturan'){ echo 'text-light'; } ?>">
                        <i class="mdi mdi-cogs"></i>
                        <span> Pengaturan Website </span>
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url_admin ?>/pegawai" class="<?php if($_GET['module']=='pegawai'){ echo 'text-light'; } ?>">
                        <i class="mdi mdi-card-account-details-star"></i>
                        <span> Data Pegawai </span>
                    </a>
                </li>
            </ul>
        </div>

        <?php
                    break;
                case 'Penilai':
        ?>
        
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li>
                    <a href="<?= $base_url_admin ?>/dashboard" class="<?php if($_GET['module']=='dashboard'){ echo 'text-light'; } ?>">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title bg-body text-success">MENU UTAMA</li>
                <li>
                    <a href="<?= $base_url_admin ?>/pelamar" class="<?php if($_GET['module']=='pelamar'){ echo 'text-light'; } ?>">
                        <i class="fas fa-user-tie"></i>
                        <span> Data Pelamar </span>
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url_admin ?>/perhitungan" class="<?php if($_GET['module']=='perhitungan'){ echo 'text-light'; } ?>">
                        <i class="fas fa-pencil-ruler"></i>
                        <span> Perhitungan </span>
                    </a>
                </li>
            </ul>
        </div>

        <?php
                    break;
            }
        ?>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>