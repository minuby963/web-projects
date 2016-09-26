<?php
require('header.php');
?>

<?php
	function getProductId($product_index){
		global $pdo;
		$stmt = $pdo->prepare('SELECT * FROM products WHERE product_index = :product_index');
		$stmt->bindValue(':product_index', $product_index, PDO::PARAM_STR);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['id'];
	}

	function getProductRow($product_id){
		global $pdo;
		$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :product_id');
		$stmt->bindValue(':product_id', $product_id, PDO::PARAM_STR);
		$stmt->execute();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			return $row;
		}
		return false;
	}

?>



<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$product_index = $_GET['product_index'];

		$stmt = $pdo->prepare('SELECT * FROM products WHERE product_index = :product_index');
		$stmt->bindValue(':product_index', $product_index, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$product_id = getProductId($product_index){
		$product_rows = getProductRows($product_id);


		if(isset($_POST['colors'])){
			$color_ids = $_POST['colors'];
		}
		else{
			$rows_other = getOtherColorsOfProduct($product_index);
			foreach($rows_other as $row_other){
				echo $row_other['product_index'];										///////////////delete/////////////

				$product_index = $row_other['product_index'];
				foreach($product_rows as $product_row){
					$product_id = $product_row['id'];
					deleteProduct($product_id);
					echo "DELETE: $product_id<br>";                                   ///////////////delete/////////////
				}
			}
			header('Location: editProducts.php');										/////////////uncomment////////////
			exit;
		}




		foreach($product_rows as $product_row){

			$product_index = $product_row['product_index'];
			$product_id = getProductId($product_index);

			$product_index_elements = explode('_', $product_index);
			$bool_change_directory = false;

			$rows_other = getOtherColorsOfProduct($product_index);
			

			$stmt_colors = $pdo->prepare('SELECT * FROM colors');
			$stmt_colors->execute();
			$rows_colors = $stmt_colors->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows_colors as $color) {
				$color_id = $color['color_id'];

				$bool_delete = true;
				$bool_add = false;

				foreach($color_ids as $color_id_input){
					if($color_id == $color_id_input){
						$bool_delete = false;
						$bool_add = true;
					}
				}	

				foreach($rows_other as $others){
					$color_id_existing = $others['color_id'];
					foreach($color_ids as $color_id_input){
						if($color_id_existing == $color_id_input){
							$new_directory = $others['id'];
						}
					}

					if($color_id == $color_id_existing){
					 	if($bool_delete == true){
							$product_id_existing = $others['id'];
							if($product_id_existing == $product_id){
								$bool_change_directory = true;
							}
							echo "delete: $product_id_existing <br />";								///////////////delete/////////////
							deleteProduct($product_id_existing);
						}
						$bool_add = false;
					}

				}
				if($bool_add){
					
					$name = $product_row['name'];
					$net_price = $product_row['net_price'];
					$description = $product_row['description'];
					$category_id = $product_row['category_id'];

					$product_index_add = "Cat".$category_id."_".$product_index_elements[1]."_Col".$color_id;
				
					$product_index = $product_row['product_index'];
					$product_id = getProductId($product_index);



					foreach($product_rows as $product_row){
						$size_id = $product_row['size_id'];
						$product_id_new = addProduct($product_index_add, $name, $net_price, $description, $category_id, $color_id, $size_id);
						echo "add: $product_id_new $product_index_add <br />";				///////////////delete/////////////
					}
				}
			}
		}
		if($bool_change_directory){
			echo $product_id_new;
			if(isset($product_id_new)){
				header('Location: doEditProduct.php?product_id='.$product_id_new);
			}
			else{
				header('Location: doEditProduct.php?product_id='.$new_directory);
			}

		}
		else{
			header('Location: doEditProduct.php?product_id='.$product_id);
		}

	}
}

?>

<?php
require('footer.php');
?>



