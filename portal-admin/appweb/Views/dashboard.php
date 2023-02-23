<?php

    $hal        = "Dashboard";
    $database1  = "lowongan";
    $database2  = "pelamar";
    $database3  = "data_user";
    $link       = "dashboard";

    try {
        $stmt1   = $pdo->prepare("
            SELECT id_lowongan
            FROM $database1
        ");
        $stmt2   = $pdo->prepare("
            SELECT id_pelamar
            FROM $database2
        ");
        $stmt3   = $pdo->prepare("
            SELECT id_data_user
            FROM $database3
        ");

        $stmt1->execute();
        $stmt2->execute();
        $stmt3->execute();
        $rows1  = $stmt1->rowCount();
        $rows2  = $stmt2->rowCount();
        $rows3  = $stmt3->rowCount();
    } catch (Exception $e) {
        var_dump($e);
    }

?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3><?= $hal ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> <?= $hal ?></a></li>
                </ol>
            </nav>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card bg-success">
                    <div class="card-body">
                        <h4 class="header-title text-light mt-0 mb-3">Penerimaan</h4>

                        <div class="widget-box-2">
                            <div class="widget-detail-2 text-end">
                                <h1 class="fw-normal text-light mb-1"><i class="fas fa-file-signature"></i> <?= $rows1 ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-md-4">
                <div class="card bg-success">
                    <div class="card-body">
                        <h4 class="header-title text-light mt-0 mb-3">Pelamar</h4>

                        <div class="widget-box-2">
                            <div class="widget-detail-2 text-end">
                                <h1 class="fw-normal text-light mb-1"><i class="fas fa-user-tie"></i> <?= $rows2 ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-md-4">
                <div class="card bg-success">
                    <div class="card-body">
                        <h4 class="header-title text-light mt-0 mb-3">User</h4>

                        <div class="widget-box-2">
                            <div class="widget-detail-2 text-end">
                                <h1 class="fw-normal text-light mb-1"><i class="fas fa-users"></i> <?= $rows3 ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>