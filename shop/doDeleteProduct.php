<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$product_id = $_GET['product_id'];

		deleteProduct($product_id);
		header('Location: editProducts.php');

	}
}

?>

<?php
require('footer.php');
?>



