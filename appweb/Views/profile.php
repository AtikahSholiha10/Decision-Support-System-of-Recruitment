<?php

    switch ($_GET['act']) {
        case "identitas":
            $hal        = "Profil";
            $hal2       = "Identitas";
            $database   = "data_user";
            $database2  = "identitas_user";
            $database3  = "dokumen_user";
            $link       = "profil";

            try {
                $stmt   = $pdo->prepare("
                    SELECT slug
                    FROM $database
                    WHERE id_data_user = ? ");

                $stmt->bindValue(1, $_SESSION['_id_data_user__']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    try {
                        $stmt2   = $pdo->prepare("
                            SELECT *
                            FROM $database2
                            WHERE id_data_user = ? ");

                        $stmt2->bindValue(1, $_SESSION['_id_data_user__']);
                        $stmt2->execute();
                        $rows2   = $stmt2->rowCount();

                        if ($rows2>0) {
                            $result     = $stmt->fetch(PDO::FETCH_ASSOC);
                            $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                        }else{
                            echo "<script>window.location.href = '$base_url/dashboard';</script>";
                            die();
                            exit();
                        }
                    } catch (Exception $e) {
                        var_dump($e);
                        exit();
                    }
                }else{
                    echo "<script>window.location.href = '$base_url/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
                exit();
            }
            
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3><?= $result2['nama_lgkp'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><?= $hal ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $hal2 ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav flex-column nav-pills nav-pills-tab shadow-lg p-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <div class="d-flex justify-content-center">
                                        <img src="<?= $url_images ?>/avatar/<?= $_SESSION['_foto3x4__'] ?>" class="rounded-circle avatar-xl img-thumbnail" alt="Avatar <?= $result2['nama_lgkp'] ?>">
                                    </div>
                                    <div class="d-flex justify-content-center my-2">
                                        <h5 class="text-success"><strong>No. Pendaftaran:</strong> <?= $_SESSION['_id_data_user__'] ?></h5>
                                    </div>
                                    <a class="nav-link active show mb-1" href="<?= $base_url ?>/<?= $link ?>/identitas">
                                        <i class="fas fa-user-circle"></i> Identitas</a>
                                    <a class="nav-link mb-1" href="<?= $base_url ?>/<?= $link ?>/dokumen">
                                        <i class="fas fa-file-alt"></i> Dokumen</a>
                                    <a class="nav-link mb-1" href="<?= $base_url ?>/<?= $link ?>/keamanan">
                                        <i class="fas fa-lock"></i> Keamanan Akun</a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-9">
                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <form action="<?= $base_url ?>/editIdentitas" method="POST" data-parsley-validate="">
                                            <div class="row py-0">
                                                <?php if (($_SESSION['_status_identitas__']==="Kosong")): ?>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="alert alert-danger" role="alert">
                                                            <h3 class="alert-heading fw-bolder"><i class="fas fa-exclamation-triangle"></i> DATA IDENTITAS ANDA BELUM LENGKAP!</h3>
                                                            <p class="mb-0">Mohon lengkapi data anda terlebih dahulu agar bisa melamar pekerjaan disini!</p>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="alert alert-success" role="alert">
                                                            <h3 class="alert-heading fw-bolder"><i class="fas fa-check-circle"></i> DATA IDENTITAS ANDA SUDAH LENGKAP!</h3>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control" id="nik" name="in_nik" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['nik'] ?>" required="">
                                                        <label for="nik">NIK</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="nama_lgkp" name="in_nama_lgkp" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['nama_lgkp'] ?>" required="">
                                                        <label for="nama_lgkp">Nama Lengkap</label>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-2">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="in_alamat_lgkp" placeholder="Deskripsikan tentang diri anda..." style="min-height: 100px;" required=""><?= $result2['alamat_lgkp'] ?></textarea>
                                                        <label for="alamat_lgkp">Alamat Lengkap</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="tmpt_lhr" name="in_tmpt_lhr" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['tmpt_lhr'] ?>" required="">
                                                        <label for="tmpt_lhr">Tempat Lahir</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="tgl_lhr" name="in_tgl_lhr" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['tgl_lhr'] ?>" required="">
                                                        <label for="tgl_lhr">Tanggal Lahir</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <div class="form-floating">
                                                        <input type="email" class="form-control" id="email" name="in_email" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['email'] ?>" required="">
                                                        <label for="email">Email</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-floating">
                                                        <input type="tel" class="form-control" id="no_hp" name="in_no_hp" placeholder="Cth: 085701311015" pattern="^(0)8[1-9][0-9]{6,9}$" value="<?= $result2['no_hp'] ?>" required="">
                                                        <label for="no_hp">Nomor HP <small>(Cth: 085701311015)</small></label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-2">
                                                    <div class="form-floating">
                                                        <select class="form-select" id="jk" name="in_jk" required="">
                                                            <option value="Pria" <?php if ($result2['jk']==="Pria") { echo "selected"; } ?>>Pria</option>
                                                            <option value="Wanita" <?php if ($result2['jk']==="Wanita") { echo "selected"; } ?>>Wanita</option>
                                                        </select>
                                                        <label for="jk">Jenis Kelamin</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-floating">
                                                        <select class="form-select" id="stts_perkawinan" name="in_stts_perkawinan" required="">
                                                            <option value="Menikah" <?php if ($result2['stts_perkawinan']==="Menikah") { echo "selected"; } ?>>Menikah</option>
                                                            <option value="Belum Menikah" <?php if ($result2['stts_perkawinan']==="Belum Menikah") { echo "selected"; } ?>>Belum Menikah</option>
                                                        </select>
                                                        <label for="stts_perkawinan">Status Perkawinan</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-floating">
                                                        <select class="form-select" id="agama" name="in_agama" required="">
                                                            <option value="Islam" <?php if ($result2['agama']==="Islam") { echo "selected"; } ?>>Islam</option>
                                                            <option value="Kristen" <?php if ($result2['agama']==="Kristen") { echo "selected"; } ?>>Kristen</option>
                                                            <option value="Katolik" <?php if ($result2['agama']==="Katolik") { echo "selected"; } ?>>Katolik</option>
                                                            <option value="Hindu" <?php if ($result2['agama']==="Hindu") { echo "selected"; } ?>>Hindu</option>
                                                            <option value="Buddha" <?php if ($result2['agama']==="Buddha") { echo "selected"; } ?>>Buddha</option>
                                                            <option value="Konghucu" <?php if ($result2['agama']==="Konghucu") { echo "selected"; } ?>>Konghucu</option>
                                                        </select>
                                                        <label for="agama">Agama</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-2">
                                                    <div class="form-floating">
                                                        <select class="form-select" id="pend_trkhr" name="in_pend_trkhr" required="">
                                                            <option value="SMA" <?php if ($result2['pend_trkhr']==="SMA") { echo "selected"; } ?>>SMA</option>
                                                            <option value="SMK" <?php if ($result2['pend_trkhr']==="SMK") { echo "selected"; } ?>>SMK</option>
                                                            <option value="D2" <?php if ($result2['pend_trkhr']==="D2") { echo "selected"; } ?>>D2</option>
                                                            <option value="D3" <?php if ($result2['pend_trkhr']==="D3") { echo "selected"; } ?>>D3</option>
                                                            <option value="D4" <?php if ($result2['pend_trkhr']==="D4") { echo "selected"; } ?>>D4</option>
                                                            <option value="S1" <?php if ($result2['pend_trkhr']==="S1") { echo "selected"; } ?>>S1</option>
                                                            <option value="S2" <?php if ($result2['pend_trkhr']==="S2") { echo "selected"; } ?>>S2</option>
                                                        </select>
                                                        <label for="pend_trkhr">Pendidikan Terakhir</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 mb-2">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="jurusan" name="in_jurusan" placeholder="Cth: Aldi Febriyanto" value="<?= $result2['jurusan'] ?>" required="">
                                                        <label for="jurusan">Jurusan</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="in_id_data_user" value="<?= $result2['id_data_user']; ?>">
                                                <input type="hidden" name="in_slug_lama" value="<?= $result['slug']; ?>">
                                                <button type="submit" name="_submit_" class="btn btn-success waves-effect waves-light"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
            break;
        case "dokumen":
            $hal        = "Profil";
            $hal2       = "Dokumen";
            $database   = "data_user";
            $database2  = "identitas_user";
            $database3  = "dokumen_user";
            $link       = "profil";

            try {
                $stmt   = $pdo->prepare("
                    SELECT username, slug
                    FROM $database
                    WHERE id_data_user = ? ");

                $stmt->bindValue(1, $_SESSION['_id_data_user__']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    try {
                        $stmt2   = $pdo->prepare("
                            SELECT nama_lgkp
                            FROM $database2
                            WHERE id_data_user = ? ");

                        $stmt2->bindValue(1, $_SESSION['_id_data_user__']);
                        $stmt2->execute();
                        $rows2   = $stmt2->rowCount();

                        if ($rows2>0) {
                            try {
                                $stmt3   = $pdo->prepare("
                                    SELECT *
                                    FROM $database3
                                    WHERE id_data_user = ? ");

                                $stmt3->bindValue(1, $_SESSION['_id_data_user__']);
                                $stmt3->execute();
                                $rows3   = $stmt3->rowCount();

                                if ($rows3>0) {
                                    $result     = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $result2    = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    $result3    = $stmt3->fetch(PDO::FETCH_ASSOC);
                                }else{
                                    echo "<script>window.location.href = '$base_url/dashboard';</script>";
                                    die();
                                    exit();
                                }
                            } catch (Exception $e) {
                                var_dump($e);
                                exit();
                            }
                        }else{
                            echo "<script>window.location.href = '$base_url/dashboard';</script>";
                            die();
                            exit();
                        }
                    } catch (Exception $e) {
                        var_dump($e);
                        exit();
                    }
                }else{
                    echo "<script>window.location.href = '$base_url/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
                exit();
            }
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3><?= $result2['nama_lgkp'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><?= $hal ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $hal2 ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav flex-column nav-pills nav-pills-tab shadow-lg p-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <div class="d-flex justify-content-center">
                                        <img src="<?= $url_images ?>/avatar/<?= $_SESSION['_foto3x4__'] ?>" class="rounded-circle avatar-xl img-thumbnail" alt="Avatar <?= $result2['nama_lgkp'] ?>">
                                    </div>
                                    <div class="d-flex justify-content-center my-2">
                                        <h5 class="text-success"><strong>No. Pendaftaran:</strong> <?= $_SESSION['_id_data_user__'] ?></h5>
                                    </div>
                                    <a class="nav-link mb-1" href="<?= $base_url ?>/<?= $link ?>/identitas">
                                        <i class="fas fa-user-circle"></i> Identitas</a>
                                    <a class="nav-link active show mb-1" href="<?= $base_url ?>/<?= $link ?>/dokumen">
                                        <i class="fas fa-file-alt"></i> Dokumen</a>
                                    <a class="nav-link mb-1" href="<?= $base_url ?>/<?= $link ?>/keamanan">
                                        <i class="fas fa-lock"></i> Keamanan Akun</a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-9">
                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <form action="<?= $base_url ?>/editDokumen" method="POST" enctype="multipart/form-data" data-parsley-validate="">
                                            <div class="row py-0">
                                                <?php if (($_SESSION['_status_dokumen__']==="Kosong")): ?>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="alert alert-danger" role="alert">
                                                            <h3 class="alert-heading fw-bolder"><i class="fas fa-exclamation-triangle"></i> DATA DOKUMEN ANDA BELUM LENGKAP!</h3>
                                                            <p class="mb-0">Mohon lengkapi data anda terlebih dahulu agar bisa melamar pekerjaan disini!</p>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="alert alert-success" role="alert">
                                                            <h3 class="alert-heading fw-bolder"><i class="fas fa-check-circle"></i> DATA DOKUMEN ANDA SUDAH LENGKAP!</h3>
                                                            <hr class="my-1" />
                                                            <h5 class="text-success">Ingin mengubah dokumen anda? <a href="<?= $base_url ?>/resetDokumen" title="Reset Dokumen" class="btn btn-sm btn-success"><i class="fas fa-trash-restore"></i> Reset Dokumen</a></h5>
                                                        </div>
                                                    </div>
                                                <?php endif ?>

                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['surat_lamaran'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_surat_lamaran" required="">
                                                            <label for="surat_lamaran">Surat Lamaran <small class="text-warning">(.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>Surat Lamaran: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['surat_lamaran'] ?>" title="Surat Lamaran" class="link-success">Lihat Surat Lamaran <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['cv'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_cv" required="">
                                                            <label for="cv">CV <small class="text-warning">(.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>CV: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['cv'] ?>" title="CV" class="link-success">Lihat CV <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>

                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['foto3x4'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept="image/jpeg, image/jpg, image/png" name="in_gambar" required="">
                                                            <label for="foto3x4">Foto 3x4 <small class="text-warning">(jpg, jpeg, png)</small></label>
                                                        <?php else: ?>
                                                            <h5>Foto 3x4: <a target="_blank" href="<?= $url_images ?>/avatar/<?= $_SESSION['_foto3x4__'] ?>" title="Foto 3x4" class="link-success">Lihat Foto 3x4 <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['ktam'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_ktam" required="">
                                                            <label for="ktam">KTAM <small class="text-warning">(.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>KTAM: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['ktam'] ?>" title="KTAM" class="link-success">Lihat KTAM <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>

                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['ktp'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_ktp" required="">
                                                            <label for="ktp">KTP <small class="text-warning">(.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>KTP: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['ktp'] ?>" title="KTP" class="link-success">Lihat KTP <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['sks'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_sks" required="">
                                                            <label for="sks">Surat Keterangan Sehat <small class="text-warning">(.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>Surat Keterangan Sehat: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['sks'] ?>" title="Surat Keterangan Sehat" class="link-success">Lihat Surat Keterangan Sehat <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>

                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['skck'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_skck" required="">
                                                            <label for="skck">SKCK <small class="text-warning">(.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>skck: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['skck'] ?>" title="skck" class="link-success">Lihat skck <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['ijazah'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_ijazah" required="">
                                                            <label for="ijazah">Ijazah Terakhir <small class="text-warning">*Terlegalisasi (.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>Ijazah Terakhir: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['ijazah'] ?>" title="Ijazah Terakhir" class="link-success">Lihat Ijazah Terakhir <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>

                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['transkrip_nilai'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_transkrip_nilai" required="">
                                                            <label for="transkrip_nilai">Transkrip Nilai <small class="text-warning">*Terlegalisasi (.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>Transkrip Nilai: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['transkrip_nilai'] ?>" title="Transkrip Nilai" class="link-success">Lihat Transkrip Nilai <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                                <div class="col-6 my-2">
                                                    <div class="form-floating">
                                                        <?php if (empty($result3['sertifikat_pendukung'])): ?>
                                                            <input type="file" data-plugins="dropify" data-height="250" id="gambar" accept=".pdf" name="in_sertifikat_pendukung" required="">
                                                            <label for="sertifikat_pendukung">Sertifikat Pendukung <small class="text-warning">*Bila memiliki lebih dari 1, bisa dijadikan satu file (.pdf)</small></label>
                                                        <?php else: ?>
                                                            <h5>Sertifikat Pendukung: <a target="_blank" href="<?= $url_others ?>/dokumen/<?= $result3['sertifikat_pendukung'] ?>" title="Sertifikat Pendukung" class="link-success">Lihat Sertifikat Pendukung <i class="fas fa-external-link-alt"></i></a></h5>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="in_id_data_user" value="<?= $result3['id_data_user']; ?>">
                                                <input type="hidden" name="in_username" value="<?= $result['username']; ?>">
                                                <input type="hidden" name="in_nama_lgkp" value="<?= $result2['nama_lgkp']; ?>">
                                                <button type="submit" name="_submit_" class="btn btn-success waves-effect waves-light"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
            break;
        case "keamanan":
            $hal        = "Profil";
            $hal2       = "Keamanan Akun";
            $database   = "data_user";
            $link       = "profil";

            try {
                $stmt   = $pdo->prepare("
                    SELECT *
                    FROM $database
                    WHERE id_data_user = ? ");

                $stmt->bindValue(1, $_SESSION['_id_data_user__']);
                $stmt->execute();
                $rows   = $stmt->rowCount();

                if ($rows>0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                }else{
                    echo "<script>window.location.href = '$base_url/dashboard';</script>";
                    die();
                    exit();
                }
            } catch (Exception $e) {
                var_dump($e);
                exit();
            }
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3><?= $_SESSION['_nama_lgkp__'] ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><?= $hal ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $hal2 ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav flex-column nav-pills nav-pills-tab shadow-lg p-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <div class="d-flex justify-content-center">
                                        <img src="<?= $url_images ?>/avatar/<?= $_SESSION['_foto3x4__'] ?>" class="rounded-circle avatar-xl img-thumbnail" alt="Avatar <?= $_SESSION['_nama_lgkp__'] ?>">
                                    </div>
                                    <div class="d-flex justify-content-center my-2">
                                        <h5 class="text-success"><strong>No. Pendaftaran:</strong> <?= $_SESSION['_id_data_user__'] ?></h5>
                                    </div>
                                    <a class="nav-link mb-1" href="<?= $base_url ?>/<?= $link ?>/identitas">
                                        <i class="fas fa-user-circle"></i> Identitas</a>
                                    <a class="nav-link mb-1" href="<?= $base_url ?>/<?= $link ?>/dokumen">
                                        <i class="fas fa-file-alt"></i> Dokumen</a>
                                    <a class="nav-link active show mb-1" href="<?= $base_url ?>/<?= $link ?>/keamanan">
                                        <i class="fas fa-lock"></i> Keamanan Akun</a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-9">
                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <form action="<?= $base_url ?>/editKeamananAkun" method="POST" enctype="multipart/form-data" data-parsley-validate="">
                                            <div class="row py-0">
                                                <div class="col-md-12 mb-1">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="username" name="in_username" placeholder="Cth: arpateam15" minlength="5" maxlength="20" onkeyup="this.value=this.value.replace(/[^a-z][^0-9]/g,'');" value="<?= $result['username'] ?>" readonly>

                                                        <label for="username">Username Pegawai</label>
                                                    </div>
                                                </div>

                                                <!-- Password -->
                                                <div class="col-md-6 my-2">
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
                                                <div class="col-md-6 my-2">
                                                    <label class="font-weight-bold" for="passUlangi">Ulangi Password <span id="buttonShowUlangiPassword" onclick="showUlangiPassword()"><i class="fas fa-eye-slash"></i></span></label>
                                                    <input type="password" id="passUlangi" name="in_ulangi_password" class="form-control" placeholder="Ulangi Password anda..." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="10" maxlength="20" required>
                                                    <div class="form-text confirm-message p-1"></div>
                                                </div>
                                                <!-- Ulangi Password -->
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="in_id_data_user" value="<?= $result['id_data_user']; ?>">
                                                <button type="submit" name="_submit_" class="btn btn-success waves-effect waves-light"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- content -->

<?php
        break;   
    }
?>