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
            $nama               = htmlspecialchars($_POST['in_nama_lgkp']);
            $email              = htmlspecialchars($_POST['in_email']);

            $username           = preg_replace('/<[^<]+?>/', ' ', $_POST['in_username']);
            $password           = htmlspecialchars($_POST['in_password']);
            $ulangi_password    = htmlspecialchars($_POST['in_ulangi_password']);

            $status             = "Active";
            $status_identitas   = "Kosong";
            $status_dokumen     = "Kosong";

            $seo                = seo($nama." ".rand(100,999));
        // Data Inputan

        // Cek username
            try{
                $stmt   = $pdo->prepare("SELECT 
                                    username
                                    FROM $database
                                    WHERE username = ? LIMIT 1");

                $stmt->bindValue(1, $username);
                $stmt->execute();

                $rowsCekUsername = $stmt->rowCount();

                if ($rowsCekUsername>0) {
                    $_SESSION['_msg__'] = 'UsernameTerdaftar';
                    echo "<script>window.location(history.back(0))</script>";
                    exit();die();
                }
            }catch(Exception $e){
                $_SESSION['_msg__'] = 'UsernameTerdaftar';
                echo "<script>window.location(history.back(0))</script>";
                exit();die();
            }
        // End Cek username

        // Fungsi Password
            if ($password!=$ulangi_password) {
                $_SESSION['_msg__'] = 'PasswordTidakSama';
                echo "<script>window.location(history.back(0))</script>";
                exit();die();
            }else{
                $password_enkrip    = password_hash($password, PASSWORD_DEFAULT);
            }
        // End Fungsi Password

        // Cek Slug
            if (empty($_POST['___in_slug_special_ARPATEAM']) || $_POST['___in_slug_special_ARPATEAM']===NULL || $_POST['___in_slug_special_ARPATEAM']===0) {
                $slug   = $seo;
                cekSlug($database, $slug);
            }else{
                $slug   = $seo;
                cekSlug($database, $slug);
            }
        // End Cek Slug

        try{
            $stmt = $pdo->prepare("INSERT INTO $database
                            (username,password,status,status_identitas,status_dokumen,slug)
                            VALUES(:username,:password,:status,:status_identitas,:status_dokumen,:slug)" );
                    
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password_enkrip, PDO::PARAM_STR);
            $stmt->bindParam(":status", $status, PDO::PARAM_STR);
            $stmt->bindParam(":status_identitas", $status_identitas, PDO::PARAM_STR);
            $stmt->bindParam(":status_dokumen", $status_dokumen, PDO::PARAM_STR);
            $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);

            $count      = $stmt->execute();
            $insertId   = $pdo->lastInsertId();

            if ($count>0) {
                try {
                    $stmt2 = $pdo->prepare("INSERT INTO $database2
                            (id_data_user,nama_lgkp,email)
                            VALUES(:id_data_user,:nama_lgkp,:email)" );
                    
                    $stmt2->bindParam(":id_data_user", $insertId, PDO::PARAM_STR);
                    $stmt2->bindParam(":nama_lgkp", $nama, PDO::PARAM_STR);
                    $stmt2->bindParam(":email", $email, PDO::PARAM_STR);

                    $count2      = $stmt2->execute();
                    $insertId2   = $pdo->lastInsertId();
                    if ($count2>0) {
                        try {
                            $stmt3 = $pdo->prepare("INSERT INTO $database3
                                    (id_data_user)
                                    VALUES(:id_data_user)" );
                            
                            $stmt3->bindParam(":id_data_user", $insertId, PDO::PARAM_STR);

                            $count3      = $stmt3->execute();
                            $insertId3   = $pdo->lastInsertId();
                            if ($count3>0) {
                                $_SESSION['_msg__'] = 'FromRegister';
                                echo "<script>window.location = '$link'</script>";
                                die();
                                exit();
                            }
                        } catch (Exception $e) {
                            $_SESSION['_msg__'] = 'GagalRegister';
                            echo "<script>window.location = '$link/daftar'</script>";
                            die();
                            exit();
                        }
                    }
                } catch (Exception $e) {
                    $_SESSION['_msg__'] = 'GagalRegister';
                    echo "<script>window.location = '$link/daftar'</script>";
                    die();
                    exit();
                }
            }     
        }catch(PDOException $e){
            $_SESSION['_msg__'] = 'GagalRegister';
            echo "<script>window.location = '$link/daftar'</script>";
            die();
            exit();
        }
    }else{
        header("location: $base_url/keluar-edit");
        die();
        exit(); 
    }