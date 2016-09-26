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

		$stmt = $pdo->prepare("DELETE FROM delivery WHERE id=:did");
		$stmt->bindValue(':did', $delivery_id, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: editDelivery.php');
		exit;

	}
}

?>

<?php
require('footer.php');
?>