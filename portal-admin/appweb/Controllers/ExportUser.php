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
                    $link       = $base_url_admin."/user";
                    $database   = "identitas_user";
                // Data file
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
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
        $namaFile = seo("Data User"." ".date("Y-m-d H-i-s"));
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$namaFile.xls");
    ?>
 
    <center>
        <h1>Data User</h1>
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
                try {
                    $stmt   = $pdo->prepare("
                        SELECT *
                        FROM $database
                        ORDER BY id_$database DESC
                    ");

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