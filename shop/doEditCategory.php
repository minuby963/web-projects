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

		$new_category_name = $_POST[$category_id];

		$stmt = $pdo->prepare("UPDATE categories SET name = :category_name WHERE category_id = :category_id");
		$stmt->bindValue(':category_name', $new_category_name, PDO::PARAM_STR);
		$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: editCategories.php');

	}
}

?>

<?php
require('footer.php');
?>



