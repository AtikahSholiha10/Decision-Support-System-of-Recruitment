<?php

    switch ($_GET['act']) {
        case "list":
            $hal        = "Data Penilaian";
            $database   = "lowongan";
            $database2  = "pelamar";
            $database3  = "identitas_user";
            $link       = "pelamar";
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
                <div class="card">
                    <div class="card-header">
                        <form action="<?= $base_url_admin ?>/pelamar" method="POST" data-parsley-validate="" class="row justify-content-center">
                            <div class="col-auto">
                                <?php if (isset($_POST['_submit_'])): ?>
                                    <div class="form-floating">
                                        <select class="form-select" id="query" name="in_query" required="">
                                            <?php
                                                try {
                                                    $stmt1   = $pdo->prepare("
                                                        SELECT *
                                                        FROM $database
                                                        WHERE status = ?
                                                        ORDER BY id_$database DESC
                                                    ");

                                                    $stmt1->bindValue(1, $Active);
                                                    $stmt1->execute();
                                                    $rowCount   = $stmt1->rowCount();
                                                    if ($rowCount>0) {
                                                        $availableData = "";
                                                        while ($result1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <option value="<?= $result1['id_lowongan'] ?>" <?php if ($_POST['in_query']==$result1['id_lowongan']) { echo 'selected'; } ?>><?= $result1['jabatan'] ?> - <?= $result1['nama_sekolah'] ?></option>
                                            <?php
                                                        }
                                                    }else{
                                                        $availableData = "disabled";
                                            ?>
                                                <option value="">- Tidak ada data yang ditampilkan -</option>
                                            <?php
                                                    }
                                                } catch (Exception $e) {
                                                    var_dump($e);
                                                    exit();
                                                }
                                            ?>
                                        </select>
                                        <label for="query">- Pilih salah satu data -</label>
                                    </div>
                                <?php else: ?>
                                    <div class="form-floating">
                                        <select class="form-select" id="query" name="in_query" required="">
                                            <?php
                                                try {
                                                    $stmt1   = $pdo->prepare("
                                                        SELECT *
                                                        FROM $database
                                                        WHERE status = ?
                                                        ORDER BY id_$database DESC
                                                    ");

                                                    $stmt1->bindValue(1, $Active);
                                                    $stmt1->execute();
                                                    $rowCount   = $stmt1->rowCount();
                                                    if ($rowCount>0) {
                                                        $availableData = "";
                                                        while ($result1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <option value="<?= $result1['id_lowongan'] ?>"><?= $result1['jabatan'] ?> - <?= $result1['nama_sekolah'] ?></option>
                                            <?php
                                                        }
                                                    }else{
                                                        $availableData = "disabled";
                                            ?>
                                                <option value="">- Tidak ada data yang ditampilkan -</option>
                                            <?php
                                                    }
                                                } catch (Exception $e) {
                                                    var_dump($e);
                                                    exit();
                                                }
                                            ?>
                                        </select>
                                        <label for="query">- Pilih salah satu data -</label>
                                    </div>
                                <?php endif ?>
                            </div>
                            <div class="col-auto my-auto">
                                <button type="submit" name="_submit_" class="btn btn-success <?= $availableData ?>"><i class="fas fa-search"></i> CARI</button>
                            </div>
                        </form>
                    </div>
                    <?php if (isset($_POST['_submit_'])): ?>
                        <form action="<?= $base_url_admin ?>/ExportPelamar" method="POST" class="card-body text-center">
                            <input type="hidden" name="in_id_lowongan" value="<?= $_POST['in_query'] ?>">
                            <button type="submit" name="_submit_" class="btn btn-lg btn-success"><i class="fas fa-file-excel"></i> Export Data</button>
                        </form>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th style="max-width: 5%;">No.</th>
                                        <th style="max-width: 30%;">Nama Lengkap</th>
                                        <th style="max-width: 50%;">Nama Sekolah</th>
                                        <th style="max-width: 15%;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $no = 1;
                                        try {
                                            $stmt   = $pdo->prepare("
                                                SELECT nama_sekolah, id_pelamar, nama_lgkp
                                                FROM $database2
                                                INNER JOIN $database
                                                ON $database2.id_$database = $database.id_$database
                                                INNER JOIN $database3
                                                ON $database2.id_data_user = $database3.id_data_user
                                                WHERE $database.id_lowongan = ?
                                                ORDER BY id_$database2 DESC
                                            ");

                                            $stmt->bindValue(1, $_POST['in_query']);
                                            $stmt->execute();
                                            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><span class="text-success fw-bolder"><?= $result['nama_lgkp'] ?></span></td>
                                        <td><span><?= $result['nama_sekolah'] ?></span></td>
                                        <td>
                                            <a href="<?= $base_url_admin ?>/pelamar/nilai/<?= $result['id_pelamar'] ?>/wawancara-loyalitas-dan-kemuhammadiyahan" title="Rincian Nilai (Wawancara) Loyalitas dan Kemuhammadiyahan" class="btn btn-sm btn-success"><i class="fas fa-pencil-alt"></i> Rincian Nilai</a>
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
                    <?php endif ?>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
            break;
        case "nilai-wawancara-loyalitas-dan-kemuhammadiyahan":
            $hal        = "Data Penilaian";
            $hal2       = "(Wawancara) Loyalitas dan Kemuhammadiyahan";
            $database   = "lowongan";
            $database2  = "pelamar";
            $database3  = "identitas_user";
            $database4  = "data_user";
            $link       = "pelamar";
            $Active     = "Active";
            $Delete     = "Hapus";

            try {
                $stmt   = $pdo->prepare("
                    SELECT *, $database2.id_data_user
                    FROM $database2
                    INNER JOIN $database
                    ON $database2.id_$database = $database.id_$database
                    INNER JOIN $database3
                    ON $database2.id_data_user = $database3.id_data_user
                    WHERE id_$database2 = ?
                ");

                $stmt->bindValue(1, $_GET['slug']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    try {
                        $stmt2   = $pdo->prepare("
                            SELECT slug
                            FROM $database4
                            WHERE id_$database4 = ?
                        ");

                        $stmt2->bindValue(1, $result['id_data_user']);
                        $stmt2->execute();
                        $rows2  = $stmt2->rowCount();

                        if ($rows2>0) {
                            $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                        }else{
                            echo "<script>window.location.href = '$base_url_admin/dashboard';</script>";
                            die();
                            exit();
                        }
                    } catch (Exception $e) {
                        var_dump($e);
                    }
                }else{
                    echo "<script>window.location.href = '$base_url_admin/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
            }
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3 class="text-success"><?= $result['nama_lgkp'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/pelamar"><?= $hal ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rincian Nilai <?= $result['nama_lgkp'] ?> - <?= $result['jabatan'] ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1 class="text-success mb-0">Rincian Nilai</h1>
                        <h2 class="text-success"><?= $hal2 ?></h2>
                        <h3 class="text-success"><?= $result['nama_lgkp'] ?> - <?= $result['jabatan'] ?></h3>
                        <a target="_blank" href="<?= $base_url_admin ?>/user/identitas/<?= $result2['slug'] ?>" title="Detail Identitas & Berkas" class="btn btn-xs btn-outline-success">Detail Identitas & Berkas <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="card-header border-bottom border-top text-center">
                        <h3 class="text-success">Menu Nilai</h3>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/wawancara-loyalitas-dan-kemuhammadiyahan" title="(Wawancara) Loyalitas dan Kemuhammadiyahan" class="btn btn-sm btn-outline-success disabled">(Wawancara) Loyalitas dan Kemuhammadiyahan</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-sholat" title="(Praktek) Sholat" class="btn btn-sm btn-success">(Praktek) Sholat</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-wudhu-dan-tayamum" title="(Praktek) Wudhu dan Tayamum" class="btn btn-sm btn-success">(Praktek) Wudhu dan Tayamum</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-membaca-al-quran" title="(Praktek) Membaca Al-Quran" class="btn btn-sm btn-success">(Praktek) Membaca Al-Quran</a>
                    </div>
                    <form action="<?= $base_url_admin ?>/rincianNilaiWawancaraLoyalitasDanKemuhammadiyahan" method="POST" data-parsley-validate="" class="card-body">
                        <table class="table table-bordered table-striped table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th style="max-width: 25%;">Kriteria</th>
                                    <th style="max-width: 40%;">Sub Kriteria</th>
                                    <th style="max-width: 10%;">Kode</th>
                                    <th style="max-width: 10%;">Bobot</th>
                                    <th style="max-width: 15%;">Skala Nilai</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td rowspan="4">
                                        <span class="text-success fw-bolder my-auto">(Wawancara) Loyalitas dan Kemuhammadiyahan</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ideologi</td>
                                    <td>C1</td>
                                    <td rowspan="3">
                                        <span class="text-success fw-bolder my-auto">30%</span>
                                    </td>
                                    <td><input type="number" name="in_c1" class="form-control" min="10" max="100" value="<?= $result['c1'] ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Pemahaman Muhammadiyah</td>
                                    <td>C2</td>
                                    <td><input type="number" name="in_c2" class="form-control" min="10" max="100" value="<?= $result['c2'] ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Amaliyah</td>
                                    <td>C3</td>
                                    <td><input type="number" name="in_c3" class="form-control" min="10" max="100" value="<?= $result['c3'] ?>" required></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="text-end py-3">
                                    <input type="hidden" name="in_id_pelamar" class="form-control" value="<?= $result['id_pelamar'] ?>" required>
                                    <td colspan="5"><button type="submit" name="_submit_" class="btn btn-lg btn-success"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
            break;
        case "nilai-praktek-sholat":
            $hal        = "Data Penilaian";
            $hal2       = "(Praktek) Sholat";
            $database   = "lowongan";
            $database2  = "pelamar";
            $database3  = "identitas_user";
            $database4  = "data_user";
            $link       = "pelamar";
            $Active     = "Active";
            $Delete     = "Hapus";

            try {
                $stmt   = $pdo->prepare("
                    SELECT *, $database2.id_data_user
                    FROM $database2
                    INNER JOIN $database
                    ON $database2.id_$database = $database.id_$database
                    INNER JOIN $database3
                    ON $database2.id_data_user = $database3.id_data_user
                    WHERE id_$database2 = ?
                ");

                $stmt->bindValue(1, $_GET['slug']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    try {
                        $stmt2   = $pdo->prepare("
                            SELECT slug
                            FROM $database4
                            WHERE id_$database4 = ?
                        ");

                        $stmt2->bindValue(1, $result['id_data_user']);
                        $stmt2->execute();
                        $rows2  = $stmt2->rowCount();

                        if ($rows2>0) {
                            $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                        }else{
                            echo "<script>window.location.href = '$base_url_admin/dashboard';</script>";
                            die();
                            exit();
                        }
                    } catch (Exception $e) {
                        var_dump($e);
                    }
                }else{
                    echo "<script>window.location.href = '$base_url_admin/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
            }
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3 class="text-success"><?= $result['nama_lgkp'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/pelamar"><?= $hal ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rincian Nilai <?= $result['nama_lgkp'] ?> - <?= $result['jabatan'] ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1 class="text-success mb-0">Rincian Nilai</h1>
                        <h2 class="text-success"><?= $hal2 ?></h2>
                        <h3 class="text-success"><?= $result['nama_lgkp'] ?> - <?= $result['jabatan'] ?></h3>
                        <a target="_blank" href="<?= $base_url_admin ?>/user/identitas/<?= $result2['slug'] ?>" title="Detail Identitas & Berkas" class="btn btn-xs btn-outline-success">Detail Identitas & Berkas <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="card-header border-bottom border-top text-center">
                        <h3 class="text-success">Menu Nilai</h3>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/wawancara-loyalitas-dan-kemuhammadiyahan" title="(Wawancara) Loyalitas dan Kemuhammadiyahan" class="btn btn-sm btn-success">(Wawancara) Loyalitas dan Kemuhammadiyahan</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-sholat" title="(Praktek) Sholat" class="btn btn-sm btn-outline-success disabled">(Praktek) Sholat</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-wudhu-dan-tayamum" title="(Praktek) Wudhu dan Tayamum" class="btn btn-sm btn-success">(Praktek) Wudhu dan Tayamum</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-membaca-al-quran" title="(Praktek) Membaca Al-Quran" class="btn btn-sm btn-success">(Praktek) Membaca Al-Quran</a>
                    </div>
                    <form action="<?= $base_url_admin ?>/rincianNilaiPraktekSholat" method="POST" data-parsley-validate="" class="card-body">
                        <table class="table table-bordered table-striped table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th style="max-width: 25%;">Kriteria</th>
                                    <th style="max-width: 40%;">Sub Kriteria</th>
                                    <th style="max-width: 10%;">Kode</th>
                                    <th style="max-width: 10%;">Bobot</th>
                                    <th style="max-width: 15%;">Skala Nilai</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td rowspan="3"><span class="text-success fw-bolder">(Praktek) Sholat</span></td>
                                </tr>
                                <tr>
                                    <td>Gerakan</td>
                                    <td>C4</td>
                                    <td rowspan="2">
                                        <span class="text-success fw-bolder my-auto">10%</span>
                                    </td>
                                    <td><input type="number" name="in_c4" class="form-control" min="10" max="100" value="<?= $result['c4'] ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Bacaan</td>
                                    <td>C5</td>
                                    <td><input type="number" name="in_c5" class="form-control" min="10" max="100" value="<?= $result['c5'] ?>" required></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="text-end py-3">
                                    <input type="hidden" name="in_id_pelamar" class="form-control" value="<?= $result['id_pelamar'] ?>" required>
                                    <td colspan="5"><button type="submit" name="_submit_" class="btn btn-lg btn-success"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
            break;
        case "nilai-praktek-wudhu-dan-tayamum":
            $hal        = "Data Penilaian";
            $hal2       = "(Praktek) Wudhu dan Tayamum";
            $database   = "lowongan";
            $database2  = "pelamar";
            $database3  = "identitas_user";
            $database4  = "data_user";
            $link       = "pelamar";
            $Active     = "Active";
            $Delete     = "Hapus";

            try {
                $stmt   = $pdo->prepare("
                    SELECT *, $database2.id_data_user
                    FROM $database2
                    INNER JOIN $database
                    ON $database2.id_$database = $database.id_$database
                    INNER JOIN $database3
                    ON $database2.id_data_user = $database3.id_data_user
                    WHERE id_$database2 = ?
                ");

                $stmt->bindValue(1, $_GET['slug']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    try {
                        $stmt2   = $pdo->prepare("
                            SELECT slug
                            FROM $database4
                            WHERE id_$database4 = ?
                        ");

                        $stmt2->bindValue(1, $result['id_data_user']);
                        $stmt2->execute();
                        $rows2  = $stmt2->rowCount();

                        if ($rows2>0) {
                            $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                        }else{
                            echo "<script>window.location.href = '$base_url_admin/dashboard';</script>";
                            die();
                            exit();
                        }
                    } catch (Exception $e) {
                        var_dump($e);
                    }
                }else{
                    echo "<script>window.location.href = '$base_url_admin/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
            }
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3 class="text-success"><?= $result['nama_lgkp'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/pelamar"><?= $hal ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rincian Nilai <?= $result['nama_lgkp'] ?> - <?= $result['jabatan'] ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1 class="text-success mb-0">Rincian Nilai</h1>
                        <h2 class="text-success"><?= $hal2 ?></h2>
                        <h3 class="text-success"><?= $result['nama_lgkp'] ?> - <?= $result['jabatan'] ?></h3>
                        <a target="_blank" href="<?= $base_url_admin ?>/user/identitas/<?= $result2['slug'] ?>" title="Detail Identitas & Berkas" class="btn btn-xs btn-outline-success">Detail Identitas & Berkas <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="card-header border-bottom border-top text-center">
                        <h3 class="text-success">Menu Nilai</h3>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/wawancara-loyalitas-dan-kemuhammadiyahan" title="(Wawancara) Loyalitas dan Kemuhammadiyahan" class="btn btn-sm btn-success">(Wawancara) Loyalitas dan Kemuhammadiyahan</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-sholat" title="(Praktek) Sholat" class="btn btn-sm btn-success">(Praktek) Sholat</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-wudhu-dan-tayamum" title="(Praktek) Wudhu dan Tayamum" class="btn btn-sm btn-outline-success disabled">(Praktek) Wudhu dan Tayamum</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-membaca-al-quran" title="(Praktek) Membaca Al-Quran" class="btn btn-sm btn-success">(Praktek) Membaca Al-Quran</a>
                    </div>
                    <form action="<?= $base_url_admin ?>/rincianNilaiPraktekWudhuDanTayamum" method="POST" data-parsley-validate="" class="card-body">
                        <table class="table table-bordered table-striped table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th style="max-width: 25%;">Kriteria</th>
                                    <th style="max-width: 40%;">Sub Kriteria</th>
                                    <th style="max-width: 10%;">Kode</th>
                                    <th style="max-width: 10%;">Bobot</th>
                                    <th style="max-width: 15%;">Skala Nilai</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td rowspan="4"><span class="text-success fw-bolder">(Praktek) Wudhu dan Tayamum</span></td>
                                </tr>
                                <tr>
                                    <td>Urutan</td>
                                    <td>C6</td>
                                    <td rowspan="3">
                                        <span class="text-success fw-bolder my-auto">30%</span>
                                    </td>
                                    <td><input type="number" name="in_c6" class="form-control" min="10" max="100" value="<?= $result['c6'] ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Cara</td>
                                    <td>C7</td>
                                    <td><input type="number" name="in_c7" class="form-control" min="10" max="100" value="<?= $result['c7'] ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Do’a</td>
                                    <td>C8</td>
                                    <td><input type="number" name="in_c8" class="form-control" min="10" max="100" value="<?= $result['c8'] ?>" required></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="text-end py-3">
                                    <input type="hidden" name="in_id_pelamar" class="form-control" value="<?= $result['id_pelamar'] ?>" required>
                                    <td colspan="5"><button type="submit" name="_submit_" class="btn btn-lg btn-success"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
            break;
        case "nilai-praktek-membaca-al-quran":
            $hal        = "Data Penilaian";
            $hal2       = "(Praktek) Membaca Al-Quran";
            $database   = "lowongan";
            $database2  = "pelamar";
            $database3  = "identitas_user";
            $database4  = "data_user";
            $link       = "pelamar";
            $Active     = "Active";
            $Delete     = "Hapus";

            try {
                $stmt   = $pdo->prepare("
                    SELECT *, $database2.id_data_user
                    FROM $database2
                    INNER JOIN $database
                    ON $database2.id_$database = $database.id_$database
                    INNER JOIN $database3
                    ON $database2.id_data_user = $database3.id_data_user
                    WHERE id_$database2 = ?
                ");

                $stmt->bindValue(1, $_GET['slug']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    try {
                        $stmt2   = $pdo->prepare("
                            SELECT slug
                            FROM $database4
                            WHERE id_$database4 = ?
                        ");

                        $stmt2->bindValue(1, $result['id_data_user']);
                        $stmt2->execute();
                        $rows2  = $stmt2->rowCount();

                        if ($rows2>0) {
                            $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                        }else{
                            echo "<script>window.location.href = '$base_url_admin/dashboard';</script>";
                            die();
                            exit();
                        }
                    } catch (Exception $e) {
                        var_dump($e);
                    }
                }else{
                    echo "<script>window.location.href = '$base_url_admin/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
            }
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3 class="text-success"><?= $result['nama_lgkp'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/pelamar"><?= $hal ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rincian Nilai <?= $result['nama_lgkp'] ?> - <?= $result['jabatan'] ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1 class="text-success mb-0">Rincian Nilai</h1>
                        <h2 class="text-success"><?= $hal2 ?></h2>
                        <h3 class="text-success"><?= $result['nama_lgkp'] ?> - <?= $result['jabatan'] ?></h3>
                        <a target="_blank" href="<?= $base_url_admin ?>/user/identitas/<?= $result2['slug'] ?>" title="Detail Identitas & Berkas" class="btn btn-xs btn-outline-success">Detail Identitas & Berkas <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="card-header border-bottom border-top text-center">
                        <h3 class="text-success">Menu Nilai</h3>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/wawancara-loyalitas-dan-kemuhammadiyahan" title="(Wawancara) Loyalitas dan Kemuhammadiyahan" class="btn btn-sm btn-success">(Wawancara) Loyalitas dan Kemuhammadiyahan</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-sholat" title="(Praktek) Sholat" class="btn btn-sm btn-success">(Praktek) Sholat</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-wudhu-dan-tayamum" title="(Praktek) Wudhu dan Tayamum" class="btn btn-sm btn-success">(Praktek) Wudhu dan Tayamum</a>
                        <a href="<?= $base_url_admin ?>/<?= $link ?>/nilai/<?= $result['id_data_user'] ?>/praktek-membaca-al-quran" title="(Praktek) Membaca Al-Quran" class="btn btn-sm btn-outline-success disabled">(Praktek) Membaca Al-Quran</a>
                    </div>
                    <form action="<?= $base_url_admin ?>/rincianNilaiPraktekMembacaAlQuran" method="POST" data-parsley-validate="" class="card-body">
                        <table class="table table-bordered table-striped table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th style="max-width: 25%;">Kriteria</th>
                                    <th style="max-width: 40%;">Sub Kriteria</th>
                                    <th style="max-width: 10%;">Kode</th>
                                    <th style="max-width: 10%;">Bobot</th>
                                    <th style="max-width: 15%;">Skala Nilai</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td rowspan="4"><span class="text-success fw-bolder">(Praktek) Membaca Al-Quran</span></td>
                                </tr>
                                <tr>
                                    <td>Tajwid</td>
                                    <td>C9</td>
                                    <td rowspan="3">
                                        <span class="text-success fw-bolder my-auto">30%</span>
                                    </td>
                                    <td><input type="number" name="in_c9" class="form-control" min="10" max="100" value="<?= $result['c9'] ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Mahraj</td>
                                    <td>C10</td>
                                    <td><input type="number" name="in_c10" class="form-control" min="10" max="100" value="<?= $result['c10'] ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Fashohah</td>
                                    <td>C11</td>
                                    <td><input type="number" name="in_c11" class="form-control" min="10" max="100" value="<?= $result['c11'] ?>" required></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="text-end py-3">
                                    <input type="hidden" name="in_id_pelamar" class="form-control" value="<?= $result['id_pelamar'] ?>" required>
                                    <td colspan="5"><button type="submit" name="_submit_" class="btn btn-lg btn-success"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
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