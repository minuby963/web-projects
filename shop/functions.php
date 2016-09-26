<?php
define('SESSION_COOKIE', 'cookieshop');
define('SESSION_ID_LENGHT', 40);
define('SESSION_COOKIE_EXPIRE', 3600);
define('NUMBER_OF_PAGES', 2);


//define('ROOT_PATH', 'C:\Users\Daniel\Desktop\sklep');

function getOtherColorsOfProduct($product_index){
	global $pdo;
	//echo $product_index;
	
	$tmp = explode('_', $product_index);

	$index_like = $tmp[0]."_".$tmp[1]."_Col%";

	$stmt_other = $pdo->prepare('SELECT * FROM products WHERE product_index LIKE :p_index_like');
	$stmt_other->bindValue(':p_index_like', $index_like, PDO::PARAM_STR);
	$stmt_other->execute();

	$rows = $stmt_other->fetchAll(PDO::FETCH_ASSOC);
	$rows_uniq[] = $rows[0];
	
	foreach($rows as $row){
		$flag = true;
		foreach($rows_uniq as $row_uniq){
			if($row['color_id'] == $row_uniq['color_id']){
				$flag = false;
			}
		}
		if($flag){
			$rows_uniq[] = $row;
		}
	}
	return $rows_uniq; 
}

		
function deleteProduct($product_id){
	global $pdo;
	$stmt = $pdo->prepare("DELETE FROM products WHERE id = :product_id");
	$stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
	$stmt->execute();
} 

function getProductRows($product_id){
	global $pdo;
	$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :pid');
	$stmt->bindValue(':pid', $product_id, PDO::PARAM_INT);
	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

function addProduct($index, $name, $net_price, $description, $category_id, $color_id, $size_id){
	global $pdo;
	$sql = "INSERT INTO products SET "
		."id            = :id, " 
		."product_index = :product_index, "
		."name          = :name, "
		."net_price     = :net_price, "
		."description   = :description, "
		."category_id   = :category_id, "
		."color_id      = :color_id, "
		."size_id       = :size_id";
				
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id', null, PDO::PARAM_INT);
	$stmt->bindValue(':product_index', $index, PDO::PARAM_INT);
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->bindValue(':net_price', $net_price, PDO::PARAM_INT);
	$stmt->bindValue(':description', $description, PDO::PARAM_STR);
	$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
	$stmt->bindValue(':color_id', $color_id, PDO::PARAM_INT);
	$stmt->bindValue(':size_id', $size_id, PDO::PARAM_INT);

	$stmt->execute();

	$stmt_new_product = $pdo->prepare('SELECT * FROM products WHERE product_index = :pid');
	$stmt_new_product->bindValue('pid', $index, PDO::PARAM_STR);
	$stmt_new_product->execute();
	$rows = $stmt_new_product->fetchAll(PDO::FETCH_ASSOC);
	$product_id_new = 0;
	foreach ($rows as $row) {
		if($row['id']>$product_id_new){
			$product_id_new = $row['id'];
		}
	}
	return $product_id_new;
}



function makeArrayFromString($string){
	$string = explode(', ', $string);
	$i = 0;
	foreach($string as $element){
		$array[$i] = intval($element);
		$i++;
	}
	return $array;
}

function nextProduct($category_id){
	global $pdo;
	$stmt = $pdo->prepare('SELECT * FROM products WHERE category_id = :cid ORDER BY product_index ASC');
	$stmt->bindValue(':cid', $category_id, PDO::PARAM_INT);
	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$i = 1;
	$pid = "";

	foreach($rows as $row){
		$existing_index = explode('_', $row['product_index']);

		if($pid != $existing_index[1]){
			$i++;
			echo "<br>i: $i, pid: cat%_".$pid."<br>";
		}
		$pid = $existing_index[1];

		echo "prv pid: cat%_".$pid."<br>";
		
	}
	// $i++;
	echo "<br>I: $i<br>";
	return $i;
}	

function newId($table){
	global $pdo;
	if($table == "categories"){
		$column = "category_id";
	}
	elseif($table == "colors"){
		$column = "color_id";
	}
	elseif($table == "sizes"){
		$column = "size_id";
	}
	else{
		header('Location: error.php');
	}

	$sql = "SELECT * FROM ".$table." ORDER BY ".$column." ASC";
	//echo $sql;

	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$id = $row[$column];
	}
	$new_id = $id+1;

	//echo $id;
	//echo $new_id;

	return $new_id;
}

