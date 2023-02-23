<?php

    switch ($_GET['act']) {
        case "list":
            $hal        = "Data Penerimaan";
            $database   = "lowongan";
            $link       = "penerimaan";
            $Active     = "Active";
            $Delete     = "Hapus";
            
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3 class="text-success"><?= $hal ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $hal ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
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
                    <div class="card">
                        <div class="card-body pb-0">
                            <table id="datatable" class="table table-bordered table-striped dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th style="max-width: 5%;">No.</th>
                                        <th style="max-width: 40%;">Nama Sekolah</th>
                                        <th style="max-width: 40%;">Jabatan</th>
                                        <th style="max-width: 15%;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $no = 1;
                                        try {
                                            $stmt   = $pdo->prepare("
                                                SELECT *
                                                FROM $database
                                                WHERE status = ?
                                                ORDER BY id_$database DESC
                                            ");

                                            $stmt->bindValue(1, $Active);
                                            $stmt->execute();
                                            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><span><?= $result['nama_sekolah'] ?></span></td>
                                        <td><span class="text-success fw-bolder"><?= $result['jabatan'] ?></span></td>
                                        <td class="text-center">
                                            <a role="button" onclick="confirmLamar('<?= $result['id_lowongan']; ?>')" class="btn btn-success"><i class="fas fa-file-signature"></i> Lamar</a>
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        } catch (Exception $e) {
                                            var_dump($e);
                                            exit();
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-->
                <?php endif ?>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
        break;   
    }
?>