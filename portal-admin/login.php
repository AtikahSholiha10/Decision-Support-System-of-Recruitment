<?php
    require "../appweb/Config/SetWebsite.php";
    require "../appweb/Config/Db.php";
    require "../appweb/Config/AssetsWebsite.php";

    session_start();
    // error_reporting(0);

    if (isset($_POST['_submit_'])) {
        // $url        = 'https://www.google.com/recaptcha/api/siteverify';
        // $secret     = $secret_key_reCAPTCHA;
        // $response   = file_get_contents($url.'?secret='.$secret.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR']);
        // $data       = json_decode($response);

        // if ($data->success == true) {
            //Mendapatkan data user dari Form Login
            $myUsername = preg_replace('/<[^<]+?>/', '', $_POST['in_username']);
            $myPassword = htmlspecialchars($_POST['in_password']);

            try{
                $stmt   = $pdo->prepare("SELECT 
                                    id_data_admin, password, nama, avatar, level
                                    FROM data_admin
                                    WHERE username = ? LIMIT 1");

                $stmt->bindValue(1, $myUsername);
                $stmt->execute();

                $resultLogin    = $stmt->fetch(PDO::FETCH_ASSOC);
                $rowsLogin      = $stmt->rowCount();

                if ($rowsLogin>0){
                    if (password_verify($myPassword, $resultLogin['password'])>0) {
                        $session = hash('ripemd256', $myUsername).hash('sha256', date("Y-m-d H:i:s"));
                        try{
                            $sql = "UPDATE data_admin SET session = :session, terakhir_login = now() WHERE username = :username";
                                          
                            $statement = $pdo->prepare($sql);

                            $statement->bindParam(":username", $myUsername, PDO::PARAM_STR);
                            $statement->bindParam(":session", $session, PDO::PARAM_STR);

                            $count = $statement->execute();

                            if ($count>0) {
                                // Jika berhasil
                                $_SESSION['_alert__']           = '0';
                                $_SESSION['_msg__']             = 'FromLogin';
                                $_SESSION['_session__']         = $session;
                                $_SESSION['_id_data_admin__']   = $resultLogin['id_data_admin'];
                                $_SESSION['_nama__']            = $resultLogin['nama'];
                                $_SESSION['_avatar__']          = $resultLogin['avatar'];
                                $_SESSION['_level__']           = $resultLogin['level'];

                                echo "<script>window.location = '$base_url_admin/dashboard';</script>";
                                die();
                                exit();
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
        // }else{
        //     $_SESSION['_msg__'] = 'GagalreCAPTCHA';
        //     echo "<script>window.location(history.back(0))</script>";
        //     exit();
        //     die();
        // }
    }

    if ($_SESSION['_msg__']==="GagalLogin") {
        $_SESSION['_alert__']   = '1';
    }elseif ($_SESSION['_msg__']==="GagalreCAPTCHA") {
        $_SESSION['_alert__']   = '4';
    }elseif ($_SESSION['_msg__']==="Back") {
        $_SESSION['_alert__']   = '4';
    }else{
        $_SESSION['_alert__']   = '0';
        $_SESSION['_msg__']     = '0';
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Login - <?= $nama_web ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Coderthemes" name="<?= $nama_web ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $url_images; ?>/<?= $icon; ?>" />

    <!-- App css -->
    <link href="<?= $base_url_admin ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?= $base_url_admin ?>/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- App-dark css -->
    <link href="<?= $base_url_admin ?>/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled"/>
    <link href="<?= $base_url_admin ?>/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled"/>

    <!-- icons -->
    <link href="<?= $base_url_admin ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
</head>
<body class="loading authentication-bg authentication-bg-pattern">
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card my-4">
                        <div class="card-body p-4">
                            
                            <div class="text-center mb-2">
                                <h3 class="text-uppercase text-primary mt-0">Form Login</h3>

                                <img src="<?= $url_images; ?>/<?= $logoMobile; ?>" alt="<?= $judulLogoMobile; ?>" class="w-50 my-2">
                            </div>

                            <?php
                                if ($_SESSION['_msg__']==="GagalLogin") {
                                    echo "<div class='alert alert-danger text-left' role='alert'>";
                                    echo "<h4 class='alert-heading text-danger'><i class='fas fa-exclamation-triangle'></i> GAGAL!</h4>";
                                    echo "<p class='mb-0'><strong>Username</strong> atau <strong>Password</strong> anda salah! Mohon periksa kembali.</p>";
                                    echo "</div>";
                                    $_SESSION['_msg__'] = 0;
                                }elseif ($_SESSION['_msg__']==="GagalreCAPTCHA") {
                                    echo "<div class='alert alert-danger text-left' role='alert'>";
                                    echo "<h4 class='alert-heading text-danger'><i class='fas fa-exclamation-triangle'></i> CAPTCHA SALAH!</h4>";
                                    echo "<p class='mb-0'>Mohon isi <strong>captcha</strong> kembali!</p>";
                                    echo "</div>";
                                    $_SESSION['_msg__'] = 0;
                                }elseif ($_SESSION['_msg__']==="Back") {
                                    echo "<div class='alert alert-success text-left' role='alert'>";
                                    echo "<h4 class='alert-heading text-success'><i class='fas fa-exclamation-triangle'></i> ANDA TELAH <em>LOGOUT</em> dari sistem!</h4>";
                                    echo "<p class='mb-0'>Silahkan <strong>login</strong> kembali!</p>";
                                    echo "</div>";
                                    $_SESSION['_msg__'] = 0;
                                }
                            ?>

                            <form action="" method="POST" data-parsley-validate="">

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input class="form-control" type="text" id="username" name="in_username" placeholder="Masukkan username anda..." required="">
                                </div>

                                <div class="mb-3">
                                    <label for="pass" class="form-label">Password <span id="buttonShowPassword" onclick="showPassword()"><i class="fas fa-eye-slash"></i></span></label>
                                    <input class="form-control" type="password" id="pass" name="in_password" placeholder="Masukkan password anda..." required="">
                                </div>

                                <!-- <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div> -->

                                <!-- <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="<?= $site_key_reCAPTCHA ?>" required></div>
                                </div> -->

                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary" type="submit" name="_submit_"> Log In <span class="mdi mdi-login-variant"></span></button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor -->
    <script src="<?= $base_url_admin ?>/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= $base_url_admin ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $base_url_admin ?>/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= $base_url_admin ?>/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= $base_url_admin ?>/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?= $base_url_admin ?>/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?= $base_url_admin ?>/assets/libs/feather-icons/feather.min.js"></script>

    <!-- Plugin js-->
    <script src="<?= $base_url_admin ?>/assets/libs/parsleyjs/parsley.min.js"></script>

    <!-- Validation init js-->
    <script src="<?= $base_url_admin ?>/assets/js/pages/form-validation.init.js"></script>

    <!-- App js -->
    <script src="<?= $base_url_admin ?>/assets/js/app.min.js"></script>

    <script>
        function showPassword() {
            // membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
            var x = document.getElementById('pass').type;
            //membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
            if (x == 'password') {
                //ubah form input password menjadi text
                document.getElementById('pass').type = 'text';
                
                //ubah icon mata terbuka menjadi tertutup
                document.getElementById('buttonShowPassword').innerHTML = `<i class="fas fa-eye"></i>`;
            }else{
                //ubah form input password menjadi text
                document.getElementById('pass').type = 'password';

                //ubah icon mata terbuka menjadi tertutup
                document.getElementById('buttonShowPassword').innerHTML = `<i class="fas fa-eye-slash"></i>`;
            }
        }
    </script>
    
</body>
</html>