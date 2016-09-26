<?php
require('header.php');

if(isset($_POST['sizes'])){
	$sizes = $_POST['sizes'];
	$_SESSION['sizes'] = $sizes;
}
else{
	if(!isset($_SESSION['sizes']))
		$_SESSION['sizes'] = $sizes;
	else
		$_SESSION['sizes']=null;
	$sizes = $_SESSION['sizes'];
}

if(isset($_POST['colors'])){
	$colors = $_POST['colors'];
	$_SESSION['colors'] = $colors;
}
else{
	if(!isset($_SESSION['colors']))
		$_SESSION['colors'] = $colors;
	else
		$_SESSION['colors']=null;
	$colors = $_SESSION['colors'];
}

header('Location: index.php');
exit;

?>