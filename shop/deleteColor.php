<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$color_id = $_GET['color_id'];

		$stmt = $pdo->prepare("DELETE FROM colors WHERE color_id=:cid");
		$stmt->bindValue(':cid', $color_id, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: editColors.php');
		exit;
	}
}

?>

<?php
require('footer.php');
?>



