<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$new_category = $_POST['new_category'];

		$new_category_id = newId('categories');

		$stmt = $pdo->prepare("INSERT INTO categories (category_id, name) VALUES (:cid, :name)");
		$stmt->bindValue(':name', $new_category, PDO::PARAM_STR);
		$stmt->bindValue(':cid', $new_category_id, PDO::PARAM_INT);

		$stmt->execute();

		header('Location: editCategories.php');
	}
}

?>

<?php
require('footer.php');
?>