function getProductImages($index){
	$images = array();

	//H001-x
	for($i=1; $i<10; $i++){
		
		$file_name = $index."-".$i.".jpg";
		$file_path = "photos/$file_name";
		if(file_exists($file_path)){
			//echo $file_path;
			$images[] = $file_name;
		}
	}
	return $images;
}
function getProductImagesThumbs($index){
	$images = array();

	for($i=1; $i<10; $i++){
		
		$file_name = $index."-".$i.".jpg";
		$file_name = $index."-".$i.".jpg";
		$file_path = "photos/thumbs/$file_name";
		if(file_exists($file_path)){
			//echo $file_path;
			$images[] = $file_name;
		}
	}
	return $images;
}

function getCategoryName($category_id){
	global $pdo;
	$stmt_categories = $pdo->prepare('SELECT * FROM categories WHERE category_id = :cid');
	$stmt_categories->bindValue('cid', $category_id, PDO::PARAM_INT);
	$stmt_categories->execute();
	$row_categories = $stmt_categories -> fetch(PDO::FETCH_ASSOC);
	$category_name = $row_categories['name'];
	return $category_name;
}

function getColorName($color_id){
	global $pdo;
	$stmt_colors = $pdo->prepare('SELECT * FROM colors WHERE color_id = :cid');
	$stmt_colors->bindValue('cid', $color_id, PDO::PARAM_INT);
	$stmt_colors->execute();
	$row_colors = $stmt_colors -> fetch(PDO::FETCH_ASSOC);
	$color_name = $row_colors['color_name'];
	return $color_name;
}
function getColorValue($color_id){
	global $pdo;
	$stmt_colors = $pdo->prepare('SELECT * FROM colors WHERE color_id = :cid');
	$stmt_colors->bindValue('cid', $color_id, PDO::PARAM_INT);
	$stmt_colors->execute();
	$row_colors = $stmt_colors -> fetch(PDO::FETCH_ASSOC);
	$color_value = $row_colors['color_value'];
	return $color_value;
}

function getSizeValue($size_id){
	global $pdo;
	$stmt_sizes = $pdo->prepare('SELECT * FROM sizes WHERE size_id = :sid ORDER BY size_value ASC');
	$stmt_sizes->bindValue('sid', $size_id, PDO::PARAM_INT);
	$stmt_sizes->execute();
	$row_sizes = $stmt_sizes -> fetch(PDO::FETCH_ASSOC);
	$size_value = $row_sizes['size_value'];
	return $size_value;
}


function sqlCategory(&$sql, $category_id){
	global $pdo;
	if($category_id){
		$sql = $sql."WHERE (category_id = :cid) ";
		return true;
	}
	else{
		return false;
	}
}

function sqlName(&$sql, $bool_category, $name){
	global $pdo;
	if($name){
		if($bool_category){
			$sql = $sql."AND ((name LIKE :name) or (description LIKE :description)) ";
		}
		else{
			$sql = $sql."WHERE ((name LIKE :name) or (description LIKE :description)) ";
		}
		return true;
	}
	else{
		return false;
	}
}

