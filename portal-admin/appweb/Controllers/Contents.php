<?php

	switch ($_SESSION['_level__']) {
		case 'Administrator':
			if($_GET['module']=='dashboard') { 
				include("appweb/Views/dashboard.php");
			}elseif($_GET['module']=='pelamar') { 
				include("appweb/Views/pelamar.php");
			}elseif($_GET['module']=='penerimaan') { 
				include("appweb/Views/penerimaan.php");
			}elseif($_GET['module']=='user') { 
				include("appweb/Views/user.php");
			}elseif($_GET['module']=='perhitungan') { 
				include("appweb/Views/perhitungan.php");
			}elseif($_GET['module']=='pegawai') { 
				include("appweb/Views/pegawai.php");
			}elseif($_GET['module']=='pengaturan') { 
				include("appweb/Views/settings.php");
			}else{
				echo "<script>window.location = '404';</script>";
			}

			break;

		case 'Penilai':
			if($_GET['module']=='dashboard') { 
				include("appweb/Views/dashboard.php");
			}elseif($_GET['module']=='pelamar') { 
				include("appweb/Views/pelamar.php");
			}elseif($_GET['module']=='user') { 
				include("appweb/Views/user.php");
			}elseif($_GET['module']=='perhitungan') { 
				include("appweb/Views/perhitungan.php");
			}else{
				echo "<script>window.location = '404';</script>";
			}

			break;
	}

?>