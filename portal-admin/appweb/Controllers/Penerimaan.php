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
            case "add":

                // Data file
                $link       = $base_url_admin."/penerimaan";
                $database   = "lowongan";
                // Data file

                $nama_sekolah   = htmlspecialchars($_POST['in_nama_sekolah']);
                $jabatan        = htmlspecialchars($_POST['in_jabatan']);
                $status         = htmlspecialchars($_POST['in_stat']);

                $seo            = seo($nama_sekolah." ".$jabatan." ".rand(100,999));
                $slug           = $seo;
                cekSlug($database, $slug);

                try{
                    $stmt = $pdo->prepare("INSERT INTO $database
                                    (nama_sekolah,jabatan,status,slug)
                                    VALUES(:nama_sekolah,:jabatan,:status,:slug)" );
                            
                    $stmt->bindParam(":nama_sekolah", $nama_sekolah, PDO::PARAM_STR);
                    $stmt->bindParam(":jabatan", $jabatan, PDO::PARAM_STR);
                    $stmt->bindParam(":status", $status, PDO::PARAM_STR);
                    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);

                    $count = $stmt->execute();
                            
                    $insertId = $pdo->lastInsertId();

                    if ($count>0) {
                        $_SESSION['_msg__'] = 'Berhasil';
                        echo "<script>window.location = '$link'</script>";
                        die();
                        exit();
                    }     
                }catch(PDOException $e){
                    $_SESSION['_msg__'] = 'Gagal';
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                break;

            case "edit":

                // Data file
                $link       = $base_url_admin."/penerimaan";
                $database   = "lowongan";
                // Data file

                $id_lowongan    = htmlspecialchars($_POST['in_id_lowongan']);
                $nama_sekolah   = htmlspecialchars($_POST['in_nama_sekolah']);
                $jabatan        = htmlspecialchars($_POST['in_jabatan']);
                $status         = htmlspecialchars($_POST['in_stat']);

                $seo            = seo($nama_sekolah." ".$jabatan." ".rand(100,999));

                if ($seo===$_POST['in_slug_lama']) {
                    $slug   = $_POST['in_slug_lama'];
                }else{
                    $slug   = $seo;
                    cekSlug($database, $slug);
                }

                try {
                    $sql = "UPDATE $database
                            SET nama_sekolah    = :nama_sekolah,
                                jabatan         = :jabatan,
                                status          = :status,
                                slug            = :slug
                            WHERE id_$database  = :id_lowongan
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_lowongan", $id_lowongan, PDO::PARAM_INT);
                    $statement->bindParam(":nama_sekolah", $nama_sekolah, PDO::PARAM_STR);
                    $statement->bindParam(":jabatan", $jabatan, PDO::PARAM_STR);
                    $statement->bindParam(":status", $status, PDO::PARAM_STR);
                    $statement->bindParam(":slug", $slug, PDO::PARAM_STR);

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

            case "delete":

                // Data file
                $link       = $base_url_admin."/penerimaan";
                $database   = "lowongan";
                // Data file

                $id_lowongan= $_GET['id'];
                $status     = "Hapus";

                try {
                    $sql = "UPDATE $database
                            SET status          = :status
                            WHERE id_$database  = :id_lowongan
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_lowongan", $id_lowongan, PDO::PARAM_INT);
                    $statement->bindParam(":status", $status, PDO::PARAM_STR);

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