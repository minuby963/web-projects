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

		$new_color_name = $_POST["color_name".$color_id];

		$new_color_value = "#";
		$new_color_value = $new_color_value.$_POST['color_value'.$color_id];


		$stmt = $pdo->prepare("UPDATE colors SET color_name = :color_name, color_value = :color_value WHERE color_id = :color_id");
		$stmt->bindValue(':color_name', $new_color_name, PDO::PARAM_STR);
		$stmt->bindValue(':color_value', $new_color_value, PDO::PARAM_STR);
		$stmt->bindValue(':color_id', $color_id, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: editColors.php');
		exit;

	}
}

?>

<?php
require('footer.php');
?>



