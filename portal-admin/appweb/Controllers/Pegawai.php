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
    }elseif((isset($_POST['_submit_'])) OR ($_GET['act']==="reset-session")){
        require '../../../appweb/Libraries/others.php';
        require "../Libraries/fungsi_form.php";

        switch ($_GET['act']) {
            case "add-pegawai":

                // Data file
                $link       = $base_url_admin."/pegawai";
                $database   = "data_admin";
                // Data file

                // Cek username
                    $username   = preg_replace('/<[^<]+?>/', ' ', $_POST['in_username']);

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
                            exit();
                        }
                    }catch(Exception $e){
                        $_SESSION['_msg__'] = 'UsernameTerdaftar';
                        echo "<script>window.location(history.back(0))</script>";
                        exit();
                    }
                // End Cek username

                // Fungsi Password
                    $password           = htmlspecialchars($_POST['in_password']);
                    $ulangi_password    = htmlspecialchars($_POST['in_ulangi_password']);

                    if ($password!=$ulangi_password) {
                        $_SESSION['_msg__'] = 'PasswordTidakSama';
                        echo "<script>window.location(history.back(0))</script>";
                        exit();
                    }else{
                        $password_enkrip    = password_hash($password, PASSWORD_DEFAULT);
                    }
                // End Fungsi Password

                $nama   = htmlspecialchars($_POST['in_nama']);
                $avatar = "avatar.png";
                $level  = htmlspecialchars($_POST['in_level']);

                $seo    = seo($username);

                if (empty($_POST['in_slug']) || $_POST['in_slug']===NULL || $_POST['in_slug']===0) {
                    $slug   = $seo;
                    cekSlug($database, $slug);
                }else{
                    $slug   = $seo;
                    cekSlug($database, $slug);
                }

                try{
                    $stmt = $pdo->prepare("INSERT INTO $database
                                    (username,password,nama,avatar,level,slug,terakhir_login)
                                    VALUES(:username,:password,:nama,:avatar,:level,:slug,NOW())" );
                            
                    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
                    $stmt->bindParam(":password", $password_enkrip, PDO::PARAM_STR);
                    $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);
                    $stmt->bindParam(":avatar", $avatar, PDO::PARAM_STR);
                    $stmt->bindParam(":level", $level, PDO::PARAM_STR);
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

            case "edit-pegawai":

                // Data file
                $database       = "data_admin";
                // Data file

                $id_data_admin  = $_POST['in_id_data_admin'];
                $nama           = htmlspecialchars($_POST['in_nama']);
                $level          = htmlspecialchars($_POST['in_level']);
                $session        = NULL;

                // Data file
                    $link       = $base_url_admin."/pegawai/".$_POST['in_slug'];
                // Data file

                try {
                    $sql = "UPDATE $database
                            SET nama            = :nama,
                                level           = :level,
                                session         = :session
                            WHERE id_$database  = :id_data_admin
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_data_admin", $id_data_admin, PDO::PARAM_INT);
                    $statement->bindParam(":nama", $nama, PDO::PARAM_STR);
                    $statement->bindParam(":level", $level, PDO::PARAM_STR);
                    $statement->bindParam(":session", $session, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        $_SESSION['_msg__']  = "Berhasil";
                        echo "<script>window.location = '$link'</script>";
                        die();
                        exit();
                    }
                }catch(PDOException $e){
                    var_dump($e);
                    die();
                    exit();
                }

                break;
            
            case "edit-password":

                $id_data_admin      = $_POST['in_id_data_admin'];
                $slug               = $_POST['in_slug'];

                // Data file
                $link               = $base_url_admin."/pegawai/".$slug;
                $database           = "data_admin";
                // Data file

                $password           = htmlspecialchars($_POST['in_password']);
                $ulangi_password    = htmlspecialchars($_POST['in_ulangi_password']);

                if ($password!=$ulangi_password) {
                    $_SESSION['_msg__'] = 'Gagal';
                    echo "<script>window.location(history.back(0))</script>";
                    exit();
                }else{
                    $password_enkrip    = password_hash($password, PASSWORD_DEFAULT);
                }

                $session    = NULL;

                try {
                    $sql = "UPDATE $database
                            SET password        = :password,
                                session         = :session
                            WHERE id_data_admin = :id_data_admin
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_data_admin", $id_data_admin, PDO::PARAM_STR);
                    $statement->bindParam(":password", $password_enkrip, PDO::PARAM_STR);
                    $statement->bindParam(":session", $session, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        $_SESSION['_msg__']  = "Berhasil";
                        header("Location: $link");
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
            
            case "reset-session":
                // Data file
                $link       = $base_url_admin."/pegawai";
                $database   = "data_admin";
                // Data file

                $id_data_admin  = 1;
                $session        = NULL;

                try {
                    $sql = "UPDATE $database
                            SET session = :session
                            WHERE id_data_admin != :id_data_admin
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_data_admin", $id_data_admin, PDO::PARAM_STR);
                    $statement->bindParam(":session", $session, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        $_SESSION['_msg__']  = "Berhasil";
                        header("Location: $link");
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