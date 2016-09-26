<?php
require('header.php');
?>

<?php
	if(isset($_GET['category_id'])) {
		$_SESSION['category_id'] = $_GET['category_id'];
		echo "category id: ".$_SESSION['category_id'];
	}
	else{
		unset($_SESSION['category_id']);
	}
	header('Location: index.php');
	exit;
?>