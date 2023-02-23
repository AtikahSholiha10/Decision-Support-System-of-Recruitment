<?php
    // error_reporting(E_ALL);
    require "appweb/Config/SetWebsite.php";
    require "appweb/Config/Db.php";
    require "appweb/Config/AssetsWebsite.php";
    require 'appweb/Libraries/others.php';

    session_start();

    if (empty($_SESSION['_session__'])) {
        header("location: $base_url/keluar-edit");
        die();
        exit();
    }else{
        try{
            $stmtS  = $pdo->prepare("
                        SELECT id_data_user
                        FROM data_user
                        WHERE session = ?");

            $stmtS->bindValue(1, $_SESSION['_session__']);
            $stmtS->execute();
            $rowsS  = $stmtS->rowCount();

            if ($rowsS==0) {
                header("location: $base_url/keluar-edit");
                die();
                exit();
            }
        }catch(Exception $e) {
            var_dump($e);
            exit();
            die();
        }
    }

    if ($_SESSION['_msg__']==="Gagal") {
        $_SESSION['_alert__']   = 0;
        $_SESSION['_msg__']     = NULL;
    }elseif ($_SESSION['_msg__']==="Berhasil") {
        $_SESSION['_alert__']   = 1;
        $_SESSION['_msg__']     = NULL;
    }elseif ($_SESSION['_msg__']==="FromLogin") {
        $_SESSION['_alert__']   = 2;
        $_SESSION['_msg__']     = NULL;
    }elseif ($_SESSION['_msg__']==="cekFile") {
        $_SESSION['_alert__']   = 3;
        $_SESSION['_msg__']     = NULL;
    }elseif ($_SESSION['_msg__']==="CekSize") {
        $_SESSION['_alert__']   = 3;
        $_SESSION['_msg__']     = NULL;
    }elseif ($_SESSION['_msg__']==="GagalSlug") {
        $_SESSION['_alert__']   = 4;
        $_SESSION['_msg__']     = NULL;
    }elseif ($_SESSION['_msg__']==="PasswordTidakSama") {
        $_SESSION['_alert__']   = 5;
        $_SESSION['_msg__']     = NULL;
    }elseif ($_SESSION['_msg__']==="BerhasilLamar") {
        $_SESSION['_alert__']   = 6;
        $_SESSION['_msg__']     = NULL;
    }elseif ($_SESSION['_msg__']==="GagalLamar") {
        $_SESSION['_alert__']   = 7;
        $_SESSION['_msg__']     = NULL;
    }else{
        $_SESSION['_alert__']   = NULL;
        $_SESSION['_msg__']     = NULL;
    }

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title><?= $_GET['module'] ?> - Portal User <?= $_SESSION['_nama_lgkp__'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Coderthemes" name="#ARPATEAM" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $url_images; ?>/<?= $icon; ?>" />

    <!-- icons -->
    <link href="<?= $base_url ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?= $base_url ?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?= $base_url ?>/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- App-dark css -->
    <link href="<?= $base_url ?>/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled"/>
    <link href="<?= $base_url ?>/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled"/>

    <!-- Plugins CSS-->
        <!-- All Pages Sweet Alerts js -->
        <link href="<?= $base_url_admin ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <!-- End All Pages Sweet Alerts js -->

        <link href="<?= $base_url_admin ?>/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $base_url_admin ?>/assets/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?= $base_url_admin ?>/assets/libs/validation-pass-arpateam/css/style.css">

        <link href="<?= $base_url_admin ?>/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

        <link href="<?= $base_url_admin ?>/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $base_url_admin ?>/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $base_url_admin ?>/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $base_url_admin ?>/assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!-- Plugins CSS-->

    <base href="<?= $base_url; ?>/">
</head>
<!-- body start -->
<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "brand", "size": "default", "showuser": true}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Topbar Start -->
        <?php require "appweb/Models/Header.php"; ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php require "appweb/Models/Menu.php"; ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
     
        <div class="content-page">
            <!-- content -->
            <?php require "appweb/Controllers/Contents.php"; ?>
            <!-- End content -->

            <!-- Footer Start -->
            <?php require "appweb/Models/Footer.php"; ?>
            <!-- end Footer -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="<?= $base_url ?>/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?= $base_url ?>/assets/libs/feather-icons/feather.min.js"></script>
    
    <!-- App js-->
    <script src="<?= $base_url ?>/assets/js/app.min.js"></script>

    <!-- Plugins js-->
        <script src="<?= $base_url_admin ?>/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/parsleyjs/parsley.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/dropzone/min/dropzone.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/dropify/js/dropify.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/js/pages/form-fileuploads.init.js"></script>
        <script src="<?= $base_url_admin ?>/assets/js/pages/form-validation.init.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/validation-pass-arpateam/js/validation.js"></script>

        <script src="<?= $base_url_admin ?>/assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/dropzone/min/dropzone.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/dropify/js/dropify.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/js/pages/form-fileuploads.init.js"></script>
        <script src="<?= $base_url_admin ?>/assets/js/pages/form-validation.init.js"></script>

        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="<?= $base_url_admin ?>/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>

        <script>
            "use strict";
            $(document).ready(function () {
                $("#datatable").DataTable({"order": []});
                var a = $("#datatable-buttons").DataTable({ lengthChange: !1, buttons: ["copy", "excel", "pdf"] });
                $("#key-table").DataTable({ keys: !0 }),
                    $("#responsive-datatable").DataTable({"order": []}),
                    $("#selection-datatable").DataTable({ select: { style: "multi" } }),
                    a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
                    $("#datatable_length select[name*='datatable_length']").addClass("form-select form-select-sm"),
                    $("#datatable_length select[name*='datatable_length']").removeClass("custom-select custom-select-sm"),
                    $(".dataTables_length label").addClass("form-label");
            });
        </script>

        <script>
            "use strict";
            !(function (t) {
                function e() {}
                (e.prototype.init = function () {
                    t("#tgl_lhr").flatpickr();
                }),
                    (t.FormPickers = new e()),
                    (t.FormPickers.Constructor = e);
            })(window.jQuery),
                window.jQuery.FormPickers.init();

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
        
        <script>
            function confirmLamar(enkripsi) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah anda yakin ingin Melamar Pekerjaan ini?',
                    text: "Data identitas & dokumen anda akan otomatis terkirim!",
                    showDenyButton: true,
                    confirmButtonText: 'Ya, Kirim Lamaran',
                    denyButtonText: 'Batal',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location = "<?= $base_url ?>/actionLamaran/" + enkripsi;
                    } else if (result.isDenied) {
                        Swal.fire('Tidak jadi melamar', '', 'info')
                    }
                })
            }
        </script>


        <?php if ($_SESSION['_alert__']===0): ?>
            <script>
                Swal.fire({ title: "GAGAL!", text: "Sistem tidak dapat memproses permintaan anda. Silahkan coba lagi!", icon: "error" });
            </script>
        <?php elseif ($_SESSION['_alert__']===1): ?>
            <script>
                Swal.fire({ title: "BERHASIL!", text: "Permintaan anda berhasil di proses oleh sistem!", icon: "success" });
            </script>
        <?php elseif ($_SESSION['_alert__']===2): ?>
            <script>
                Swal.fire({ title: "Hai <?= $_SESSION['_nama__'] ?>", text: "Jangan lupa semangat untuk hari ini!", icon: "info" });
            </script>
        <?php elseif ($_SESSION['_alert__']===3): ?>
            <script>
                Swal.fire({ title: "GAGAL!", text: "Sistem tidak dapat mengupload file anda! File anda terlalu besar atau file anda tidak dapat diterima oleh sistem kami! Mohon ulangi lagi!", icon: "error" });
            </script>
        <?php elseif ($_SESSION['_alert__']===4): ?>
            <script>
                Swal.fire({ title: "GAGAL!", text: "Pengaturan Slug error! Mohon ulangi kembali!", icon: "error" });
            </script>
        <?php elseif ($_SESSION['_alert__']===5): ?>
            <script>
                Swal.fire({ title: "GAGAL!", text: "Mohon masukkan password anda kembali!", icon: "error" });
            </script>
        <?php elseif ($_SESSION['_alert__']===6): ?>
            <script>
                Swal.fire({ title: "BERHASIL!", text: "Anda telah berhasil melamar untuk Pekerjaan ini!", icon: "success" });
            </script>
        <?php elseif ($_SESSION['_alert__']===7): ?>
            <script>
                Swal.fire({ title: "GAGAL MELAMAR!", text: "Anda sudah melamar untuk Pekerjaan ini!", icon: "error" });
            </script>
        <?php endif ?>
    <!-- Plugins js-->
    
</body>
</html>