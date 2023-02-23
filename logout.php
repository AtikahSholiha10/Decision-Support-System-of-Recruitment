<?php

	session_start();

	// Jika berhasil
    unset($_SESSION['_alert__']);
	unset($_SESSION['_msg__']);
	unset($_SESSION['_session__']);
	unset($_SESSION['_id_data_user__']);
	unset($_SESSION['_status_identitas__']);
	unset($_SESSION['_status_dokumen__']);
	unset($_SESSION['_id_identitas_user__']);
	unset($_SESSION['_id_dokumen_user__']);
	unset($_SESSION['_nama_lgkp__']);
	unset($_SESSION['_foto3x4__']);

	session_unset();
	session_destroy();

    echo "<script>window.location = 'masuk';</script>";
    die();
    exit();