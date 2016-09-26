<?php
require('header.php');
?>


<?php
	$session -> updateSession(new user(true));
	header('Location: index.php');
?>

<?php
require('footer.php');
?>



