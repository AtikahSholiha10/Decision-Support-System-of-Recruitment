<?php

    session_start();
    // error_reporting(0);
    require "../../appweb/Config/Db.php";
    require "../../appweb/Config/AssetsWebsite.php";
    require "../../appweb/Config/SetWebsite.php";

    if(isset($_POST['_submit_'])){
        require '../Libraries/others.php';
        require "../Libraries/fungsi_upload_gambar.php";
        require "../Libraries/fungsi_form.php";

        // Data file
            $link       = $base_url;
            $database   = "data_user";
            $database2  = "identitas_user";
            $database3  = "dokumen_user";
        // Data file

        // Data Inputan
            $myUsername = preg_replace('/<[^<]+?>/', '', $_POST['in_username']);
            $myPassword = htmlspecialchars($_POST['in_password']);
            $myStatus   = "Active";
        // Data Inputan

        try{
            $stmt   = $pdo->prepare("SELECT 
                        id_data_user, password, status_identitas, status_dokumen
                        FROM $database
                        WHERE username = ? AND status = ? LIMIT 1
                    ");

            $stmt->bindValue(1, $myUsername);
            $stmt->bindValue(2, $myStatus);
            $stmt->execute();

            $resultLogin    = $stmt->fetch(PDO::FETCH_ASSOC);
            $rowsLogin      = $stmt->rowCount();

            if ($rowsLogin>0){
                if (password_verify($myPassword, $resultLogin['password'])>0) {
                    $session = hash('ripemd256', $myUsername).hash('sha256', date("Y-m-d H:i:s"));
                    try{
                        $sql = "UPDATE $database SET session = :session, terakhir_login = now() WHERE username = :username";
                                      
                        $statement = $pdo->prepare($sql);

                        $statement->bindParam(":username", $myUsername, PDO::PARAM_STR);
                        $statement->bindParam(":session", $session, PDO::PARAM_STR);

                        $count = $statement->execute();

                        if ($count>0) {
                            try {
                                $stmt2  = $pdo->prepare("SELECT 
                                            id_identitas_user, nama_lgkp
                                            FROM $database2
                                            WHERE id_data_user = ? LIMIT 1
                                        ");

                                $stmt2->bindValue(1, $resultLogin['id_data_user']);
                                $stmt2->execute();

                                $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $rows2      = $stmt2->rowCount();

                                if ($rows2>0) {
                                    try {
                                        $stmt3  = $pdo->prepare("SELECT 
                                                    id_dokumen_user, foto3x4
                                                    FROM $database3
                                                    WHERE id_data_user = ? LIMIT 1
                                                ");

                                        $stmt3->bindValue(1, $resultLogin['id_data_user']);
                                        $stmt3->execute();

                                        $result3    = $stmt3->fetch(PDO::FETCH_ASSOC);
                                        $rows3      = $stmt3->rowCount();

                                        if ($rows3>0) {
                                            // Jika berhasil
                                            $_SESSION['_alert__']               = '0';
                                            $_SESSION['_msg__']                 = 'FromLogin';
                                            $_SESSION['_session__']             = $session;
                                            $_SESSION['_id_data_user__']        = $resultLogin['id_data_user'];
                                            $_SESSION['_status_identitas__']    = $resultLogin['status_identitas'];
                                            $_SESSION['_status_dokumen__']      = $resultLogin['status_dokumen'];
                                            $_SESSION['_id_identitas_user__']   = $result2['id_identitas_user'];
                                            $_SESSION['_id_dokumen_user__']     = $result3['id_dokumen_user'];
                                            $_SESSION['_nama_lgkp__']           = $result2['nama_lgkp'];
                                            $_SESSION['_foto3x4__']             = $result3['foto3x4'];
                                            
                                            if (empty($_SESSION['_foto3x4__'])) {
                                                $_SESSION['_foto3x4__'] = "avatar.png";
                                            }

                                            echo "<script>window.location = '$base_url/dashboard';</script>";
                                            die();
                                            exit();
                                        }
                                    } catch (Exception $e) {
                                        $_SESSION['_msg__'] = 'GagalLogin';
                                        echo "<script>window.location(history.back(0))</script>";
                                        exit();
                                        die();
                                    }
                                }
                            } catch (Exception $e) {
                                $_SESSION['_msg__'] = 'GagalLogin';
                                echo "<script>window.location(history.back(0))</script>";
                                exit();
                                die();
                            }
                        }else{
                            $_SESSION['_msg__'] = 'GagalLogin';
                            echo "<script>window.location(history.back(0))</script>";
                            exit();
                            die();
                        }
                    }catch(PDOException $e){
                        $_SESSION['_msg__'] = 'GagalLogin';
                        echo "<script>window.location(history.back(0))</script>";
                        exit();
                        die();
                    }
                }else{
                    $_SESSION['_msg__'] = 'GagalLogin';
                    echo "<script>window.location(history.back(0))</script>";
                    exit();
                    die();
                }
            }else{
                $_SESSION['_msg__'] = 'GagalLogin';
                echo "<script>window.location(history.back(0))</script>";
                exit();
                die();
            }
        }catch(Exception $e) {
            $_SESSION['_msg__'] = 'GagalLogin';
            echo "<script>window.location(history.back(0))</script>";
            exit();
            die();
        }
    }else{
        header("location: $base_url/keluar-edit");
        die();
        exit(); 
    }