function sqlColor(&$sql,  $bool_category, $bool_name, $colors){
	global $pdo;
	if($colors == null){
		return 0;
	}
	else{
		$sql_colors = "SELECT * FROM colors WHERE";
		$i=0;
		while($i<count($colors)){
			$sql_colors = $sql_colors." color_id = :id_".$colors[$i]." or";
			$i++;
		}
		if($i != 0){
			$sql_colors = substr($sql_colors, 0, -3);
		}
		else{
			$sql_colors = substr($sql_colors, 0, -6);
		}

		$stmt_colors = $pdo->prepare($sql_colors);
		for($j=1;$j<=$i;$j++){
			$id_col = ":id_".$colors[$j-1];
			$stmt_colors->bindValue($id_col, $colors[$j-1], PDO::PARAM_INT);
		}
		$stmt_colors->execute();
		$number_of_colors = $stmt_colors->rowCount();
		
   		if(($bool_category) || ($bool_name)){
			$sql = $sql."AND (";
   		}
   		else{
			$sql = $sql."WHERE (";
   		}
		while($row_colors = $stmt_colors->fetch(PDO::FETCH_ASSOC)){
			$id_of_color = $row_colors['color_id'];
			$color_name = $row_colors['color_name'];
			$sql = $sql."color_id = :col_".$id_of_color." or ";
		}
		$sql = substr($sql, 0, -4);
		$sql = $sql.") ";

		return $number_of_colors;
	}
}

function sqlSize(&$sql,  $bool_category, $bool_name, $int_colors, $sizes){
	global $pdo;
	if($sizes == null){
		return 0;
	}
	else{
		$sql_sizes = "SELECT * FROM sizes WHERE";
		$i=0;
		while($i<count($sizes)){
			$sql_sizes = $sql_sizes." size_id = :id_".$sizes[$i]." or";
			$i++;
		}
		if($i != 0){
			$sql_sizes = substr($sql_sizes, 0, -3);
		}
		else{
			$sql_sizes = substr($sql_sizes, 0, -6);
		}
		//echo "size sql: $sql_sizes<br />";

		$stmt_sizes = $pdo->prepare($sql_sizes);
		for($j=1;$j<=$i;$j++){
			$id_siz = ":id_".$sizes[$j-1];
			$stmt_sizes->bindValue($id_siz, $sizes[$j-1], PDO::PARAM_INT);
		}
		$stmt_sizes->execute();
		$number_of_sizes = $stmt_sizes->rowCount();
		
   		if($bool_category || $bool_name || ($int_colors>0)){
			$sql = $sql."AND (";
   		}
   		else{
			$sql = $sql."WHERE (";
   		}
		while($row_sizes = $stmt_sizes->fetch(PDO::FETCH_ASSOC)){
			$id_of_size = $row_sizes['size_id'];
			$size_value = $row_sizes['size_value'];
			$sql = $sql."size_id = :siz_".$id_of_size." OR ";
		}
		$sql = substr($sql, 0, -4);
		$sql = $sql.") ";

		return $number_of_sizes;
	}
}

function sqlOrder(&$sql, $order_by){
	$order = substr($order_by, 0, -2);
	$sql = $sql."ORDER BY ".$order;
	if('a' == substr($order_by, -1)){
		$sql = $sql." ASC";
	}
	else{
		$sql = $sql." DESC";
	}
}

function showProductLink($row, $admin){
	$name = $row['name'];
	$index = $row['product_index'];
	$category_id = $row['category_id'];
	$id = $row["id"];
			
	$images = getProductImages($index);
	if(!empty($images)){
		$image = $images[0];
	}
	else{
		$image = 'no-photo.jpg';
	}
	echo "<div class='lineHorizontal'></div>";

	if($admin){
		echo "<div class='productsLink'>";
			//-----IMAGE-----//
			echo "<img class='thumbImages' src='photos/thumbs/$image' >";
					
			//-----NAME AND PRICE-----//
			echo "<div class='nameAndPrice'>";
				echo "<a href='product.php?product_id=$id'>";
					echo "<h2>".$name."</h2>";
				echo "</a>";
				$price = number_format($row['net_price'], 2, '.', ',');
				echo "<h3>".$price." zł</h3>";
			echo "</div>";

			//-----DELETE AND EDIT-----//
			echo "<div class='deleteAndEdit'>";
				echo "<a href='doEditProduct.php?product_id=$id'>Edytuj<br /></a>";
				echo "<a href='doDeleteProduct.php?product_id=$id'>Usuń<br /></a>";
			echo "</div>";

			// echo "<div class='clear'></div>";

		echo "</div>";
	}
	else{
		echo "<a href='product.php?product_id=$id'>";
			echo "<div class='productLink'>";
				//-----IMAGE-----//
				echo "<img class='thumbImages' src='photos/thumbs/$image' >";
				
				//-----NAME AND PRICE-----//
				echo "<div class='nameAndPrice'>";
					echo "<h2>".$name."</h2>";
					$price = number_format($row['net_price'], 2, '.', ',');
					echo "<h3>".$price." zł</h3>";
				echo "</div>";
				// echo "<div class='clear'></div>";

			echo "</div>";
		echo "</a>";
	}

	// echo "<div class='clear'></div>";

}

