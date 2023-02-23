<div class="left-side-menu" style="background-color: #10c469 !important;">
    <div class="h-100" data-simplebar>
        <!-- User box -->
        <div class="user-box text-center" style="background-color: #10c469 !important;">
            <img src="<?= $base_url ?>/assets/files/images/avatar/<?= $_SESSION['_foto3x4__'] ?>" alt="<?= $_SESSION['_nama_lgkp__'] ?>" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                <div class="dropdown">
                    <a href="<?= $base_url ?>/#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"  aria-expanded="false"><?= $_SESSION['_nama_lgkp__'] ?></a>
                </div>

            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="<?= $base_url ?>/profil/identitas" class="text-muted left-user-info">
                        <i class="mdi mdi-cog"></i>
                    </a>
                </li>

                <li class="list-inline-item">
                    <a href="<?= $base_url ?>/keluar">
                        <i class="mdi mdi-power"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li>
                    <a href="<?= $base_url ?>/dashboard" class="<?php if($_GET['module']=='dashboard'){ echo 'text-light'; } ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title bg-body text-success">MENU UTAMA</li>
                <li>
                    <a href="<?= $base_url ?>/profil/identitas" class="<?php if($_GET['module']=='profil'){ echo 'text-light'; } ?>">
                        <i class="fas fa-user-circle"></i>
                        <span> Profil </span>
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url ?>/penerimaan" class="<?php if($_GET['module']=='penerimaan'){ echo 'text-light'; } ?>">
                        <i class="fas fa-file-signature"></i>
                        <span> Penerimaan </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>