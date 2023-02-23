<?php

    switch ($_GET['act']) {
        case "list":
            $hal        = "Data Perhitungan";
            $database   = "lowongan";
            $database2  = "pelamar";
            $database3  = "identitas_user";
            $link       = "perhitungan";
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
                        <form action="<?= $base_url_admin ?>/perhitungan" method="POST" data-parsley-validate="" class="row justify-content-center">
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
                        <form action="<?= $base_url_admin ?>/ExportPerhitungan" method="POST" class="card-body text-center">
                            <input type="hidden" name="in_id_lowongan" value="<?= $_POST['in_query'] ?>">
                            <button type="submit" name="_submit_" class="btn btn-lg btn-success"><i class="fas fa-file-excel"></i> Export Data</button>
                        </form>
                        <div class="card-body border-top border-body">
                            <table id="datatable" class="table table-bordered table-striped dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th style="max-width: 5%;">No.</th>
                                        <th style="max-width: 18%;">Nama Lengkap</th>
                                        <th style="max-width: 7%;">C1</th>
                                        <th style="max-width: 7%;">C2</th>
                                        <th style="max-width: 7%;">C3</th>
                                        <th style="max-width: 7%;">C4</th>
                                        <th style="max-width: 7%;">C5</th>
                                        <th style="max-width: 7%;">C6</th>
                                        <th style="max-width: 7%;">C7</th>
                                        <th style="max-width: 7%;">C8</th>
                                        <th style="max-width: 7%;">C9</th>
                                        <th style="max-width: 7%;">C10</th>
                                        <th style="max-width: 7%;">C11</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $no = 1;
                                        try {
                                            $stmt   = $pdo->prepare("
                                                SELECT id_pelamar, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, nama_sekolah, nama_lgkp
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
                                                $id_pelamar[]   = $result['id_pelamar'];
                                                $nama_lgkp[]    = $result['nama_lgkp'];
                                                $c1[]           = $result['c1'];
                                                $c2[]           = $result['c2'];
                                                $c3[]           = $result['c3'];
                                                $c4[]           = $result['c4'];
                                                $c5[]           = $result['c5'];
                                                $c6[]           = $result['c6'];
                                                $c7[]           = $result['c7'];
                                                $c8[]           = $result['c8'];
                                                $c9[]           = $result['c9'];
                                                $c10[]          = $result['c10'];
                                                $c11[]          = $result['c11'];
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><span class="text-success fw-bolder text-wrap"><?= $result['nama_lgkp'] ?></span></td>
                                        <td><?= $result['c1'] ?></td>
                                        <td><?= $result['c2'] ?></td>
                                        <td><?= $result['c3'] ?></td>
                                        <td><?= $result['c4'] ?></td>
                                        <td><?= $result['c5'] ?></td>
                                        <td><?= $result['c6'] ?></td>
                                        <td><?= $result['c7'] ?></td>
                                        <td><?= $result['c8'] ?></td>
                                        <td><?= $result['c9'] ?></td>
                                        <td><?= $result['c10'] ?></td>
                                        <td><?= $result['c11'] ?></td>
                                    </tr>
                                    <?php
                                            }
                                        } catch (Exception $e) {
                                            var_dump($e);
                                            exit();
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2"><span class="text-success fw-bolder text-wrap">Nilai Max</span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC1 = max($c1) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC2 = max($c2) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC3 = max($c3) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC4 = max($c4) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC5 = max($c5) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC6 = max($c6) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC7 = max($c7) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC8 = max($c8) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC9 = max($c9) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC10 = max($c10) ?></span></th>
                                        <th><span class="text-success fw-bolder"><?php echo $maxC11 = max($c11) ?></span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif ?>
                </div> <!-- end card-->
                <?php if (isset($_POST['_submit_'])): ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-success">Normalisasi</h3>
                    </div>
                    <div class="card-body">
                        <table id="datatable2" class="table table-bordered table-striped dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th style="max-width: 23%;">Nama Lengkap</th>
                                    <th style="max-width: 7%;">C1</th>
                                    <th style="max-width: 7%;">C2</th>
                                    <th style="max-width: 7%;">C3</th>
                                    <th style="max-width: 7%;">C4</th>
                                    <th style="max-width: 7%;">C5</th>
                                    <th style="max-width: 7%;">C6</th>
                                    <th style="max-width: 7%;">C7</th>
                                    <th style="max-width: 7%;">C8</th>
                                    <th style="max-width: 7%;">C9</th>
                                    <th style="max-width: 7%;">C10</th>
                                    <th style="max-width: 7%;">C11</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $arrCount = count($nama_lgkp);
                                    for ($i=0; $i < $arrCount; $i++) { 
                                ?>
                                <tr>
                                    <td><span class="text-success fw-bolder text-wrap"><?= $nama_lgkp[$i] ?></span></td>
                                    <td><?php $nC1[] = ($c1[$i]/$maxC1); echo number_format(($c1[$i]/$maxC1), 2); ?></td>
                                    <td><?php $nC2[] = ($c2[$i]/$maxC2); echo number_format(($c2[$i]/$maxC2), 2); ?></td>
                                    <td><?php $nC3[] = ($c3[$i]/$maxC3); echo number_format(($c3[$i]/$maxC3), 2); ?></td>
                                    <td><?php $nC4[] = ($c4[$i]/$maxC4); echo number_format(($c4[$i]/$maxC4), 2); ?></td>
                                    <td><?php $nC5[] = ($c5[$i]/$maxC5); echo number_format(($c5[$i]/$maxC5), 2); ?></td>
                                    <td><?php $nC6[] = ($c6[$i]/$maxC6); echo number_format(($c6[$i]/$maxC6), 2); ?></td>
                                    <td><?php $nC7[] = ($c7[$i]/$maxC7); echo number_format(($c7[$i]/$maxC7), 2); ?></td>
                                    <td><?php $nC8[] = ($c8[$i]/$maxC8); echo number_format(($c8[$i]/$maxC8), 2); ?></td>
                                    <td><?php $nC9[] = ($c9[$i]/$maxC9); echo number_format(($c9[$i]/$maxC9), 2); ?></td>
                                    <td><?php $nC10[] = ($c10[$i]/$maxC10); echo number_format(($c10[$i]/$maxC10), 2); ?></td>
                                    <td><?php $nC11[] = ($c11[$i]/$maxC11); echo number_format(($c11[$i]/$maxC11), 2); ?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="text-success">Perhitungan</h3>
                    </div>
                    <div class="card-body">
                        <table id="datatable3" class="table table-bordered table-striped dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2" style="max-width: 20%;">Nama Lengkap</th>
                                    <th class="text-center" colspan="4" style="max-width: 40%;">Nilai Kriteria</th>
                                    <th class="text-center" rowspan="2" style="max-width: 15%;">Nilai Preferensi</th>
                                    <th class="text-center" rowspan="2" style="max-width: 10%;">Rank</th>
                                    <th class="text-center" rowspan="2" style="max-width: 15%;">Status</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="max-width: 10%;">K1 (LK)</th>
                                    <th class="text-center" style="max-width: 10%;">K2 (S)</th>
                                    <th class="text-center" style="max-width: 10%;">K3 (WT)</th>
                                    <th class="text-center" style="max-width: 10%;">K4 (AQ)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $arrCount = count($nama_lgkp);
                                    for ($i=0; $i < $arrCount; $i++) {
                                        $K1[] = (($nC1[$i]+$nC2[$i]+$nC3[$i])/3)*30/100;
                                        $K2[] = (($nC4[$i]+$nC5[$i])/2)*30/100;
                                        $K3[] = (($nC6[$i]+$nC7[$i]+$nC8[$i])/3)*10/100;
                                        $K4[] = (($nC9[$i]+$nC10[$i]+$nC11[$i])/3)*30/100;
                                        $RankNilaiPreferensi[] = $K1[$i] + $K2[$i] + $K3[$i] + $K4[$i];
                                        $NilaiPreferensi[] = $K1[$i] + $K2[$i] + $K3[$i] + $K4[$i];
                                    }
                                ?>

                                <?php
                                    $i=1;
                                    foreach ($RankNilaiPreferensi as $key => $value) {
                                        $max = max($RankNilaiPreferensi);

                                        $MaxRankNilaiPreferensi[]   = $max;
                                        $Rank[]                     = $i;

                                        $keys = array_search($max, $RankNilaiPreferensi);    
                                        unset($RankNilaiPreferensi[$keys]);

                                        if(sizeof($RankNilaiPreferensi) > 0)
                                        if(!in_array($max,$RankNilaiPreferensi))
                                            $i++;
                                    }
                                ?>
                                <?php
                                    $arrCount = count($nama_lgkp);
                                    for ($i=0; $i < $arrCount; $i++) { 
                                ?>
                                <tr>
                                    <td><span class="text-success fw-bolder text-wrap"><?= $nama_lgkp[$i] ?></span></td>
                                    <td class="text-center">
                                        <?= number_format($K1[$i], 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= number_format($K2[$i], 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= number_format($K3[$i], 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= number_format($K4[$i], 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-success fw-bolder text-wrap"><?= number_format($NilaiPreferensi[$i]*100, 3) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-success fw-bolder text-wrap">
                                            <?php
                                                foreach ($Rank as $key => $value) {
                                                    if ($MaxRankNilaiPreferensi[$key]===$NilaiPreferensi[$i]) {
                                                        echo $Rank[$key];
                                                    }
                                                }
                                            ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (number_format($NilaiPreferensi[$i]*100, 3)>=70): ?>
                                            <span class="text-success fw-bolder text-wrap"><span class="mdi mdi-check-all"></span> LULUS</span>
                                        <?php elseif (number_format($NilaiPreferensi[$i]*100, 3)<=69): ?>
                                            <span class="text-danger fw-bolder text-wrap"><span class="mdi mdi-close-thick"></span> TIDAK LULUS</span>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                        </table>
                        <p>*jika nilai preferensi >70 maka dapat dinyatakan lulus kompetensi kemuhammadiyahan</p> 
                    </div>
                </div>
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