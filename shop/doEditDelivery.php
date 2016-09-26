<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$delivery_id = $_GET['delivery_id'];

		$delivery_method = $_POST["delivery_method".$delivery_id];
		$payment_method = $_POST["payment_method".$delivery_id];
		$delivery_price = $_POST["delivery_price".$delivery_id];


		$stmt = $pdo->prepare("UPDATE delivery SET delivery_method = :delivery_method, payment_method = :payment_method, delivery_price = :delivery_price WHERE id = :delivery_id");
		$stmt->bindValue(':delivery_method', $delivery_method, PDO::PARAM_STR);
		$stmt->bindValue(':payment_method', $payment_method, PDO::PARAM_STR);
		$stmt->bindValue(':delivery_price', $delivery_price, PDO::PARAM_INT);
		$stmt->bindValue(':delivery_id', $delivery_id, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: editDelivery.php');

	}
}

?>

<?php
require('footer.php');
?>



