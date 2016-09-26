<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$size_id = $_GET['size_id'];

		$stmt = $pdo->prepare("DELETE FROM sizes WHERE size_id=:cid");
		$stmt->bindValue(':cid', $size_id, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: editSizes.php');

	}
}

?>

<?php
require('footer.php');
?>



