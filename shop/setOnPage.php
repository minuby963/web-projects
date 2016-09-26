<?php
require('header.php');
?>

<?php
	if(isset($_GET['on_page'])) {
		$_SESSION['on_page'] = $_GET['on_page'];
	}
	header('Location: index.php');
	exit;
?>