function searchForProducts(&$number_of_rows, $order_by='id_d', $on_page=10, $category_id=null, $page=1, $colors, $sizes, $name, $admin){
	global $pdo;

	$sql = "SELECT * FROM products ";
	//$sql = "SELECT DISTINCT ON product_index * FROM products ";
	$bool_category = sqlCategory($sql, $category_id);
	$bool_name = sqlName($sql, $bool_category, $name);
	$int_colors = sqlColor($sql, $bool_category, $bool_name, $colors);
	$int_sizes = sqlSize($sql, $bool_category, $bool_name, $int_colors, $sizes);
	$sql = $sql."GROUP BY product_index "; 
	sqlOrder($sql, $order_by);

	$stmt_nuber_of_rows = $pdo->prepare($sql);
	if($bool_category){
		$stmt_nuber_of_rows -> bindValue(':cid', $category_id, PDO::PARAM_INT);
	}
	if($bool_name){
		$like_name = "%".$name."%";
		$stmt_nuber_of_rows -> bindValue(':name', $like_name, PDO::PARAM_INT);
		$stmt_nuber_of_rows -> bindValue(':description', $like_name, PDO::PARAM_INT);
	}

	for($i=1;$i<=$int_colors;$i++){
		$col_id = ":col_".$colors[$i-1];
		$stmt_nuber_of_rows->bindValue($col_id, $colors[$i-1], PDO::PARAM_INT);
	}

	for($i=1;$i<=$int_sizes;$i++){
		$siz_id = ":siz_".$sizes[$i-1];
		$stmt_nuber_of_rows->bindValue($siz_id, $sizes[$i-1], PDO::PARAM_INT);
	}
	$stmt_nuber_of_rows->execute();

	$number_of_rows = $stmt_nuber_of_rows->rowCount();

	

	$offset = ($page-1)*$on_page;
	$sql = $sql." LIMIT ".$on_page." OFFSET ".$offset;

	// echo "$sql<br>";                                               /////////////delete///////////////

	$stmt = $pdo->prepare($sql);
	if($bool_category){
		$stmt -> bindValue(':cid', $category_id, PDO::PARAM_INT);
	}
	if($bool_name){
		$like_name = "%".$name."%";

		// echo "like name: $like_name<br>";                                /////////////delete///////////////    
		$stmt -> bindValue(':name', $like_name, PDO::PARAM_INT);
		$stmt -> bindValue(':description', $like_name, PDO::PARAM_INT);
	}

	for($i=1;$i<=$int_colors;$i++){
		$col_id = ":col_".$colors[$i-1];
		$stmt->bindValue($col_id, $colors[$i-1], PDO::PARAM_INT);
	}

	for($i=1;$i<=$int_sizes;$i++){
		$siz_id = ":siz_".$sizes[$i-1];
		$stmt->bindValue($siz_id, $sizes[$i-1], PDO::PARAM_INT);
	}
	$stmt->execute();
	$rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

	return $rows;

	/*
	// ********************   DISPLAY   ******************** //
	if($number_of_rows == 0){
		echo "<h1>Nie znaleziono produktów :(</h1>";
		return 0;
	}

	pagesForm($page, $on_page, $number_of_rows, "index.php");

	$j=0;
	while(($on_page*($page-1)>$j) && ($stmt -> fetch(PDO::FETCH_ASSOC))){
		$j++;
	}
	$i=0;
	while(($row = $stmt -> fetch(PDO::FETCH_ASSOC)) && ($on_page>$i)){

		showProductLink($row, $admin);
		
		$i++;
	}
	return $number_of_rows;*/
}
function getColorStyle($color_value){
	$exp = explode('_', $color_value);
	if($exp[0] == "#other"){
		switch ($exp[1]) {
		case '1':
			$style = "style='	
				background: -webkit-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );  
				background: -moz-linear-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );
				background: -o-linear-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );
				background: -ms-linear-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );
				background: linear-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );'";
			break;
		default:
			# code...
			break;
		}
	}
	else{
		$style = "style='background: ".$color_value.";'";	
	}
	return $style;
}



