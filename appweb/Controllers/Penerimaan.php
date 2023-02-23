<?php

    session_start();
    // error_reporting(E_ALL);
    require "../../appweb/Config/Db.php";
    require "../../appweb/Config/AssetsWebsite.php";
    require "../../appweb/Config/SetWebsite.php";

    if (empty($_SESSION['_session__'])) {
        header("location: $base_url/keluar-edit");
        die();
        exit();
    }elseif((isset($_POST['_submit_'])) OR ($_GET['act']==="lamar")){
        require '../Libraries/others.php';
        require "../Libraries/fungsi_upload_gambar.php";
        require "../Libraries/fungsi_form.php";

        switch ($_GET['act']) {
            case "lamar":
                // Data file
                $database   = "pelamar";
                $link       = $base_url."/penerimaan";
                // Data file

                $id_data_user   = $_SESSION['_id_data_user__'];
                $id_lowongan    = $_GET['id'];
                $c1             = NULL;
                $c2             = NULL;
                $c3             = NULL;
                $c4             = NULL;
                $c5             = NULL;
                $c6             = NULL;
                $c7             = NULL;
                $c8             = NULL;
                $c9             = NULL;
                $c10            = NULL;
                $c11            = NULL;
                $status         = "Belum";

                try {
                    $cek   = $pdo->prepare("
                        SELECT *
                        FROM $database
                        WHERE id_data_user = ?
                        AND id_lowongan = ?
                    ");

                    $cek->bindValue(1, $id_data_user);
                    $cek->bindValue(2, $id_lowongan);
                    $cek->execute();
                    $cekLamaran = $cek->rowCount();
                    if ($cekLamaran>0) {
                        $_SESSION['_msg__'] = 'GagalLamar';
                        echo "<script>window.location(history.back(0))</script>";
                        die();
                        exit();
                    }
                } catch (Exception $e) {
                    $_SESSION['_msg__'] = 'Gagal';
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                try{
                    $stmt = $pdo->prepare("INSERT INTO $database
                                    (id_data_user,id_lowongan,c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11,status)
                                    VALUES(:id_data_user,:id_lowongan,:c1,:c2,:c3,:c4,:c5,:c6,:c7,:c8,:c9,:c10,:c11,:status)" );
                            
                    $stmt->bindParam(":id_data_user", $id_data_user, PDO::PARAM_STR);
                    $stmt->bindParam(":id_lowongan", $id_lowongan, PDO::PARAM_STR);
                    $stmt->bindParam(":c1", $c1, PDO::PARAM_STR);
                    $stmt->bindParam(":c2", $c2, PDO::PARAM_STR);
                    $stmt->bindParam(":c3", $c3, PDO::PARAM_STR);
                    $stmt->bindParam(":c4", $c4, PDO::PARAM_STR);
                    $stmt->bindParam(":c5", $c5, PDO::PARAM_STR);
                    $stmt->bindParam(":c6", $c6, PDO::PARAM_STR);
                    $stmt->bindParam(":c7", $c7, PDO::PARAM_STR);
                    $stmt->bindParam(":c8", $c8, PDO::PARAM_STR);
                    $stmt->bindParam(":c9", $c9, PDO::PARAM_STR);
                    $stmt->bindParam(":c10", $c10, PDO::PARAM_STR);
                    $stmt->bindParam(":c11", $c11, PDO::PARAM_STR);
                    $stmt->bindParam(":status", $status, PDO::PARAM_STR);

                    $count      = $stmt->execute();
                    $insertId   = $pdo->lastInsertId();

                    if ($count>0) {
                        $_SESSION['_msg__'] = 'BerhasilLamar';
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

            default:
                header("location: $base_url/keluar-edit");
                die();
                exit();
        }
    }else{
        header("location: $base_url/keluar-edit");
        die();
        exit();
    }