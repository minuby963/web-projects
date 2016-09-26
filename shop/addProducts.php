<?php
require('header.php');
?>
<div class='container'>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){
		$stmt = $pdo->prepare("SELECT * FROM categories");
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		


		echo "<form action='doAddProduct.php' method='post'>";
			echo "<div class='addProductForm'>";
				echo "<div class='addProductFormParts'>"; 
					echo "<div class='addProductFormPart1'>";		
						
						echo "<input type='text' name='name' placeholder='Nazwa'><br>";
						echo "<input type='text' name='net_price' placeholder='Cena'><br>";
						echo "<textarea name='description' placeholder='Opis'></textarea><br>";

						echo "Kategoria: <select name='category'>";
						foreach($rows as $category){
							$id = $category['category_id'];
							$name = $category['name'];
							echo"<option value='$id'>$name</option>";
						}
						echo "</select>";

					echo "</div>";

					echo "<div class='lineVertical'></div>";

					$stmt_colors = $pdo->prepare("SELECT * FROM colors");
					$stmt_colors->execute();
					$rows_colors = $stmt_colors->fetchAll(PDO::FETCH_ASSOC);



					echo "<div class='addProductFormPart3 filter colors'>";		

						echo "<div class='filterName textColors'>";
							echo "KOLORY: ";
						echo "</div>";

						$j=1;
						foreach($rows_colors as $color){
							$color_id = $color['color_id'];
							$color_name = $color['color_name'];
							$color_value = $color['color_value'];
							$style = getColorStyle($color_value);

							echo "<div class='filterSingle singleColor'>";
								echo "<div class='checkboxFilter checkboxColor".$j."'>";

									echo "<input type='checkbox' id='checkboxColor".$j."' name='colors[]' value='$color_id'>";
									echo "<label for='checkboxColor".$j."' ".$style." ></label>";
								echo "</div>";

								echo "<div class='checkboxFilterName checkboxColorName'>";
									echo "$color_name";
								echo "</div>";
							echo "</div>";

							$j++;
						}

					echo "</div>";

					echo "<div class='lineVertical'></div>";

					$stmt_sizes = $pdo->prepare("SELECT * FROM sizes ORDER BY size_value ASC");
					$stmt_sizes->execute();
					$rows_sizes = $stmt_sizes->fetchAll(PDO::FETCH_ASSOC);

					echo "<div class='addProductFormPart2 filter sizes'>";		

						echo "<div class='filterName textSizes'>";
							echo "ROZMIARY: ";
						echo "</div>";

						$j=1;
						foreach($rows_sizes as $size){
							$size_id = $size['size_id'];
							$size_value = $size['size_value'];
							echo "<div class='filterSingle singleSize'>";
								echo "<div class='checkboxFilter checkboxSize".$j."'>";
								
									echo "<input type='checkbox' id='checkboxSize".$j."' name='sizes[]' value='$size_id'>";
									echo "<label for='checkboxSize".$j."' style='background: #9DADB3;' ></label>";

								echo "</div>";
								echo "<div class='checkboxFilterName checkboxSizeName'>";
									echo "$size_value";
								echo "</div>";
							
							echo "</div>";
							$j++;
						}

					echo "</div>";

				echo "</div>";

				echo "<input type='submit' value='DODAJ' />";

			echo "</div>";
		echo "</form>";
		if(isset($_SESSION['product_added'])){
			echo "<div class='success'>";
				echo $_SESSION['product_added'];
			echo "</div>";
			unset($_SESSION['product_added']);
		}

	}
}

?>
</div>
<?php
require('footer.php');
?>



