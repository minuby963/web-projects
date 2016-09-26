<?php
require('header.php');
?>

<?php
	if(isset($_GET['order_by'])) {
		$_SESSION['order_by'] = $_GET['order_by'];
	}
	header('Location: index.php');
	exit;
?>