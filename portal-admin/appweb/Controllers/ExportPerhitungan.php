<?php

    session_start();
    // error_reporting(0);
    require "../../../appweb/Config/Db.php";
    require "../../../appweb/Config/AssetsWebsite.php";
    require "../../../appweb/Config/SetWebsite.php";

    if (empty($_SESSION['_session__'])) {
        header("location: $base_url_admin/keluar-edit");
        die();
        exit();
    }elseif((isset($_POST['_submit_']))){
        require "../../../appweb/Libraries/others.php";
        require "../../../appweb/Libraries/fungsi_upload_gambar.php";
        require "../Libraries/fungsi_form.php";

        switch ($_GET['act']) {
            case "export":

                // Data file
                    $link       = $base_url_admin."/perhitungan";
                    $database   = "lowongan";
                    $database2  = "pelamar";
                    $database3  = "identitas_user";
                // Data file

                try {
                    $stmtLowongan   = $pdo->prepare("
                        SELECT nama_sekolah, jabatan
                        FROM $database
                        WHERE id_lowongan = ?
                    ");

                    $stmtLowongan->bindValue(1, $_POST['in_id_lowongan']);
                    $stmtLowongan->execute();
                    $resultLowongan = $stmtLowongan->fetch(PDO::FETCH_ASSOC);
                } catch (Exception $e) {
                    var_dump($e);
                }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Lowongan <?= $resultLowongan['jabatan']." - ".$resultLowongan['nama_sekolah'] ?></title>
</head>
<body>
    <style type="text/css">
    body{
        font-family: sans-serif;
    }
    table{
        margin: 20px auto;
        border-collapse: collapse;
    }
    table th,
    table td{
        border: 1px solid #3c3c3c;
        padding: 3px 8px;
 
    }
    a{
        background: blue;
        color: #fff;
        padding: 8px 10px;
        text-decoration: none;
        border-radius: 2px;
    }
    </style>
 
    <?php
        $namaFile = seo("Data Lowongan"." ".$resultLowongan['jabatan']." ".$resultLowongan['nama_sekolah']." ".date("Y-m-d H-i-s"));
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$namaFile.xls");
    ?>
 
    <center>
        <h1>Data Lowongan <?= $resultLowongan['jabatan'] ?></h1>
        <h2><?= $resultLowongan['nama_sekolah'] ?></h2>
    </center>

    <?php
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

            $stmt->bindValue(1, $_POST['in_id_lowongan']);
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
            }
        } catch (Exception $e) {
            var_dump($e);
            exit();
        }
    ?>

    <?php
        $maxC1 = max($c1);
        $maxC2 = max($c2);
        $maxC3 = max($c3);
        $maxC4 = max($c4);
        $maxC5 = max($c5);
        $maxC6 = max($c6);
        $maxC7 = max($c7);
        $maxC8 = max($c8);
        $maxC9 = max($c9);
        $maxC10 = max($c10);
        $maxC11 = max($c11);
    ?>

    <?php
        $arrCount = count($nama_lgkp);
        for ($i=0; $i < $arrCount; $i++) {
            $nC1[] = ($c1[$i]/$maxC1);
            $nC2[] = ($c2[$i]/$maxC2);
            $nC3[] = ($c3[$i]/$maxC3);
            $nC4[] = ($c4[$i]/$maxC4);
            $nC5[] = ($c5[$i]/$maxC5);
            $nC6[] = ($c6[$i]/$maxC6);
            $nC7[] = ($c7[$i]/$maxC7);
            $nC8[] = ($c8[$i]/$maxC8);
            $nC9[] = ($c9[$i]/$maxC9);
            $nC10[] = ($c10[$i]/$maxC10);
            $nC11[] = ($c11[$i]/$maxC11);
        }
    ?>

    <table border="1">
        <thead>
            <tr>
                <th class="text-center" rowspan="2" style="width: 50px;">No</th>
                <th class="text-center" rowspan="2" style="width: 180px;">Nama Lengkap</th>
                <th class="text-center" colspan="4" style="width: 200px;">Nilai Kriteria</th>
                <th class="text-center" rowspan="2" style="width: 75px;">Nilai Preferensi</th>
                <th class="text-center" rowspan="2" style="width: 50px;">Rank</th>
            </tr>
            <tr>
                <th class="text-center" style="width: 50px;">K1</th>
                <th class="text-center" style="width: 50px;">K2</th>
                <th class="text-center" style="width: 50px;">K3</th>
                <th class="text-center" style="width: 50px;">K4</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $no = 1;
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
                <td><?= $no++ ?></td>
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
            </tr>
            <?php
                    $no++;
                }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
                    $_SESSION['_msg__']  = "Berhasil";
                    echo "<script>window.location = '$link'</script>";
                    die();
                    exit();
                break;

            default:
                header("location: $base_url_admin/keluar-edit");
                die();
                exit();
        }
    }else{
        header("location: $base_url_admin/keluar-edit");
        die();
        exit();
    }