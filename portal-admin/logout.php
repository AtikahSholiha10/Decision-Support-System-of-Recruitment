<?php

	session_start();

	// Jika berhasil
    unset($_SESSION['_alert__']);
	unset($_SESSION['_msg__']);
	unset($_SESSION['_id_data_admin__']);
	unset($_SESSION['_nama__']);
	unset($_SESSION['_session__']);
	session_unset();
	session_destroy();

    echo "<script>window.location = 'masuk';</script>";
    die();
    exit();