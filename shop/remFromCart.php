<?php
require('header.php');
?>

<?php
	$cart->remove($_GET['id']);
	header('Location: showcart.php');
?>

<?php
require('footer.php');
?>



