<?php
require('header.php');
?>

<?php

$err = $_GET['err'];
echo "<div class='error errorContainer'>";
	echo "$err <br />";
echo "</div>";

?>

<?php
require('footer.php');
?>
