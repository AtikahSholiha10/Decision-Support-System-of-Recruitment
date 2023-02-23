<?php

    switch ($_GET['act']) {
        case "list":
            $hal        = "Data Pelamar";
            $database   = "data_user";
            $database2  = "identitas_user";
            $link       = "user";
            $Active     = "Active";
            
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
                <div class="card">
                    <div class="card-header">
                        <form action="<?= $base_url_admin ?>/ExportUser" method="POST" class="text-center">
                            <button type="submit" name="_submit_" class="btn btn-lg btn-success"><i class="fas fa-file-excel"></i> Export Data</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-striped dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th style="max-width: 15%;">No. Pendaftaran</th>
                                    <th style="max-width: 30%;">Nama Lengkap</th>
                                    <th style="max-width: 20%;">No. HP</th>
                                    <th style="max-width: 25%;">Email</th>
                                    <th style="max-width: 10%;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    try {
                                        $stmt   = $pdo->prepare("
                                            SELECT $database.id_data_user, nama_lgkp, email, no_hp, slug
                                            FROM $database2
                                            INNER JOIN $database
                                            ON $database2.id_$database = $database.id_$database
                                            ORDER BY id_$database2 DESC
                                        ");

                                        $stmt->execute();
                                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $result['id_data_user'] ?></td>
                                    <td><span class="text-success fw-bolder"><?= $result['nama_lgkp'] ?></span></td>
                                    <td><span><?= $result['no_hp'] ?></span></td>
                                    <td><span><?= $result['email'] ?></span></td>
                                    <td class="text-center">
                                        <a href="<?= $base_url_admin ?>/user/identitas/<?= $result['slug'] ?>" title="Detail User" class="btn btn-sm btn-success">Detail <i class="fas fa-external-link-alt"></i></a>
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
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
            break;
        case "identitas":
            $hal        = "Data Pelamar";
            $database   = "data_user";
            $database2  = "identitas_user";
            $database3  = "dokumen_user";
            $link       = "user";
            $Active     = "Active";

            try {
                $stmt   = $pdo->prepare("
                    SELECT id_data_user, slug
                    FROM $database
                    WHERE slug = ? ");

                $stmt->bindValue(1, $_GET['slug']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    try {
                        $stmt2   = $pdo->prepare("
                            SELECT *
                            FROM $database2
                            WHERE id_data_user = ? ");

                        $stmt2->bindValue(1, $result['id_data_user']);
                        $stmt2->execute();
                        $rows2   = $stmt2->rowCount();

                        if ($rows2>0) {
                            try {
                                $stmt3   = $pdo->prepare("
                                    SELECT *
                                    FROM $database3
                                    WHERE id_data_user = ? ");

                                $stmt3->bindValue(1, $result['id_data_user']);
                                $stmt3->execute();
                                $rows3   = $stmt3->rowCount();

                                if ($rows3>0) {
                                    $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    $result3    = $stmt3->fetch(PDO::FETCH_ASSOC);
                                }else{
                                    echo "<script>window.location.href = '$base_url/dashboard';</script>";
                                    die();
                                    exit();
                                }
                            } catch (Exception $e) {
                                var_dump($e);
                                exit();
                            }
                        }else{
                            echo "<script>window.location.href = '$base_url/dashboard';</script>";
                            die();
                            exit();
                        }
                    } catch (Exception $e) {
                        var_dump($e);
                        exit();
                    }
                }else{
                    echo "<script>window.location.href = '$base_url/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
                exit();
            }
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3><?= $result2['nama_lgkp'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/user"><?= $hal ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $result2['nama_lgkp'] ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav flex-column nav-pills nav-pills-tab shadow-lg p-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <div class="d-flex justify-content-center">
                                        <img src="<?= $url_images ?>/avatar/<?= $result3['foto3x4'] ?>" class="rounded-circle avatar-xl img-thumbnail" alt="Avatar <?= $result2['nama_lgkp'] ?>">
                                    </div>
                                    <div class="d-flex justify-content-center my-2">
                                        <h5 class="text-success"><strong>No. Pendaftaran:</strong> <?= $result2['id_data_user'] ?></h5>
                                    </div>
                                    <a class="nav-link active show mb-1" href="<?= $base_url_admin ?>/<?= $link ?>/identitas/<?= $result['slug'] ?>">
                                        <i class="fas fa-user-circle"></i> Identitas
                                    </a>
                                    <a class="nav-link mb-1" href="<?= $base_url_admin ?>/<?= $link ?>/dokumen/<?= $result['slug'] ?>">
                                        <i class="fas fa-file-alt"></i> Dokumen
                                    </a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-9">
                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="row py-0">
                                            <div class="col-md-6 mb-2">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="nik" name="in_nik" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['nik'] ?>" readonly>
                                                    <label for="nik">NIK</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="nama_lgkp" name="in_nama_lgkp" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['nama_lgkp'] ?>" readonly>
                                                    <label for="nama_lgkp">Nama Lengkap</label>
                                                </div>
                                            </div>

                                            <div class="col-12 mb-2">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="in_alamat_lgkp" placeholder="Deskripsikan tentang diri anda..." style="min-height: 100px;" readonly><?= $result2['alamat_lgkp'] ?></textarea>
                                                    <label for="alamat_lgkp">Alamat Lengkap</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="tmpt_lhr" name="in_tmpt_lhr" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['tmpt_lhr'] ?>" readonly>
                                                    <label for="tmpt_lhr">Tempat Lahir</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="tgl_lhr" name="in_tgl_lhr" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['tgl_lhr'] ?>" readonly>
                                                    <label for="tgl_lhr">Tanggal Lahir</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control" id="email" name="in_email" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['email'] ?>" readonly>
                                                    <label for="email">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="form-floating">
                                                    <input type="tel" class="form-control" id="no_hp" name="in_no_hp" placeholder="Cth: 085701311015" pattern="^(0)8[1-9][0-9]{6,9}$" value="<?= $result2['no_hp'] ?>" readonly>
                                                    <label for="no_hp">Nomor HP <small>(Cth: 085701311015)</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-2">
                                                <div class="form-floating">
                                                    <select class="form-select" id="jk" name="in_jk" readonly>
                                                        <option value="Pria" <?php if ($result2['jk']==="Pria") { echo "selected"; } ?>>Pria</option>
                                                        <option value="Wanita" <?php if ($result2['jk']==="Wanita") { echo "selected"; } ?>>Wanita</option>
                                                    </select>
                                                    <label for="jk">Jenis Kelamin</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="form-floating">
                                                    <select class="form-select" id="stts_perkawinan" name="in_stts_perkawinan" readonly>
                                                        <option value="Menikah" <?php if ($result2['stts_perkawinan']==="Menikah") { echo "selected"; } ?>>Menikah</option>
                                                        <option value="Belum Menikah" <?php if ($result2['stts_perkawinan']==="Belum Menikah") { echo "selected"; } ?>>Belum Menikah</option>
                                                    </select>
                                                    <label for="stts_perkawinan">Status Perkawinan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="form-floating">
                                                    <select class="form-select" id="agama" name="in_agama" readonly>
                                                        <option value="Islam" <?php if ($result2['agama']==="Islam") { echo "selected"; } ?>>Islam</option>
                                                        <option value="Kristen" <?php if ($result2['agama']==="Kristen") { echo "selected"; } ?>>Kristen</option>
                                                        <option value="Katolik" <?php if ($result2['agama']==="Katolik") { echo "selected"; } ?>>Katolik</option>
                                                        <option value="Hindu" <?php if ($result2['agama']==="Hindu") { echo "selected"; } ?>>Hindu</option>
                                                        <option value="Buddha" <?php if ($result2['agama']==="Buddha") { echo "selected"; } ?>>Buddha</option>
                                                        <option value="Konghucu" <?php if ($result2['agama']==="Konghucu") { echo "selected"; } ?>>Konghucu</option>
                                                    </select>
                                                    <label for="agama">Agama</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-2">
                                                <div class="form-floating">
                                                    <select class="form-select" id="pend_trkhr" name="in_pend_trkhr" readonly>
                                                        <option value="SMA" <?php if ($result2['pend_trkhr']==="SMA") { echo "selected"; } ?>>SMA</option>
                                                        <option value="SMK" <?php if ($result2['pend_trkhr']==="SMK") { echo "selected"; } ?>>SMK</option>
                                                        <option value="D2" <?php if ($result2['pend_trkhr']==="D2") { echo "selected"; } ?>>D2</option>
                                                        <option value="D3" <?php if ($result2['pend_trkhr']==="D3") { echo "selected"; } ?>>D3</option>
                                                        <option value="D4" <?php if ($result2['pend_trkhr']==="D4") { echo "selected"; } ?>>D4</option>
                                                        <option value="S1" <?php if ($result2['pend_trkhr']==="S1") { echo "selected"; } ?>>S1</option>
                                                        <option value="S2" <?php if ($result2['pend_trkhr']==="S2") { echo "selected"; } ?>>S2</option>
                                                    </select>
                                                    <label for="pend_trkhr">Pendidikan Terakhir</label>
                                                </div>
                                            </div>

                                            <div class="col-md-8 mb-2">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="jurusan" name="in_jurusan" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['jurusan'] ?>" readonly>
                                                    <label for="jurusan">Jurusan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
            break;
        case "dokumen":
            $hal        = "Data Pelamar";
            $database   = "data_user";
            $database2  = "identitas_user";
            $database3  = "dokumen_user";
            $link       = "user";
            $Active     = "Active";

            try {
                $stmt   = $pdo->prepare("
                    SELECT id_data_user, slug
                    FROM $database
                    WHERE slug = ? ");

                $stmt->bindValue(1, $_GET['slug']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    try {
                        $stmt2   = $pdo->prepare("
                            SELECT *
                            FROM $database2
                            WHERE id_data_user = ? ");

                        $stmt2->bindValue(1, $result['id_data_user']);
                        $stmt2->execute();
                        $rows2   = $stmt2->rowCount();

                        if ($rows2>0) {
                            try {
                                $stmt3   = $pdo->prepare("
                                    SELECT *
                                    FROM $database3
                                    WHERE id_data_user = ? ");

                                $stmt3->bindValue(1, $result['id_data_user']);
                                $stmt3->execute();
                                $rows3   = $stmt3->rowCount();

                                if ($rows3>0) {
                                    $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    $result3    = $stmt3->fetch(PDO::FETCH_ASSOC);
                                }else{
                                    echo "<script>window.location.href = '$base_url/dashboard';</script>";
                                    die();
                                    exit();
                                }
                            } catch (Exception $e) {
                                var_dump($e);
                                exit();
                            }
                        }else{
                            echo "<script>window.location.href = '$base_url/dashboard';</script>";
                            die();
                            exit();
                        }
                    } catch (Exception $e) {
                        var_dump($e);
                        exit();
                    }
                }else{
                    echo "<script>window.location.href = '$base_url/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
                exit();
            }
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3><?= $result2['nama_lgkp'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/user"><?= $hal ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $result2['nama_lgkp'] ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav flex-column nav-pills nav-pills-tab shadow-lg p-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <div class="d-flex justify-content-center">
                                        <img src="<?= $url_images ?>/avatar/<?= $result3['foto3x4'] ?>" class="rounded-circle avatar-xl img-thumbnail" alt="Avatar <?= $result2['nama_lgkp'] ?>">
                                    </div>
                                    <div class="d-flex justify-content-center my-2">
                                        <h5 class="text-success"><strong>No. Pendaftaran:</strong> <?= $result2['id_data_user'] ?></h5>
                                    </div>
                                    <a class="nav-link mb-1" href="<?= $base_url_admin ?>/<?= $link ?>/identitas/<?= $result['slug'] ?>">
                                        <i class="fas fa-user-circle"></i> Identitas
                                    </a>
                                    <a class="nav-link active show mb-1" href="<?= $base_url_admin ?>/<?= $link ?>/dokumen/<?= $result['slug'] ?>">
                                        <i class="fas fa-file-alt"></i> Dokumen
                                    </a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-9">
                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="row py-0 px-3">
                                            <ul class="lh-lg list-unstyled">
                                                <li><i class="fas fa-arrow-right"></i> Surat Lamaran: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['surat_lamaran'] ?>" title="Surat Lamaran" class="link-success">Lihat Surat Lamaran <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> CV: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['cv'] ?>" title="CV" class="link-success">Lihat CV <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> Foto 3x4: <a target="_blank" href="<?= $url_images ?>/avatar/<?= $result3['foto3x4'] ?>" title="Foto 3x4" class="link-success">Lihat Foto 3x4 <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> KTAM: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['ktam'] ?>" title="KTAM" class="link-success">Lihat KTAM <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> KTP: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['ktp'] ?>" title="KTP" class="link-success">Lihat KTP <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> Surat Keterangan Sehat: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['sks'] ?>" title="Surat Keterangan Sehat" class="link-success">Lihat Surat Keterangan Sehat <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> SKCK: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['skck'] ?>" title="SKCK" class="link-success">Lihat SKCK <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> Ijazah Terakhir: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['ijazah'] ?>" title="Ijazah Terakhir" class="link-success">Lihat Ijazah Terakhir <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> Transkrip Nilai: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['transkrip_nilai'] ?>" title="Transkrip Nilai" class="link-success">Lihat Transkrip Nilai <i class="fas fa-external-link-alt"></i></a></li>
                                                <li><i class="fas fa-arrow-right"></i> Sertifikat Pendukung: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['sertifikat_pendukung'] ?>" title="Sertifikat Pendukung" class="link-success">Lihat Sertifikat Pendukung <i class="fas fa-external-link-alt"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
        break;   
    }
?>