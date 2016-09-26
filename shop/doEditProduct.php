<?php
require('header.php');
?>

<?php
function showProductColors($product_index){
	global $pdo;

	$stmt_color = $pdo->prepare('SELECT * FROM colors');
	$stmt_color->execute();


	$product_color_rows = getOtherColorsOfProduct($product_index);
	$rows_color = $stmt_color->fetchAll(PDO::FETCH_ASSOC);

	echo "Dostępne kolory: <br />";
	foreach ($rows_color as $row_color) {
		foreach ($product_color_rows as $product_color_row) {
			if($product_color_row['color_id'] == $row_color['color_id']){
				$color_name = $row_color['color_name'];
				$product_id = $product_color_row['id'];
				echo "<a href='doEditProduct.php?product_id=$product_id'>$color_name</a> ";
			}
		}
	}
	echo "<br />";
} 

function getProductSizes($product_index){
	global $pdo;

	$stmt_sizes = $pdo->prepare('SELECT * FROM products WHERE product_index = :pid');
	$stmt_sizes->bindValue(':pid', $product_index, PDO::PARAM_STR);
	$stmt_sizes->execute();
	$rows = $stmt_sizes->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){
		if(isset($_GET['product_id'])){
			$product_id = $_GET['product_id'];
		}
		else{
			header('Location: editProducts.php');
		}
		$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
		$stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$product_index = $row['product_index'];
		$category_id = $row['category_id'];
		$color_id = $row['color_id'];
		$name = $row['name'];
		$net_price = $row['net_price'];
		$description = $row['description'];
		 
		$size_id = $row['size_id'];

		echo "<div class='product'>";
			showProductColors($product_index);

			echo "<br>";

			echo "Indeks produktu: $product_index <br />";

			$category_name = getCategoryName($category_id);
			echo "Kategoria: $category_name<br />";

			$color_name = getColorName($color_id);
			echo "Kolor produktu: $color_name <br />";
			
			$str_size = "Rozmiary: ";
			$rows_size = getProductSizes($product_index);
			foreach($rows_size as $row_size){
				$size_value = getSizeValue($row_size['size_id']);
				echo "$size_value, ";
			}
			
			echo "<h2>$name</h2>";
			$price = number_format($row['net_price'], 2, '.', ',');
			echo "<h3>".$price." zł</h3>";

			$index = $row['product_index'];
			$category_id = $row['category_id'];

			echo "$description<br />";

			foreach (getProductImages($index) as $image) {
				echo "<a data-lightbox='category' href='photos/$image' data-title='$name'>";
				echo "<img src='photos/thumbs/$image' >";
				echo "</a>";
				//echo "<a href='photos/$image' data-lightbox='a'><img src='photos/thumbs/$image'></a>";
				//echo "<a href='photos/$image' data-lightbox='image-1' data-title='My caption'>";
				//echo "Image #1";
				//echo "</a>";
				echo "</br>";
			}
		echo "</div>";


		$rows_other = getOtherColorsOfProduct($product_index);


		// **********************   ADD NEW COLORS   ************************ //
		echo "<div class='newColors'>";
			echo "<form action='addOtherColors.php?product_index=$product_index' method='post'>";
				$stmt_colors = $pdo->prepare('SELECT * FROM colors');
				$stmt_colors->execute();

				$rows_colors = $stmt_colors->fetchALL(PDO::FETCH_ASSOC);
				echo "Kolory: ";
				foreach($rows_colors as $color){
				$flag = false;

					
					$color_id2 = $color['color_id'];
					$color_name2 = $color['color_name'];
					foreach($rows_other as $color_other){
						//echo $color_other['color_id'];
						if($color_other['color_id'] == $color_id2){
							$flag = true;
							break;
						}
					}
					if(($color_id == $color_id2) or ($flag == true)){
						$flag = true;
					}

					if($flag){
						echo "<input type='checkbox' checked='checked' name='colors[]' value='$color_id2' /> $color_name2 |";
					}
					else{
						echo "<input type='checkbox' name='colors[]' value='$color_id2' /> $color_name2 |";
					}
					
					
				}
				echo "<br />";
				echo "<input type='submit' value='Dodaj / usuń kolory produktu'>";
			echo "</form>";
		echo "</div>";

		echo "<br>";

		echo "<div class='editProductForm'>";

			echo "<form action='productEditExecution.php?product_id=$product_id' method='post'>";
				echo "Index: <input type='text' name='index' value='$product_index'><br />";




				// **************   CATEGORY   ************** //   
				$stmt = $pdo->prepare("SELECT * FROM categories");
				$stmt->execute();

				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				echo "Kategoria: <select value='$category_name' name='category'>";
				foreach($rows as $category){
						
					$category_id2 = $category['category_id'];
					$category_name2 = $category['name'];
					if($category_name2 != $category_name){
						echo"<option value='$category_id2'>$category_name2</option>";
					}
					else{
						echo"<option selected value='$category_id2'>$category_name2</option>";
					}
				}
				echo "</select><br />";



				// **************   COLOR   ************** // 
				$stmt_colors = $pdo->prepare("SELECT * FROM colors");
				$stmt_colors->execute();

				$rows_colors = $stmt_colors->fetchAll(PDO::FETCH_ASSOC);
				echo "Kolory: <select value='$color_name' name='color'>";
				foreach($rows_colors as $color){
						
					$color_id2 = $color['color_id'];
					$color_name2 = $color['color_name'];
					if($color_name2 != $color_name){
						echo"<option value='$color_id2'>$color_name2</option>";
					}
					else{
						echo"<option selected value='$color_id2'>$color_name2</option>";
					}
				}
				echo "</select><br /><br />";  

				// **************   SIZES   ************** //   
				$stmt_sizes = $pdo->prepare("SELECT * FROM sizes ORDER BY size_value ASC");
				$stmt_sizes->execute();

				$rows_sizes = $stmt_sizes->fetchAll(PDO::FETCH_ASSOC);
				echo "Rozmiary: ";
				$rows_size = getProductSizes($product_index);
				foreach($rows_sizes as $size){
					
					$size_id2 = $size['size_id'];
					$size_value2 = $size['size_value'];
					foreach($rows_size as $row_size){
						if($row_size['size_id'] == $size_id2){
							$flag = true;
							break;
						}
						else{
							$flag = false;
						}
					}
					if($flag){
						echo "<input type='checkbox' checked='checked' name='sizes[]' value='$size_id2' /> $size_value2 |";
					}
					else{
						echo "<input type='checkbox' name='sizes[]' value='$size_id2' /> $size_value2 |";
					}
				}
				echo "<br /><br />";

				// ****************   OTHERS   **************** // 
				echo "Nazwa: <input type='text' value='$name' name='name'><br /><br />";
				echo "Cena Netto: <input type='text' value='$price' name='net_price'><br /><br />";
				echo "Opis: <textarea name='description'>$description</textarea><br />";
				echo "<input type='submit' value='Edytuj'>";
			echo "</form>";
		echo "</div>";
		echo "<div class='clear'></div>";




		//header('Location: editProducts.php');

	}
}

?>

<?php
require('footer.php');
?>



