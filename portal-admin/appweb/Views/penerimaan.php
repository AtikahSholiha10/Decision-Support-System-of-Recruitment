<?php

    switch ($_GET['act']) {
        case "list":
            $hal        = "Data Penerimaan";
            $database   = "lowongan";
            $link       = "penerimaan";
            $Active     = "Active";
            $Delete     = "Hapus";
            
?>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="container">
            <h3 class="text-success"><?= $hal ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $base_url_admin ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $hal ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <div class="col-auto my-auto">
                                <a role="button" data-bs-toggle="modal" data-bs-target="#TambahPenerimaan" class="btn btn-success"><i class="fas fa-plus"></i> Tambah <?= $hal ?></a>
                            </div>
                        </div>
                        <div id="TambahPenerimaan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <form action="<?= $base_url_admin ?>/addPenerimaan" method="POST" data-parsley-validate="" class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Form Tambah <?= $hal ?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body row">
                                        <div class="col-12">
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <h4 class="alert-heading">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                                    </svg> PERHATIAN!
                                                </h4>
                                                <hr class="my-2">
                                                <ul class="mb-1">
                                                    <li>Mohon pastikan anda mengisi <em>form</em> dibawah ini dengan lengkap dan benar!</li>
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>

                                        <div class="col-md-12 my-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="nama_sekolah" name="in_nama_sekolah" placeholder="Cth: Beranda" required="">
                                                <label for="nama_sekolah">Nama Sekolah</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 my-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="jabatan" name="in_jabatan" placeholder="Cth: Beranda" required="">
                                                <label for="jabatan">Jabatan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 my-1">
                                            <div class="form-floating">
                                                <select class="form-select" id="stat" name="in_stat" required="">
                                                    <option value="Active">Active</option>
                                                    <option value="Non-Active">Non-Active</option>
                                                </select>
                                                <label for="stat">Status</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary waves-effect" data-bs-dismiss="modal"><i class="fas fa-times"></i> BATAL</button>
                                        <button type="submit" name="_submit_" class="btn btn-success waves-effect waves-light"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal -->
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-striped dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th style="max-width: 5%;">No.</th>
                                    <th style="max-width: 30%;">Nama Sekolah</th>
                                    <th style="max-width: 40%;">Jabatan</th>
                                    <th style="max-width: 10%;">Status</th>
                                    <th style="max-width: 15%;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $no = 1;
                                    try {
                                        $stmt   = $pdo->prepare("
                                            SELECT *
                                            FROM $database
                                            WHERE status != ?
                                            ORDER BY id_$database DESC
                                        ");

                                        $stmt->bindValue(1, $Delete);
                                        $stmt->execute();
                                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><span><?= $result['nama_sekolah'] ?></span></td>
                                    <td><span class="text-success fw-bolder"><?= $result['jabatan'] ?></span></td>
                                    <td>
                                        <?php if ($result['status']==="Active"): ?>
                                            <span class="badge bg-success text-light p-1"><i class="fas fa-check"></i> Aktif</span>
                                        <?php elseif ($result['status']==="Non-Active"): ?>
                                            <span class="badge bg-danger text-light p-1"><i class="fas fa-times"></i> Non-Aktif</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <a role="button" data-bs-toggle="modal" data-bs-target="#UbahPenerimaan<?= $result['id_lowongan'] ?>" class="btn btn-xs btn-success"><i class="fas fa-edit"></i></a>

                                        <a role="button" onclick="confirmHapusPenerimaan('<?= $result['id_lowongan']; ?>')" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>

                                        <hr class="my-1" />

                                        <a role="button" data-bs-toggle="modal" data-bs-target="#Kriteria<?= $result['id_lowongan'] ?>" class="btn btn-xs btn-pink">Kriteria <i class="fas fa-star"></i></a>

                                        <div id="UbahPenerimaan<?= $result['id_lowongan'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <form action="<?= $base_url_admin ?>/editPenerimaan" method="POST" data-parsley-validate="" class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Form Ubah <?= $hal ?></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body row">
                                                        <div class="col-12">
                                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                                <h4 class="alert-heading">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                                                    </svg> PERHATIAN!
                                                                </h4>
                                                                <hr class="my-2">
                                                                <ul class="mb-1">
                                                                    <li class="text-wrap">Mohon pastikan anda mengisi <em>form</em> dibawah ini dengan lengkap dan benar!</li>
                                                                </ul>
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 my-1">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="nama_sekolah" name="in_nama_sekolah" placeholder="Cth: Beranda" value="<?= $result['nama_sekolah'] ?>" required="">
                                                                <label for="nama_sekolah">Nama Sekolah</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 my-1">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="jabatan" name="in_jabatan" placeholder="Cth: Beranda" value="<?= $result['jabatan'] ?>" required="">
                                                                <label for="jabatan">Jabatan</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 my-1">
                                                            <div class="form-floating">
                                                                <select class="form-select" id="stat" name="in_stat" required="">
                                                                    <option value="Active" <?php if ($result['status']==="Active") { echo 'selected'; } ?>>Active</option>
                                                                    <option value="Non-Active" <?php if ($result['status']==="Non-Active") { echo 'selected'; } ?>>Non-Active</option>
                                                                </select>
                                                                <label for="stat">Status</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal"><i class="fas fa-times"></i> BATAL</button>
                                                        <input type="hidden" name="in_id_lowongan" value="<?= $result['id_lowongan']; ?>">
                                                        <input type="hidden" name="in_slug_lama" value="<?= $result['slug']; ?>">
                                                        <button type="submit" name="_submit_" class="btn btn-success waves-effect waves-light"><i class="fas fa-save"></i> SIMPAN PERUBAHAN</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal -->

                                        <div id="Kriteria<?= $result['id_lowongan'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Form Kriteria Penerimaan <strong><?= $result['jabatan'] ?></strong></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body py-3">
                                                        <table class="table table-hover table-striped table-responsive table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Kriteria</th>
                                                                    <th>Bobot</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Loyalitas dan Kemuhammadiyahan</td>
                                                                    <td>30%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Sholat</td>
                                                                    <td>30%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Wudhu dan Tayamum</td>
                                                                    <td>10%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Membaca Al-Quran</td>
                                                                    <td>30%</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal"><i class="fas fa-times"></i> TUTUP</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.modal -->
                                    </td>
                                </tr>
                                <?php
                                        }
                                    } catch (Exception $e) {
                                        var_dump($e);
                                        exit();
                                    }
                                ?>
                            </tbody>
                        </table>
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