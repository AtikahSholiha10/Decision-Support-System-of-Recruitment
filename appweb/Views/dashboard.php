<?php

    $hal        = "Dashboard";
    $link       = "dashboard";

?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3><?= $hal ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url ?>/dashboard"><i class="fas fa-tachometer-alt"></i> <?= $hal ?></a></li>
                </ol>
            </nav>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <?php if (($_SESSION['_status_identitas__']==="Kosong") OR ($_SESSION['_status_dokumen__']==="Kosong")): ?>
                    <div class="alert alert-danger" role="alert">
                        <h3 class="alert-heading fw-bolder">DATA ANDA BELUM LENGKAP!</h3>
                        <p class="mb-0">Mohon lengkapi data anda terlebih dahulu agar bisa melamar pekerjaan disini!</p>
                        <hr class="my-2" />
                        <ul class="list-unstyled">
                            <?php if ($_SESSION['_status_identitas__']==="Ada"): ?>
                                <li class="text-success"><i class="fas fa-check-circle"></i> Anda sudah melengkapi <a href="<?= $base_url ?>/profil/identitas" class="link-success fw-bolder">Data Identitas</a></li>
                            <?php else: ?>
                                <li><i class="fas fa-times-circle"></i> Anda belum melengkapi <a href="<?= $base_url ?>/profil/identitas" class="link-danger fw-bolder">Data Identitas</a></li>
                            <?php endif ?>

                            <?php if ($_SESSION['_status_dokumen__']==="Ada"): ?>
                                <li class="text-success"><i class="fas fa-check-circle"></i> Anda sudah melengkapi <a href="<?= $base_url ?>/profil/dokumen" class="link-success fw-bolder">Data Dokumen</a></li>
                            <?php else: ?>
                                <li><i class="fas fa-times-circle"></i> Anda belum melengkapi <a href="<?= $base_url ?>/profil/dokumen" class="link-danger fw-bolder">Data Dokumen</a></li>
                            <?php endif ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success" role="alert">
                        <h3 class="alert-heading fw-bolder"><i class="fas fa-check-circle"></i> DATA ANDA SUDAH LENGKAP!</h3>
                        <p class="mb-0">Yuk lihat daftar <a href="<?= $base_url ?>/penerimaan" title="Lowongan" class="link-success text-underline-none"><i class="fas fa-file-signature"></i> lowongan</a> pekerjaan!</p>
                    </div>
                <?php endif ?>
            </div><!-- end col-->
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>