<?php
require('header.php');
?>

<?php
	if((isset($_POST['name'])) && ($_POST['name'] != '')) {
		$_SESSION['main_search_name'] = $_POST['name'];
	}
	else{
		unset($_SESSION['main_search_name']);
	}
	header('Location: index.php');
	exit;
?>