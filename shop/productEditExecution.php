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


	function newProductIndex($category_id, $color_id){
		//$parts = explode('_', $old_product_index);

		$i = nextProduct($category_id);

		$new_index = "Cat".$category_id."_".$i."_Col".$color_id;

		return $new_index;
	}


?>



<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){

		$product_id = $_GET['product_id'];

		$product_index = $_POST['index'];
		$name = $_POST['name'];
		$net_price = $_POST['net_price'];
		$description = $_POST['description'];
		$category_id = $_POST['category']; 											// validation
		$color_id = $_POST['color'];


		$product_rows = getProductRows($product_id);


		if($product_index == $product_rows[0]['product_index']){
			$new_product_index = newProductIndex($category_id, $color_id);
		}
		else{
			$new_product_index = $product_index;
		}

		if(isset($_POST['sizes'])){
			$size_ids = $_POST['sizes']; 
		}
		else{

			foreach($product_rows as $product_row){
				$product_id = $product_row['id'];
				deleteProduct($product_id);
				echo "DELETE: $product_id<br>";                                   ///////////////delete/////////////
			}
			header('Location: editProducts.php');										/////////////uncomment////////////
			exit;
		}

		$rows_other = getOtherColorsOfProduct($product_index);
		foreach($rows_other as $others){
			$color_id_other = $others['color_id'];




			echo "<br>color id other: $color_id_other";                               ///////////////delete/////////////
			echo "<br>color id: $color_id";
			echo "<br>prod rows: ".$product_rows[0]['color_id']."<br>";



			if(($color_id == $color_id_other) && ($product_rows[0]['color_id'] != $color_id)){
				$product_id_other = $others['id'];
				header('Location: doEditProduct.php?product_id='.$product_id_other);
				exit;
				echo "<a href='doEditProduct.php?product_id=$product_id_other'>header</a><br>";///////////////delete/////////////
				
			}
		}


		$stmt_sizes = $pdo->prepare('SELECT * FROM sizes ORDER BY size_value ASC');
		$stmt_sizes->execute();
		$rows_sizes = $stmt_sizes->fetchAll(PDO::FETCH_ASSOC);
		foreach($rows_sizes as $row_sizes){
			$size_id = $row_sizes['size_id'];

			$bool_delete = true;
			$bool_add = false;
			$bool_update = false;


			foreach($size_ids as $size_id_input){
				if($size_id == $size_id_input){
					$bool_delete = false;
					$bool_add = true;
				}
			}	

			foreach($product_rows as $others){
				$size_id_existing = $others['size_id'];
				$product_id_existing = $others['id'];


				if($size_id == $size_id_existing){
					foreach($size_ids as $size_id_input){
						if($size_id_existing == $size_id_input){
							$new_directory = $others['id'];
							$bool_update = true;

							$sql = "UPDATE products SET "
								."product_index   = :product_index, "
								."name            = :name, "
								."net_price       = :net_price, "
								."description     = :description, "
								."category_id     = :category_id, "
								."color_id        = :color_id, "
								."size_id        = :size_id "
								."WHERE " 
								."id              = :product_id";

							$stmt = $pdo->prepare($sql);
							$stmt->bindValue(':product_id', $product_id_existing, PDO::PARAM_INT);

							$stmt->bindValue(':product_index', $new_product_index, PDO::PARAM_INT);
							$stmt->bindValue(':name', $name, PDO::PARAM_INT);
							$stmt->bindValue(':net_price', $net_price, PDO::PARAM_INT);
							$stmt->bindValue(':description', $description, PDO::PARAM_INT);
							$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
							$stmt->bindValue(':color_id', $color_id, PDO::PARAM_INT);
							$stmt->bindValue(':size_id', $size_id, PDO::PARAM_INT);

							$stmt->execute();
							echo "<br>update: $product_id_existing   $product_index <br />";				///////////////delete/////////////


						}
					}


				 	if($bool_delete == true){
						if($product_id_existing == $product_id){
							$bool_change_directory = true;
						}
						echo "<br>delete: $product_id_existing <br />";								///////////////delete/////////////
						deleteProduct($product_id_existing);
					}
					$bool_add = false;
				}
			}
			
			if($bool_add){
				$product_id_new = addProduct($product_index, $name, $net_price, $description, $category_id, $color_id, $size_id);
				echo "<br>add: $product_id_new $product_index <br />";				///////////////delete/////////////
			}
		}
		if($bool_change_directory){
			echo $product_id_new;
			if(isset($product_id_new)){
				header('Location: doEditProduct.php?product_id='.$product_id_new);
				exit;
			}
			else{
				header('Location: doEditProduct.php?product_id='.$new_directory);
				exit;
			}

		}
		else{
			header('Location: doEditProduct.php?product_id='.$product_id);
			exit;
		}

		
	}
}

?>




