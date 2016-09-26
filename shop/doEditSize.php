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

		$new_size_value = $_POST[$size_id];

		$stmt = $pdo->prepare("UPDATE sizes SET size_value = :size_value WHERE size_id = :size_id");
		$stmt->bindValue(':size_value', $new_size_value, PDO::PARAM_STR);
		$stmt->bindValue(':size_id', $size_id, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: editSizes.php');

	}
}

?>

<?php
require('footer.php');
?>



