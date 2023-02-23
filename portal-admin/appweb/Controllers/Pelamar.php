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
    }elseif((isset($_POST['_submit_'])) OR (($_GET['act']==="delete"))){
        require '../../../appweb/Libraries/others.php';
        require "../Libraries/fungsi_form.php";

        switch ($_GET['act']) {
            case "edit-wawancara-loyalitas-dan-kemuhammadiyahan":

                // Data file
                $link       = $base_url_admin."/pelamar/nilai/".$_POST['in_id_pelamar']."/wawancara-loyalitas-dan-kemuhammadiyahan";
                $database   = "pelamar";
                // Data file

                $id_pelamar = htmlspecialchars($_POST['in_id_pelamar']);
                $c1         = htmlspecialchars($_POST['in_c1']);
                $c2         = htmlspecialchars($_POST['in_c2']);
                $c3         = htmlspecialchars($_POST['in_c3']);

                try {
                    $sql = "UPDATE $database
                            SET c1  = :c1,
                                c2  = :c2,
                                c3  = :c3
                            WHERE id_$database  = :id_pelamar
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_pelamar", $id_pelamar, PDO::PARAM_INT);
                    $statement->bindParam(":c1", $c1, PDO::PARAM_STR);
                    $statement->bindParam(":c2", $c2, PDO::PARAM_STR);
                    $statement->bindParam(":c3", $c3, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        $_SESSION['_msg__']  = "Berhasil";
                        echo "<script>window.location = '$link'</script>";
                        die();
                        exit();
                    }
                }catch(PDOException $e){
                    $_SESSION['_msg__']  = "Gagal";
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                break;

            case "edit-praktek-sholat":

                // Data file
                $link       = $base_url_admin."/pelamar/nilai/".$_POST['in_id_pelamar']."/praktek-sholat";
                $database   = "pelamar";
                // Data file

                $id_pelamar = htmlspecialchars($_POST['in_id_pelamar']);
                $c4         = htmlspecialchars($_POST['in_c4']);
                $c5         = htmlspecialchars($_POST['in_c5']);

                try {
                    $sql = "UPDATE $database
                            SET c4  = :c4,
                                c5  = :c5
                            WHERE id_$database  = :id_pelamar
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_pelamar", $id_pelamar, PDO::PARAM_INT);
                    $statement->bindParam(":c4", $c4, PDO::PARAM_STR);
                    $statement->bindParam(":c5", $c5, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        $_SESSION['_msg__']  = "Berhasil";
                        echo "<script>window.location = '$link'</script>";
                        die();
                        exit();
                    }
                }catch(PDOException $e){
                    $_SESSION['_msg__']  = "Gagal";
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                break;
                
            case "edit-praktek-wudhu-dan-tayamum":

                // Data file
                $link       = $base_url_admin."/pelamar/nilai/".$_POST['in_id_pelamar']."/praktek-wudhu-dan-tayamum";
                $database   = "pelamar";
                // Data file

                $id_pelamar = htmlspecialchars($_POST['in_id_pelamar']);
                $c6         = htmlspecialchars($_POST['in_c6']);
                $c7         = htmlspecialchars($_POST['in_c7']);
                $c8         = htmlspecialchars($_POST['in_c8']);

                try {
                    $sql = "UPDATE $database
                            SET c6  = :c6,
                                c7  = :c7,
                                c8  = :c8
                            WHERE id_$database  = :id_pelamar
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_pelamar", $id_pelamar, PDO::PARAM_INT);
                    $statement->bindParam(":c6", $c6, PDO::PARAM_STR);
                    $statement->bindParam(":c7", $c7, PDO::PARAM_STR);
                    $statement->bindParam(":c8", $c8, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        $_SESSION['_msg__']  = "Berhasil";
                        echo "<script>window.location = '$link'</script>";
                        die();
                        exit();
                    }
                }catch(PDOException $e){
                    $_SESSION['_msg__']  = "Gagal";
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                break;
                
            case "edit-praktek-membaca-al-quran":

                // Data file
                $link       = $base_url_admin."/pelamar/nilai/".$_POST['in_id_pelamar']."/praktek-membaca-al-quran";
                $database   = "pelamar";
                // Data file

                $id_pelamar = htmlspecialchars($_POST['in_id_pelamar']);
                $c9         = htmlspecialchars($_POST['in_c9']);
                $c10        = htmlspecialchars($_POST['in_c10']);
                $c11        = htmlspecialchars($_POST['in_c11']);
                $status     = "Dinilai";

                try {
                    $sql = "UPDATE $database
                            SET c9  = :c9,
                                c10 = :c10,
                                c11 = :c11
                            WHERE id_$database  = :id_pelamar
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_pelamar", $id_pelamar, PDO::PARAM_INT);
                    $statement->bindParam(":c9", $c9, PDO::PARAM_STR);
                    $statement->bindParam(":c10", $c10, PDO::PARAM_STR);
                    $statement->bindParam(":c11", $c11, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        $_SESSION['_msg__']  = "Berhasil";
                        echo "<script>window.location = '$link'</script>";
                        die();
                        exit();
                    }
                }catch(PDOException $e){
                    $_SESSION['_msg__']  = "Gagal";
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                break;
                
            case "export":

                // Data file
                    $link       = $base_url_admin."/pelamar";
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
    <title>Data Pelamar <?= $resultLowongan['jabatan']." - ".$resultLowongan['nama_sekolah'] ?></title>
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
        $namaFile = seo("Data Pelamar"." ".$resultLowongan['jabatan']." ".$resultLowongan['nama_sekolah']." ".date("Y-m-d H-i-s"));
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$namaFile.xls");
    ?>
 
    <center>
        <h1>Data Pelamar <?= $resultLowongan['jabatan'] ?></h1>
        <h2><?= $resultLowongan['nama_sekolah'] ?></h2>
    </center>

    <table border="1">
        <thead>
            <tr>
                <th style="width: 100px;">No. Pendaftaran</th>
                <th style="width: 250px;">Nama Lengkap</th>
                <th style="width: 100px;">NIK</th>
                <th style="width: 75px;">Jenis Kelamin</th>
                <th style="width: 150px;">Tempat Lahir</th>
                <th style="width: 100px;">Tanggal Lahir</th>
                <th style="width: 250px;">Alamat Lengkap</th>
                <th style="width: 100px;">No. HP</th>
                <th style="width: 175px;">Email</th>
                <th style="width: 100px;">Status</th>
                <th style="width: 100px;">Agama</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $no = 1;
                try {
                    $stmt   = $pdo->prepare("
                        SELECT *
                        FROM pelamar
                        INNER JOIN identitas_user
                        ON pelamar.id_data_user = identitas_user.id_data_user
                        WHERE id_lowongan = ?
                        ORDER BY id_pelamar DESC
                    ");

                    $stmt->bindValue(1, $_POST['in_id_lowongan']);
                    $stmt->execute();
                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?= $result['id_data_user'] ?></td>
                <td><span class="text-success fw-bolder"><?= $result['nama_lgkp'] ?></span></td>
                <td><?= $result['nik'] ?></td>
                <td><?= $result['jk'] ?></td>
                <td><?= $result['tmpt_lhr'] ?></td>
                <td><?= $result['tgl_lhr'] ?></td>
                <td><?= $result['alamat_lgkp'] ?></td>
                <td><?= $result['no_hp'] ?></td>
                <td><?= $result['email'] ?></td>
                <td><?= $result['stts_perkawinan'] ?></td>
                <td><?= $result['agama'] ?></td>
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