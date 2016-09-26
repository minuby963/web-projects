<?php
require('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		if(!isset($_POST['sizes'])){
			$err = "Rozmiar jest nieokreślony!";
			header('Location: error.php?err='.$err);
		} 
		if(!isset($_POST['colors'])){
			$err = "Kolor jest nieokreślony!"; 
			header('Location: error.php?err='.$err);
		} 

		$color_ids = $_POST['colors'];
		$size_ids = $_POST['sizes'];
		
		$name = $_POST['name'];
		$net_price = $_POST['net_price'];
		$description = $_POST['description'];
		$category_id = $_POST['category']; ///////////////////////////////////VALIDATION!!!



		$i = nextProduct($category_id);  // IN FUNCTIONS.PHP //
		$product_added = "Dodano: <br>";
		foreach($color_ids as $color_id){
			$index = "Cat".$category_id."_".$i."_Col".$color_id;
			foreach($size_ids as $size_id){
				$new_id = addProduct($index, $name, $net_price, $description, $category_id, $color_id, $size_id); // IN FUNCTIONS.PHP //
				$product_added = $product_added."produkt o numerze id: ".$new_id." i indeksie: $index<br>";

			}
		}
		$_SESSION['product_added'] = $product_added;
		header('Location: addProducts.php');
	}
}

?>

<?php
require('footer.php');
?>



