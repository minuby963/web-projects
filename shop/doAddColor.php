<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$new_color = $_POST['new_color'];
		$new_color_value = "#";
		$new_color_value = $new_color_value.$_POST['color_value'];
		$new_color_id = newId('colors');

		$stmt = $pdo->prepare("INSERT INTO colors (color_id, color_name, color_value) VALUES (:id, :name, :color_value)");
		$stmt->bindValue(':name', $new_color, PDO::PARAM_STR);
		$stmt->bindValue(':color_value', $new_color_value, PDO::PARAM_STR);
		$stmt->bindValue(':id', $new_color_id, PDO::PARAM_INT);
		$stmt->execute();


		header('Location: editColors.php');
		exit;

	}
}

?>

<?php
require('footer.php');
?>



