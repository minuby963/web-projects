<?php
require('header.php');
?>

<?php

	if(isset($_POST['sizes'])){
		$sizes = $_POST['sizes'];
		$_SESSION['sizes'] = $sizes;
	}
	else{
		$sizes=null;	
		if(!isset($_SESSION['sizes'])){
			$_SESSION['sizes'] = $sizes;
		}
		$sizes = $_SESSION['sizes'];
	}
	
	unset($_SESSION['colors']);

	header("Location: index.php");
	exit;
?>