function searchAndOrderForm($order_by, $on_page, $category_id, $page, $colors, $sizes, $number_of_rows, $source){
	global $pdo;

	// **********************************   SIZES AND COLORS   ************************************ //
	$stmt_size = $pdo->prepare('SELECT * FROM sizes ORDER BY size_value ASC');
	$stmt_size->execute();

	$stmt_color = $pdo->prepare('SELECT * FROM colors');
	$stmt_color->execute();

?>
	<script type="text/javascript">
    function toggle(sDivId) {
    	var oDiv = document.getElementById(sDivId);
    	oDiv.style.display = (oDiv.style.display == "block") ? "none" : "block";
    }
    </script>
<?php

echo "<div class='aboveContainer'>";
	echo "<div class='filters'>"; 
		echo "<form action='getSizesAndColors.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page' method='post'>";
			echo "<div class='textFilters button1'>";
   				echo "<div onclick=\"toggle('allFilters')\"> FILTRY<i class='icon-down-open'></i></div>";
			echo "</div>";	
			echo "<div id='allFilters'>";
				echo "<div Id='colorsAndSizes'>";
					

					// **************************************   COLORS   ******************************** //
					echo "<div class='filter colors'>";
						echo "<div class='filterName textColors'>";
							echo "KOLORY: ";
						
							if(($source == 'index.php') && isset($colors)){
								echo "<a href='uncheckColors.php?page=$page'>";
									echo "<i class='icon-cancel'></i>";
								echo "</a>";
							}
						echo "</div>";

						$i=0;
						$j=1;
						while($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC)){
							$color_name = $row_color['color_name'];
							$color_id = $row_color['color_id'];
							$color_value = $row_color['color_value']; //////////////////////color_value///////////
							$style = getColorStyle($color_value);
							
							echo "<div class='filterSingle singleColor'>";
								echo "<div class='checkboxFilter checkboxColor".$j."'>";
									if((isset($colors[$i])) && ($colors[$i]==$color_id)){
										echo "<input type='checkbox' id='checkboxColor".$j."' checked='checked' name='colors[]' value='$color_id'>";
										$i++;
									}
									else{
										echo "<input type='checkbox' id='checkboxColor".$j."' name='colors[]' value='$color_id'>";
									}
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


					// *******************************************   SIZES   *************************************** //
					echo "<div class='filter sizes'>";

						echo "<div class='filterName textSizes'>";
							echo "ROZMIARY: ";
							if(($source == 'index.php') && isset($sizes)){
								echo "<a href='uncheckSizes.php?page=$page'><i class='icon-cancel'></i></a>" ;
							}
						echo "</div>";
		 	
						$i=0;
						$j=1;
						while($row_size = $stmt_size->fetch(PDO::FETCH_ASSOC)){
							$size_value = $row_size['size_value'];
							$size_id = $row_size['size_id'];
							echo "<div class='filterSingle singleSize'>";
								echo "<div class='checkboxFilter checkboxSize".$j."'>";
									if((isset($sizes[$i])) && ($sizes[$i]==$size_id)){
										echo "<input type='checkbox' id='checkboxSize".$j."' checked='checked' name='sizes[]' value='$size_id'>";
											$i++;
									}
									else{
										echo "<input type='checkbox' id='checkboxSize".$j."' name='sizes[]' value='$size_id'>";
									}
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
				echo "<input type='submit' value='FILTRUJ'>";
			echo "</div>";
		echo "</form>";
	echo "</div>";

		echo "<div class='searchAndOrderForm'>";



			// **********************************   PRODUCTS ON PAGE   ************************************ //
			echo "<div class='onPage'>";
				echo "<div class='textOnPage'>Na stronie:</div>";
				echo "<a href='setOnPage.php?on_page=2'><div class='numberOfProductsOnPage button1'>2</div></a> ";
				echo "<a href='setOnPage.php?on_page=3'><div class='numberOfProductsOnPage button1'>3</div></a> ";
				echo "<a href='setOnPage.php?on_page=10'><div class='numberOfProductsOnPage button1'>10</div></a> ";
			echo "</div>";


			// **********************************   ORDER BY   ************************************ //
			$id_a = 'id_a';
			$id_d = 'id_d';

			$name_a = 'name_a';
			$name_d = 'name_d';

			$price_a = 'net_price_a'; 
			$price_d = 'net_price_d';

			echo "<div class='orderBy'>";
				echo "<div class='textOrderBy'>Sortowanie:</div>";

				if('a' == substr($order_by, -1)){
					echo " <a href='setOrder.php?order_by=$name_d'><div class='singleOrderBy button1'>";
						echo "nazwa <i class='icon-down-open'></i>";
					echo "</div></a> ";

					echo " <a href='setOrder.php?order_by=$price_d'><div class='singleOrderBy button1'>";
						echo "cena <i class='icon-down-open'></i>";
					echo "</div></a> ";

					echo " <a href='setOrder.php?order_by=$id_d'><div class='singleOrderBy button1'>";
						echo "najnowsze</i>";
					echo "</div></a> ";
				}
				else{
					echo " <a href='setOrder.php?order_by=$name_a'><div class='singleOrderBy button1'>";
						echo "nazwa <i class='icon-up-open'></i>";
					echo "</div></a> ";

					echo " <a href='setOrder.php?order_by=$price_a'><div class='singleOrderBy button1'>";
						echo "cena <i class='icon-up-open'></i>";
					echo "</div></a> ";

					echo " <a href='setOrder.php?order_by=$id_a'><div class='singleOrderBy button1'>";
						echo "najstarsze</i>";
					echo "</div></a> ";
				}
			echo "</div>";
			pagesForm($page, $on_page, $number_of_rows, "index.php");

		echo "</div>";
echo "</div>";

// ========================================================!!!  OLD FORM  !!!======================================================== //


	// **********************************   ORDER BY   ************************************ //
	/*$id_a = 'id_a';
	$id_d = 'id_d';

	$name_a = 'name_a';
	$name_d = 'name_d';

	$price_a = 'net_price_a'; 
	$price_d = 'net_price_d';

	echo "<div class='orderBy'>";
		echo "Sortuj według:<br />";

		if('a' == substr($order_by, -1)){
			echo " <a href='".$page."?cat_id=$category_id&order_by=$name_d&on_page=$on_page'>nazwy &darr;</a> ";
			echo " <a href='".$page."?cat_id=$category_id&order_by=$price_d&on_page=$on_page'>ceny &darr;</a> ";
			echo " <a href='".$page."?cat_id=$category_id&order_by=$id_d&on_page=$on_page'>najstarszych</a> ";
		}
		else{
			echo " <a href='".$page."?cat_id=$category_id&order_by=$name_a&on_page=$on_page'>nazwy &uarr;</a> ";
			echo " <a href='".$page."?cat_id=$category_id&order_by=$price_a&on_page=$on_page'>ceny &uarr;</a> ";
			echo " <a href='".$page."?cat_id=$category_id&order_by=$id_a&on_page=$on_page'>najnowszych</a> ";
		}
	echo "</div>";*/


	// **********************************   SIZES AND COLORS   ************************************ //
	/*$stmt_size = $pdo->prepare('SELECT * FROM sizes ORDER BY size_value ASC');
	$stmt_size->execute();

	$stmt_color = $pdo->prepare('SELECT * FROM colors');
	$stmt_color->execute();

	echo "<div class='sizeAndColorForm'>";
		echo "rozmiary: ";
		
		if(($page == 'index.php') && isset($sizes)){
			echo "<a href='uncheckSizes.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page&page=$page'>Odznacz wszystkie</a>" ;
		}

		echo "<form action='getSizesAndColors.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page' method='post'>";
			$i=0;
			while($row_size = $stmt_size->fetch(PDO::FETCH_ASSOC)){
				$size_value = $row_size['size_value'];
				$size_id = $row_size['size_id'];

				if((isset($sizes[$i])) && ($sizes[$i]==$size_id)){
					echo "<input type='checkbox' checked='checked' name='sizes[]' value='$size_id'> $size_value |";
					$i++;
				}
				else{
					echo "<input type='checkbox' name='sizes[]' value='$size_id'> $size_value |";
				}
			}
			echo "<br />";
			echo "kolory: ";
			
			if(($page == 'index.php') && isset($colors)){
				echo "<a href='uncheckColors.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page&page=$page'>Odznacz wszystkie</a>" ;
			}

			//echo "<form method='post' action='' onSubmit='window.location.reload()'>";
				//echo "<input type='checkbox' >";
			//echo "</form>";

			echo "<form action='".$page."?cat_id=$category_id&order_by=$order_by&on_page=$on_page' method='post'>";
			$i=0;
			while($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC)){
				$color_name = $row_color['color_name'];
				$color_id = $row_color['color_id'];

				if((isset($colors[$i])) && ($colors[$i]==$color_id)){
					echo "<input type='checkbox' checked='checked' name='colors[]' value='$color_id'> $color_name |";
					$i++;
				}
				else{
					echo "<input type='checkbox' name='colors[]' value='$color_id'> $color_name |";
				}
			}
			echo "<input type='submit' value='wyszukaj'>";
		echo "</form>";
	echo "</div>";*/




	// **********************************   PRODUCTS ON PAGE   ************************************ //
	/*echo "<div class='onPage'>";
		echo "Na stronie: ";
		echo "<a href='".$page."?cat_id=$category_id&order_by=$order_by&on_page=2'>2</a> ";
		echo "<a href='".$page."?cat_id=$category_id&order_by=$order_by&on_page=3'>3</a> ";
		echo "<a href='".$page."?cat_id=$category_id&order_by=$order_by&on_page=10'>10</a> ";
	echo "</div>";*/
}

function pagesForm($page, $on_page, $number_of_rows, $source){


	// **********************************       PAGES         ************************************ //
	//echo "<div class='pagesForm'>";
	if($number_of_rows != 0){

		echo "<div class='pagesForm'>";
			$pages = $number_of_rows / $on_page;
			if($pages != floor($pages)){
				$pages = floor($pages)+1;
			}
			// echo "strona: ";


			if(1 != $page){
				echo "<a href='".$source."?page=1'><div class='singlePage button1'>";
					echo "<i class='icon-angle-double-left'></i>";
				echo "</div></a> ";
			}
			// else{
			// 	echo "<div class='singlePage singlePageDisabled'>";
			// 		echo "<i class='icon-angle-double-left'></i>";
			// 	echo "</div>";
			// }

			
			if($page>1){
				$prev = $page-1;
				echo "<a href='".$source."?page=$prev'><div class='singlePage button1'>";
					echo "<i class='icon-angle-left'></i>";
				echo "</div></a> ";
			}
			// else{
			// 	echo "<div class='singlePage singlePageDisabled'>";
			// 		echo "<i class='icon-angle-left'></i>";
			// 	echo "</div>";	
			// }

			$i=$page - NUMBER_OF_PAGES; 
			if($i<1){
				$i=1;
			}
			while($i<$page){
				

				echo "<a href='".$source."?page=$i'><div class='singlePage button1'>$i</div></a>";
				$i++;

			}

			echo "<div class='singlePage singlePageDisabled'>$i</div></a>";
			$i++;

			while(($i<NUMBER_OF_PAGES+$page+1) && ($i<=$pages)){
				echo "<a href='".$source."?page=$i'><div class='singlePage button1'>$i</div></a> ";
				$i++;

			}
			// if(($i+NUMBER_OF_PAGES-2) < $pages){
			// 	echo "<div class='singlePage singlePageDisabled'>...</div>";
			// 	echo "<a href='index.php?page=$pages'>";
			// 		echo "<div class='singlePage'>$pages</div>";
			// 	echo "</a> ";
			// 	$bool_double_right = false;
			// }
			// else{
			// 	$bool_double_right = true;
			// 	//echo "<div class='singlePage singlePageDisabled'>$pages</div>";
			// }



			if($page<$pages){
				$next = $page+1;

				echo "<a href='".$source."?page=$next'><div class='singlePage button1'>";
					echo "<i class='icon-angle-right'>";
				echo "</div></i></a>";
			}
			// else{
			// 	echo "<div class='singlePage singlePageDisabled'><i class='icon-angle-right'></i></div>";
			// }

						// echo "z ";
			if($page != $pages){
			// if($bool_double_right){
				echo "<a href='".$source."?page=$pages'><div class='singlePage button1'>";
					echo "<i class='icon-angle-double-right'></i>";
				echo "</div></a> ";
			}
			// else{
			// 	echo "<div class='singlePage singlePageDisabled'>";
			// 		echo "<i class='icon-angle-double-right'></i>";
			// 	echo "</div>";
			// }

			
		echo "</div>";

	// **********************************       PAGES         ************************************ //
	/*if($number_of_rows != 0){
		echo "<br />Wszystkich wyników: $number_of_rows<br />";

		echo "<div class='pages'>";
			$pages = $number_of_rows / $on_page;
			if($pages != floor($pages)){
				$pages =floor($pages)+1;
			}
			echo "strona: ";

			
			if($page>1){
				$prev = $page-1;
				echo "<a href='index.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page&page=$prev'>poprzednia</a> ";
			}
			else{
				echo "poprzednia ";
			}
			$i=$page - NUMBER_OF_PAGES; 
			if($i<1){
				$i=1;
			}
			while($i<$page){
				
				echo "<a href='index.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page&page=$i'>$i</a> ";
				$i++;

			}

			echo "$i ";
			$i++;

			while(($i<NUMBER_OF_PAGES+$page+1) && ($i<=$pages)){
				
				echo "<a href='index.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page&page=$i'>$i</a> ";
				$i++;

			}
			echo "z ";
			if($i != $pages){
				echo "<a href='index.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page&page=$pages'>$pages</a> ";
			}
			else{
				echo "$pages ";
			}

			if($page<$pages){
				$next = $page+1;
				echo "<a href='index.php?cat_id=$category_id&order_by=$order_by&on_page=$on_page&page=$next'>następna</a> ";
			}
			else{
				echo "następna ";
			}
			
		echo "</div>";*/
	}
}

function showSearchResult($product_index, $name, $admin){
	global $pdo;
	$stmt = $pdo->prepare("SELECT * FROM products WHERE product_index = :product_index OR name = :name");
	$stmt->bindValue(':product_index', $product_index, PDO::PARAM_INT);
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	
	$foundProduct = false;
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
		showProductLink($row, $admin);
		$foundProduct = true;
	}
	if($foundProduct != true){
		echo "Nie znaleziono produktu.";
	}
}

function random_session_id(){
	$utime = time();
	$id = random_salt(40 - strlen($utime)).$utime;
	return $id;
}

function random_salt($len){
	return random_text($len);
}

function random_text($len){
	$base = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890';
	$max = strlen($base) - 1;
	$rstring = '';
	mt_srand((double)microtime()*1000000);
	while(strlen($rstring) < $len){
		$rstring.=$base[mt_rand(0,$max)];
	}
	return $rstring;
}





















function send_mail($email,$message,$subject)
 {      
  require_once('mailer/class.phpmailer.php');
  $mail = new PHPMailer();
  $mail->IsSMTP(); 
  $mail->SMTPDebug  = 0;                     
  $mail->SMTPAuth   = true;                  
  $mail->SMTPSecure = "ssl";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port       = 465;             
  $mail->AddAddress($email);
  $mail->Username="yourgmailid@gmail.com";  
  $mail->Password="yourgmailpassword";            
  $mail->SetFrom('you@yourdomain.com','Coding Cage');
  $mail->AddReplyTo("you@yourdomain.com","Coding Cage");
  $mail->Subject    = $subject;
  $mail->MsgHTML($message);
  $mail->Send();
 } 
?>
















