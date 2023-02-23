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
    }elseif((isset($_POST['_submit_'])) OR ($_GET['act']==="reset-dokumen")){
        require '../Libraries/others.php';
        require "../Libraries/fungsi_upload_gambar.php";
        require "../Libraries/fungsi_form.php";

        switch ($_GET['act']) {
            case "edit-identitas":
                // Data file
                $database   = "identitas_user";
                $database2  = "data_user";
                // Data file

                $id_data_user       = $_POST['in_id_data_user'];
                $nik                = htmlspecialchars($_POST['in_nik']);
                $nama_lgkp          = htmlspecialchars($_POST['in_nama_lgkp']);
                $alamat_lgkp        = htmlspecialchars($_POST['in_alamat_lgkp']);
                $tmpt_lhr           = htmlspecialchars($_POST['in_tmpt_lhr']);
                $tgl_lhr            = htmlspecialchars($_POST['in_tgl_lhr']);
                $email              = htmlspecialchars($_POST['in_email']);
                $no_hp              = htmlspecialchars($_POST['in_no_hp']);
                $jk                 = htmlspecialchars($_POST['in_jk']);
                $stts_perkawinan    = htmlspecialchars($_POST['in_stts_perkawinan']);
                $agama              = htmlspecialchars($_POST['in_agama']);
                $pend_trkhr         = htmlspecialchars($_POST['in_pend_trkhr']);
                $jurusan            = htmlspecialchars($_POST['in_jurusan']);

                $session            = NULL;
                $status_identitas   = "Ada";

                $seo                = seo($nama_lgkp." ".rand(100,999));

                if ($seo===$_POST['in_slug_lama']) {
                    $slug   = $_POST['in_slug_lama'];
                }else{
                    $slug   = $seo;
                    cekSlug($database2, $slug);
                }

                try {
                    $sql = "UPDATE $database
                            SET nik             = :nik,
                                nama_lgkp       = :nama_lgkp,
                                alamat_lgkp     = :alamat_lgkp,
                                tmpt_lhr        = :tmpt_lhr,
                                tgl_lhr         = :tgl_lhr,
                                email           = :email,
                                no_hp           = :no_hp,
                                jk              = :jk,
                                stts_perkawinan = :stts_perkawinan,
                                agama           = :agama,
                                pend_trkhr      = :pend_trkhr,
                                jurusan         = :jurusan
                            WHERE id_$database2 = :id_data_user
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_data_user", $id_data_user, PDO::PARAM_INT);
                    $statement->bindParam(":nik", $nik, PDO::PARAM_STR);
                    $statement->bindParam(":nama_lgkp", $nama_lgkp, PDO::PARAM_STR);
                    $statement->bindParam(":alamat_lgkp", $alamat_lgkp, PDO::PARAM_STR);
                    $statement->bindParam(":tmpt_lhr", $tmpt_lhr, PDO::PARAM_STR);
                    $statement->bindParam(":tgl_lhr", $tgl_lhr, PDO::PARAM_STR);
                    $statement->bindParam(":email", $email, PDO::PARAM_STR);
                    $statement->bindParam(":no_hp", $no_hp, PDO::PARAM_STR);
                    $statement->bindParam(":jk", $jk, PDO::PARAM_STR);
                    $statement->bindParam(":stts_perkawinan", $stts_perkawinan, PDO::PARAM_STR);
                    $statement->bindParam(":agama", $agama, PDO::PARAM_STR);
                    $statement->bindParam(":pend_trkhr", $pend_trkhr, PDO::PARAM_STR);
                    $statement->bindParam(":jurusan", $jurusan, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        try {  
                            $sql2 = "UPDATE $database2
                                    SET status_identitas    = :status_identitas,
                                        slug                = :slug,
                                        session             = :session
                                    WHERE id_$database2     = :id_data_user
                                ";
                                          
                            $statement2 = $pdo->prepare($sql2);

                            $statement2->bindParam(":id_data_user", $id_data_user, PDO::PARAM_INT);
                            $statement2->bindParam(":status_identitas", $status_identitas, PDO::PARAM_STR);
                            $statement2->bindParam(":slug", $slug, PDO::PARAM_STR);
                            $statement2->bindParam(":session", $session, PDO::PARAM_STR);

                            $count2 = $statement2->execute();

                            if ($count2>0) {
                                echo "<script>window.location = '$base_url/keluar-edit'</script>";
                                die();
                                exit();
                            }
                        }catch(PDOException $e){
                            $_SESSION['_msg__']  = "Gagal";
                            echo "<script>window.location(history.back(0))</script>";
                            die();
                            exit();
                        }
                    }
                }catch(PDOException $e){
                    $_SESSION['_msg__']  = "Gagal";
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                break;
            
            case "edit-dokumen":
                // Data file
                $penyimpananGambar  = "../../assets/files/images/avatar";
                $penyimpananDokumen = "../../assets/files/others/dokumen";
                $database           = "dokumen_user";
                $database2          = "data_user";
                // Data file

                $id_data_user       = $_POST['in_id_data_user'];
                $username           = $_POST['in_username'];
                $nama_lgkp          = $_POST['in_nama_lgkp'];

                $session            = NULL;
                $status_dokumen     = "Ada";

                // surat_lamaran
                    $lokasi_filesurat_lamaran    = $_FILES['in_surat_lamaran']['tmp_name'];
                    $lokasi_uploadsurat_lamaran  = "$penyimpananDokumen/";
                    $nama_filesurat_lamaran      = $_FILES['in_surat_lamaran']['name'];
                    $tipe_filesurat_lamaran      = strtolower(pathinfo($nama_filesurat_lamaran,PATHINFO_EXTENSION));
                    $ukuransurat_lamaran         = $_FILES['in_surat_lamaran']['size'];
                    $nama_filesurat_lamaran_unik = seo($username)."-".seo($nama_lgkp)."-".seo("Surat Lamaran").".".$tipe_filesurat_lamaran;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_filesurat_lamaran);
                    // Cek jenis file yang di upload

                    // Cek ukuransurat_lamaran file yang di upload
                    cekUkuranFile2mb($ukuransurat_lamaran);
                    // Cek ukuransurat_lamaran file yang di upload

                    $surat_lamaran = $nama_filesurat_lamaran_unik;
                // surat_lamaran

                // cv
                    $lokasi_filecv    = $_FILES['in_cv']['tmp_name'];
                    $lokasi_uploadcv  = "$penyimpananDokumen/";
                    $nama_filecv      = $_FILES['in_cv']['name'];
                    $tipe_filecv      = strtolower(pathinfo($nama_filecv,PATHINFO_EXTENSION));
                    $ukurancv         = $_FILES['in_cv']['size'];
                    $nama_filecv_unik = seo($username)."-".seo($nama_lgkp)."-".seo("CV").".".$tipe_filecv;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_filecv);
                    // Cek jenis file yang di upload

                    // Cek ukurancv file yang di upload
                    cekUkuranFile2mb($ukurancv);
                    // Cek ukurancv file yang di upload

                    $cv = $nama_filecv_unik;
                // cv

                // Gambar
                    $lokasi_fileFOTO    = $_FILES['in_gambar']['tmp_name'];
                    $lokasi_uploadFOTO  = "$penyimpananGambar/";
                    $nama_fileFOTO      = $_FILES['in_gambar']['name'];
                    $tipe_fileFOTO      = strtolower($_FILES['in_gambar']['type']);
                    $tipe_fileFOTO2     = seo2($tipe_fileFOTO); // ngedapetin png / jpg / jpeg
                    $ukuranFoto         = $_FILES['in_gambar']['size'];
                    $nama_fileFOTO_unik = seo($username)."-".seo($nama_lgkp)."-".seo("Foto 3x4").".".$tipe_fileFOTO2;

                    // Cek jenis file yang di upload
                    cekFile($tipe_fileFOTO);
                    // Cek jenis file yang di upload

                    // Cek ukuranFoto file yang di upload
                    cekUkuranFile2mb($ukuranFoto);
                    // Cek ukuranFoto file yang di upload

                    $foto3x4 = $nama_fileFOTO_unik;
                // Gambar

                // ktam
                    $lokasi_filektam    = $_FILES['in_ktam']['tmp_name'];
                    $lokasi_uploadktam  = "$penyimpananDokumen/";
                    $nama_filektam      = $_FILES['in_ktam']['name'];
                    $tipe_filektam      = strtolower(pathinfo($nama_filektam,PATHINFO_EXTENSION));
                    $ukuranktam         = $_FILES['in_ktam']['size'];
                    $nama_filektam_unik = seo($username)."-".seo($nama_lgkp)."-".seo("KTAM").".".$tipe_filektam;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_filektam);
                    // Cek jenis file yang di upload

                    // Cek ukuranktam file yang di upload
                    cekUkuranFile2mb($ukuranktam);
                    // Cek ukuranktam file yang di upload

                    $ktam = $nama_filektam_unik;
                // ktam

                // ktp
                    $lokasi_filektp    = $_FILES['in_ktp']['tmp_name'];
                    $lokasi_uploadktp  = "$penyimpananDokumen/";
                    $nama_filektp      = $_FILES['in_ktp']['name'];
                    $tipe_filektp      = strtolower(pathinfo($nama_filektp,PATHINFO_EXTENSION));
                    $ukuranktp         = $_FILES['in_ktp']['size'];
                    $nama_filektp_unik = seo($username)."-".seo($nama_lgkp)."-".seo("KTP").".".$tipe_filektp;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_filektp);
                    // Cek jenis file yang di upload

                    // Cek ukuranktp file yang di upload
                    cekUkuranFile2mb($ukuranktp);
                    // Cek ukuranktp file yang di upload

                    $ktp = $nama_filektp_unik;
                // ktp

                // sks
                    $lokasi_filesks    = $_FILES['in_sks']['tmp_name'];
                    $lokasi_uploadsks  = "$penyimpananDokumen/";
                    $nama_filesks      = $_FILES['in_sks']['name'];
                    $tipe_filesks      = strtolower(pathinfo($nama_filesks,PATHINFO_EXTENSION));
                    $ukuransks         = $_FILES['in_sks']['size'];
                    $nama_filesks_unik = seo($username)."-".seo($nama_lgkp)."-".seo("Surat Keterangan Sehat").".".$tipe_filesks;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_filesks);
                    // Cek jenis file yang di upload

                    // Cek ukuransks file yang di upload
                    cekUkuranFile2mb($ukuransks);
                    // Cek ukuransks file yang di upload

                    $sks = $nama_filesks_unik;
                // sks

                // skck
                    $lokasi_fileskck    = $_FILES['in_skck']['tmp_name'];
                    $lokasi_uploadskck  = "$penyimpananDokumen/";
                    $nama_fileskck      = $_FILES['in_skck']['name'];
                    $tipe_fileskck      = strtolower(pathinfo($nama_fileskck,PATHINFO_EXTENSION));
                    $ukuranskck         = $_FILES['in_skck']['size'];
                    $nama_fileskck_unik = seo($username)."-".seo($nama_lgkp)."-".seo("SKCK").".".$tipe_fileskck;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_fileskck);
                    // Cek jenis file yang di upload

                    // Cek ukuranskck file yang di upload
                    cekUkuranFile2mb($ukuranskck);
                    // Cek ukuranskck file yang di upload

                    $skck = $nama_fileskck_unik;
                // skck

                // ijazah
                    $lokasi_fileijazah    = $_FILES['in_ijazah']['tmp_name'];
                    $lokasi_uploadijazah  = "$penyimpananDokumen/";
                    $nama_fileijazah      = $_FILES['in_ijazah']['name'];
                    $tipe_fileijazah      = strtolower(pathinfo($nama_fileijazah,PATHINFO_EXTENSION));
                    $ukuranijazah         = $_FILES['in_ijazah']['size'];
                    $nama_fileijazah_unik = seo($username)."-".seo($nama_lgkp)."-".seo("Ijazah Terakhir").".".$tipe_fileijazah;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_fileijazah);
                    // Cek jenis file yang di upload

                    // Cek ukuranijazah file yang di upload
                    cekUkuranFile2mb($ukuranijazah);
                    // Cek ukuranijazah file yang di upload

                    $ijazah = $nama_fileijazah_unik;
                // ijazah

                // transkrip_nilai
                    $lokasi_filetranskrip_nilai    = $_FILES['in_transkrip_nilai']['tmp_name'];
                    $lokasi_uploadtranskrip_nilai  = "$penyimpananDokumen/";
                    $nama_filetranskrip_nilai      = $_FILES['in_transkrip_nilai']['name'];
                    $tipe_filetranskrip_nilai      = strtolower(pathinfo($nama_filetranskrip_nilai,PATHINFO_EXTENSION));
                    $ukurantranskrip_nilai         = $_FILES['in_transkrip_nilai']['size'];
                    $nama_filetranskrip_nilai_unik = seo($username)."-".seo($nama_lgkp)."-".seo("Transkrip Nilai").".".$tipe_filetranskrip_nilai;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_filetranskrip_nilai);
                    // Cek jenis file yang di upload

                    // Cek ukurantranskrip_nilai file yang di upload
                    cekUkuranFile2mb($ukurantranskrip_nilai);
                    // Cek ukurantranskrip_nilai file yang di upload

                    $transkrip_nilai = $nama_filetranskrip_nilai_unik;
                // transkrip_nilai

                // sertifikat_pendukung
                    $lokasi_filesertifikat_pendukung    = $_FILES['in_sertifikat_pendukung']['tmp_name'];
                    $lokasi_uploadsertifikat_pendukung  = "$penyimpananDokumen/";
                    $nama_filesertifikat_pendukung      = $_FILES['in_sertifikat_pendukung']['name'];
                    $tipe_filesertifikat_pendukung      = strtolower(pathinfo($nama_filesertifikat_pendukung,PATHINFO_EXTENSION));
                    $ukuransertifikat_pendukung         = $_FILES['in_sertifikat_pendukung']['size'];
                    $nama_filesertifikat_pendukung_unik = seo($username)."-".seo($nama_lgkp)."-".seo("Sertifikat Pendukung").".".$tipe_filesertifikat_pendukung;

                    // Cek jenis file yang di upload
                    cekFilePDF($tipe_filesertifikat_pendukung);
                    // Cek jenis file yang di upload

                    // Cek ukuransertifikat_pendukung file yang di upload
                    cekUkuranFile2mb($ukuransertifikat_pendukung);
                    // Cek ukuransertifikat_pendukung file yang di upload

                    $sertifikat_pendukung = $nama_filesertifikat_pendukung_unik;
                // sertifikat_pendukung

                try {
                    $sql = "UPDATE $database
                            SET surat_lamaran           = :surat_lamaran,
                                cv                      = :cv,
                                foto3x4                 = :foto3x4,
                                ktam                    = :ktam,
                                ktp                     = :ktp,
                                sks                     = :sks,
                                skck                    = :skck,
                                ijazah                  = :ijazah,
                                transkrip_nilai         = :transkrip_nilai,
                                sertifikat_pendukung    = :sertifikat_pendukung
                            WHERE id_$database2 = :id_data_user
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_data_user", $id_data_user, PDO::PARAM_INT);
                    $statement->bindParam(":surat_lamaran", $surat_lamaran, PDO::PARAM_STR);
                    $statement->bindParam(":cv", $cv, PDO::PARAM_STR);
                    $statement->bindParam(":foto3x4", $foto3x4, PDO::PARAM_STR);
                    $statement->bindParam(":ktam", $ktam, PDO::PARAM_STR);
                    $statement->bindParam(":ktp", $ktp, PDO::PARAM_STR);
                    $statement->bindParam(":sks", $sks, PDO::PARAM_STR);
                    $statement->bindParam(":skck", $skck, PDO::PARAM_STR);
                    $statement->bindParam(":ijazah", $ijazah, PDO::PARAM_STR);
                    $statement->bindParam(":transkrip_nilai", $transkrip_nilai, PDO::PARAM_STR);
                    $statement->bindParam(":sertifikat_pendukung", $sertifikat_pendukung, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        try {  
                            $sql2 = "UPDATE $database2
                                    SET status_dokumen      = :status_dokumen,
                                        session             = :session
                                    WHERE id_$database2     = :id_data_user
                                ";
                                          
                            $statement2 = $pdo->prepare($sql2);

                            $statement2->bindParam(":id_data_user", $id_data_user, PDO::PARAM_INT);
                            $statement2->bindParam(":status_dokumen", $status_dokumen, PDO::PARAM_STR);
                            $statement2->bindParam(":session", $session, PDO::PARAM_STR);

                            $count2 = $statement2->execute();

                            if ($count2>0) {
                                // Upload file
                                    uploadGambarAsli($nama_filesurat_lamaran_unik, $tipe_filesurat_lamaran, $lokasi_filesurat_lamaran, $lokasi_uploadsurat_lamaran);
                                    uploadGambarAsli($nama_filecv_unik, $tipe_filecv, $lokasi_filecv, $lokasi_uploadcv);
                                    uploadGambarAsli($nama_fileFOTO_unik, $tipe_fileFOTO, $lokasi_fileFOTO, $lokasi_uploadFOTO);
                                    uploadGambarAsli($nama_filektam_unik, $tipe_filektam, $lokasi_filektam, $lokasi_uploadktam);
                                    uploadGambarAsli($nama_filektp_unik, $tipe_filektp, $lokasi_filektp, $lokasi_uploadktp);
                                    uploadGambarAsli($nama_filesks_unik, $tipe_filesks, $lokasi_filesks, $lokasi_uploadsks);
                                    uploadGambarAsli($nama_fileskck_unik, $tipe_fileskck, $lokasi_fileskck, $lokasi_uploadskck);
                                    uploadGambarAsli($nama_fileijazah_unik, $tipe_fileijazah, $lokasi_fileijazah, $lokasi_uploadijazah);
                                    uploadGambarAsli($nama_filetranskrip_nilai_unik, $tipe_filetranskrip_nilai, $lokasi_filetranskrip_nilai, $lokasi_uploadtranskrip_nilai);
                                    uploadGambarAsli($nama_filesertifikat_pendukung_unik, $tipe_filesertifikat_pendukung, $lokasi_filesertifikat_pendukung, $lokasi_uploadsertifikat_pendukung);
                                // Upload file
                                echo "<script>window.location = '$base_url/keluar-edit'</script>";
                                die();
                                exit();
                            }
                        }catch(PDOException $e){
                            $_SESSION['_msg__']  = "Gagal";
                            echo "<script>window.location(history.back(0))</script>";
                            die();
                            exit();
                        }
                    }
                }catch(PDOException $e){
                    $_SESSION['_msg__']  = "Gagal";
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                break;

            case "reset-dokumen":
                // Data file
                $penyimpananGambar  = "../../assets/files/images/avatar";
                $penyimpananDokumen = "../../assets/files/others/dokumen";
                $database           = "dokumen_user";
                $database2          = "data_user";
                // Data file

                $id_data_user       = $_SESSION['_id_data_user__'];

                $session            = NULL;
                $status_dokumen     = "Kosong";

                try {
                    $stmt   = $pdo->prepare("
                        SELECT *
                        FROM $database
                        WHERE id_data_user = ? ");

                    $stmt->bindValue(1, $id_data_user);
                    $stmt->execute();
                    $rows   = $stmt->rowCount();

                    if ($rows>0) {
                        $result     = $stmt->fetch(PDO::FETCH_ASSOC);
                    }else{
                        echo "<script>window.location.href = '$base_url/dashboard';</script>";
                        die();
                        exit();
                    }
                } catch (Exception $e) {
                    var_dump($e);
                    exit();
                }

                unlink("$penyimpananDokumen/$result[surat_lamaran]");
                unlink("$penyimpananDokumen/$result[cv]");
                unlink("$penyimpananGambar/$result[foto3x4]");
                unlink("$penyimpananDokumen/$result[ktam]");
                unlink("$penyimpananDokumen/$result[ktp]");
                unlink("$penyimpananDokumen/$result[sks]");
                unlink("$penyimpananDokumen/$result[skck]");
                unlink("$penyimpananDokumen/$result[ijazah]");
                unlink("$penyimpananDokumen/$result[transkrip_nilai]");
                unlink("$penyimpananDokumen/$result[sertifikat_pendukung]");

                $surat_lamaran          = NULL;
                $cv                     = NULL;
                $foto3x4                = NULL;
                $ktam                   = NULL;
                $ktp                    = NULL;
                $sks                    = NULL;
                $skck                   = NULL;
                $ijazah                 = NULL;
                $transkrip_nilai        = NULL;
                $sertifikat_pendukung   = NULL;

                try {
                    $sql = "UPDATE $database
                            SET surat_lamaran           = :surat_lamaran,
                                cv                      = :cv,
                                foto3x4                 = :foto3x4,
                                ktam                    = :ktam,
                                ktp                     = :ktp,
                                sks                     = :sks,
                                skck                    = :skck,
                                ijazah                  = :ijazah,
                                transkrip_nilai         = :transkrip_nilai,
                                sertifikat_pendukung    = :sertifikat_pendukung
                            WHERE id_$database2 = :id_data_user
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_data_user", $id_data_user, PDO::PARAM_INT);
                    $statement->bindParam(":surat_lamaran", $surat_lamaran, PDO::PARAM_STR);
                    $statement->bindParam(":cv", $cv, PDO::PARAM_STR);
                    $statement->bindParam(":foto3x4", $foto3x4, PDO::PARAM_STR);
                    $statement->bindParam(":ktam", $ktam, PDO::PARAM_STR);
                    $statement->bindParam(":ktp", $ktp, PDO::PARAM_STR);
                    $statement->bindParam(":sks", $sks, PDO::PARAM_STR);
                    $statement->bindParam(":skck", $skck, PDO::PARAM_STR);
                    $statement->bindParam(":ijazah", $ijazah, PDO::PARAM_STR);
                    $statement->bindParam(":transkrip_nilai", $transkrip_nilai, PDO::PARAM_STR);
                    $statement->bindParam(":sertifikat_pendukung", $sertifikat_pendukung, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        try {  
                            $sql2 = "UPDATE $database2
                                    SET status_dokumen      = :status_dokumen,
                                        session             = :session
                                    WHERE id_$database2     = :id_data_user
                                ";
                                          
                            $statement2 = $pdo->prepare($sql2);

                            $statement2->bindParam(":id_data_user", $id_data_user, PDO::PARAM_INT);
                            $statement2->bindParam(":status_dokumen", $status_dokumen, PDO::PARAM_STR);
                            $statement2->bindParam(":session", $session, PDO::PARAM_STR);

                            $count2 = $statement2->execute();

                            if ($count2>0) {
                                echo "<script>window.location = '$base_url/keluar-edit'</script>";
                                die();
                                exit();
                            }
                        }catch(PDOException $e){
                            $_SESSION['_msg__']  = "Gagal";
                            echo "<script>window.location(history.back(0))</script>";
                            die();
                            exit();
                        }
                    }
                }catch(PDOException $e){
                    $_SESSION['_msg__']  = "Gagal";
                    echo "<script>window.location(history.back(0))</script>";
                    die();
                    exit();
                }

                break;

            case "edit-keamanan-akun":
                // Data file
                $database   = "data_user";
                // Data file

                $id_data_user       = $_POST['in_id_data_user'];

                $password           = htmlspecialchars($_POST['in_password']);
                $ulangi_password    = htmlspecialchars($_POST['in_ulangi_password']);

                $session            = NULL;

                if ($password!=$ulangi_password) {
                    $_SESSION['_msg__'] = 'Gagal';
                    echo "<script>window.location(history.back(0))</script>";
                    exit();
                }else{
                    $password_enkrip    = password_hash($password, PASSWORD_DEFAULT);
                }

                try {
                    $sql = "UPDATE $database
                            SET password        = :password,
                                session         = :session
                            WHERE id_data_user  = :id_data_user
                        ";
                                  
                    $statement = $pdo->prepare($sql);

                    $statement->bindParam(":id_data_user", $id_data_user, PDO::PARAM_STR);
                    $statement->bindParam(":password", $password_enkrip, PDO::PARAM_STR);
                    $statement->bindParam(":session", $session, PDO::PARAM_STR);

                    $count = $statement->execute();

                    if ($count>0) {
                        $_SESSION['_msg__']  = "Berhasil";
                        echo "<script>window.location = '$base_url/keluar-edit'</script>";
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
                header("location: $base_url/keluar-edit");
                die();
                exit();
        }
    }else{
        header("location: $base_url/keluar-edit");
        die();
        exit();
    }