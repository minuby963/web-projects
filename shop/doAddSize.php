<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$new_size = $_POST['new_size'];
		$new_size_id = newId('sizes');

		if($new_size>0){}
		else{
			$err = "Wpisano niepoprawny rozmiar!";
			header('Location: error.php?err='.$err);
		}
		if(strpos($new_size, ",")){
			$err = "Ułamek dziesiętny powinien być oddzielony kropką, a nie przecinkiem!";
			header('Location: error.php?err='.$err);
		}

		$stmt = $pdo->prepare("INSERT INTO sizes (size_id, size_value) VALUES (:id, :name)");
		$stmt->bindValue(':name', $new_size, PDO::PARAM_STR);
		$stmt->bindValue(':id', $new_size_id, PDO::PARAM_INT);
		$stmt->execute();


		header('Location: editSizes.php');

	}
}

?>

<?php
require('footer.php');
?>



