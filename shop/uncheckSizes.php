<?php
require('header.php');
?>

<?php

	
	if(isset($_POST['colors'])){
		$colors = $_POST['colors'];
		$_SESSION['colors'] = $colors;
	}
	else{
		$colors=null;	
		if(!isset($_SESSION['colors'])){
			$_SESSION['colors'] = $colors;
		}
		$colors = $_SESSION['colors'];
	}

	unset($_SESSION['sizes']);



	header("Location: index.php");
	exit;
?>




