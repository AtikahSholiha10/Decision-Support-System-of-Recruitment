<?php
    require "../../appweb/Config/SetWebsite.php";
    require "../../appweb/Config/Db.php";
    require "../../appweb/Config/AssetsWebsite.php";

    session_start();
    // error_reporting(0);

    if ($_SESSION['_msg__']==="GagalRegister") {
        $_SESSION['_alert__']   = '1';
    }elseif ($_SESSION['_msg__']==="UsernameTerdaftar") {
        $_SESSION['_alert__']   = '2';
    }elseif ($_SESSION['_msg__']==="GagalreCAPTCHA") {
        $_SESSION['_alert__']   = '3';
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
    <title>Register - <?= $nama_web ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Coderthemes" name="<?= $nama_web ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $url_images; ?>/<?= $icon; ?>" />

    <!-- App css -->
    <link href="<?= $base_url ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?= $base_url ?>/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- App-dark css -->
    <link href="<?= $base_url ?>/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled"/>
    <link href="<?= $base_url ?>/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled"/>

    <!-- icons -->
    <link href="<?= $base_url ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= $base_url ?>/assets/libs/validation-pass-arpateam/css/style.css">
    
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
</head>
<body class="loading authentication-bg authentication-bg-pattern">
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-9 col-xl-7">
                    <div class="card my-4">
                        <div class="card-body p-4">
                            
                            <div class="text-center mb-2">
                                <h3 class="text-uppercase text-success mt-0">Form Register</h3>

                                <img src="<?= $url_images; ?>/<?= $logoMobile; ?>" alt="<?= $judulLogoMobile; ?>" class="w-25 my-2">
                            </div>

                            <?php
                                if ($_SESSION['_msg__']==="GagalRegister") {
                                    echo "<div class='alert alert-danger text-left' role='alert'>";
                                    echo "<h4 class='alert-heading text-danger'><i class='fas fa-exclamation-triangle'></i> GAGAL REGISTER!</h4>";
                                    echo "<p class='mb-0'>Mohon <strong>lengkapi</strong> kembali <em>form</em> dibawah ini!</p>";
                                    echo "</div>";
                                    $_SESSION['_msg__'] = 0;
                                }elseif ($_SESSION['_msg__']==="UsernameTerdaftar") {
                                    echo "<div class='alert alert-danger text-left' role='alert'>";
                                    echo "<h4 class='alert-heading text-danger'><i class='fas fa-exclamation-triangle'></i> USERNAME TERDAFTAR!</h4>";
                                    echo "<p class='mb-0'>Mohon gunakan <strong>username</strong> yang lain!</p>";
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

                            <form class="row" action="<?= $base_url ?>/actRegister" method="POST" data-parsley-validate="">

                                <div class="col-md-6 my-1">
                                    <label for="nama_lgkp" class="form-label">Nama Lengkap</label>
                                    <input class="form-control" type="text" id="nama_lgkp" name="in_nama_lgkp" placeholder="Masukkan nama lengkap anda..." required="">
                                </div>

                                <div class="col-md-6 my-1">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email" id="email" name="in_email" placeholder="Masukkan Email anda..." required="">
                                </div>

                                <div class="col-md-12 my-1">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="in_username" placeholder="Cth: arpateam15" minlength="5" maxlength="20" onkeyup="this.value=this.value.replace(/[^a-z][^0-9]/g,'');" placeholder="Masukkan username anda..." required="">
                                </div>

                                <!-- Password -->
                                <div class="col-md-6 my-1">
                                    <label class="font-weight-bold" for="pass">Password <span id="buttonShowPassword" onclick="showPassword()"><i class="fas fa-eye-slash"></i></span></label>
                                    <input type="password" id="pass" name="in_password" class="form-control" placeholder="Masukkan Password anda..." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="10" maxlength="20" required>
                                    <div class="p-1" role="alert">
                                        <h5 class="font-weight-bold text-warning"><i class="fas fa-exclamation-circle"></i> Ketentuan Password:</h5>

                                        <span id="length" class="invalid">Minimal <strong>10 Karakter</strong>
                                        </span>
                                        <br />
                                        <span id="letter" class="invalid">Kombinasi <strong>huruf kecil</strong></span>
                                        <br />
                                        <span id="capital" class="invalid">Kombinasi <strong>huruf besar</strong></span>
                                        <br />
                                        <span id="number" class="invalid">Kombinasi <strong>angka</strong>
                                        </span>
                                        <br />
                                    </div>
                                </div>
                                <!-- Password -->

                                <!-- Ulangi Password -->
                                <div class="col-md-6 my-1">
                                    <label class="font-weight-bold" for="passUlangi">Ulangi Password <span id="buttonShowUlangiPassword" onclick="showUlangiPassword()"><i class="fas fa-eye-slash"></i></span></label>
                                    <input type="password" id="passUlangi" name="in_ulangi_password" class="form-control" placeholder="Ulangi Password anda..." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="10" maxlength="20" required>
                                    <div class="form-text confirm-message p-1"></div>
                                </div>
                                <!-- Ulangi Password -->

                                <!-- <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div> -->

                                <!-- <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="<?= $site_key_reCAPTCHA ?>" required></div>
                                </div> -->

                                <div class="my-3 d-grid text-center">
                                    <button class="btn btn-lg btn-success" type="submit" name="_submit_">Daftar <span class="mdi mdi-pencil-box-multiple"></span></button>
                                    <span class="my-2">Sudah punya akun?</span>
                                    <a href="<?= $base_url ?>" title="Login Akun" class="btn btn-sm btn-secondary">Log In <span class="mdi mdi-login-variant"></span></a>
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
    <script src="<?= $base_url ?>/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/feather-icons/feather.min.js"></script>

    <!-- Plugin js-->
    <script src="<?= $base_url ?>/assets/libs/parsleyjs/parsley.min.js"></script>

    <!-- Validation init js-->
    <script src="<?= $base_url ?>/assets/js/pages/form-validation.init.js"></script>

    <!-- App js -->
    <script src="<?= $base_url ?>/assets/js/app.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/validation-pass-arpateam/js/validation.js"></script>

    <!-- Show Password -->
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
        function showUlangiPassword() {

            // membuat variabel berisi tipe input dari id='passUlangi', id='passUlangi' adalah form input password 
            var x = document.getElementById('passUlangi').type;

            //membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
            if (x == 'password') {

                //ubah form input password menjadi text
                document.getElementById('passUlangi').type = 'text';
                
                //ubah icon mata terbuka menjadi tertutup
                document.getElementById('buttonShowUlangiPassword').innerHTML = `<i class="fas fa-eye"></i>`;
            }else{

                //ubah form input password menjadi text
                document.getElementById('passUlangi').type = 'password';

                //ubah icon mata terbuka menjadi tertutup
                document.getElementById('buttonShowUlangiPassword').innerHTML = `<i class="fas fa-eye-slash"></i>`;
            }
        }
    </script>
    <!-- Show Password -->
    
</body>
</html>