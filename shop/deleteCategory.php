<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$category_id = $_GET['category_id'];

		$stmt = $pdo->prepare("DELETE FROM categories WHERE category_id=:cid");
		$stmt->bindValue(':cid', $category_id, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: editCategories.php');

	}
}

?>

<?php
require('footer.php');
?>



