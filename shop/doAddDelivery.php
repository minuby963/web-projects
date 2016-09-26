<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$new_delivery_method = $_POST['new_delivery_method'];
		$new_payment_method = $_POST['new_payment_method'];
		$new_delivery_price = $_POST['new_delivery_price'];


		$stmt = $pdo->prepare("INSERT INTO delivery (delivery_method, payment_method, delivery_price) VALUES (:delivery_method, :payment_method, :delivery_price)");
		$stmt->bindValue(':delivery_method', $new_delivery_method, PDO::PARAM_STR);
		$stmt->bindValue(':payment_method', $new_payment_method, PDO::PARAM_STR);
		$stmt->bindValue(':delivery_price', $new_delivery_price, PDO::PARAM_INT);
		$stmt->execute();


		header('Location: editDelivery.php');
		exit;
	}
}

?>

<?php
require('footer.php');
?>



