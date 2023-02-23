<?php

	if($_GET['module']=='dashboard') { 
		include("appweb/Views/dashboard.php");
	}elseif($_GET['module']=='profil') { 
		include("appweb/Views/profile.php");
	}elseif($_GET['module']=='penerimaan') { 
		include("appweb/Views/penerimaan.php");
	}

	else{
		echo "<script>window.location = '404';</script>";
	}

?>