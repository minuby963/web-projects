

<?php
require_once('header.php');
?>


			<script>
				function enable(){
					document.getElementById("add_to_cart").disabled = false;				// poprawić gdy cofam do strony //
				}
			</script>


<!-- 
<html>
<head>
<title>Galeria</title>
<script type="text/javascript">
var zdjecia = Array(
	Array('duze zdjecie', 'miniaturka', 'tytul', 'opis')
	// Array('photos/Cat1_3_Col2-1.jpg', 'Cat1_3_Col2-1', 'tytul', 'opis')

);
var max_width = 520;
function laduj() {
	for(var i = 0; i < zdjecia.length; i++)
		document.getElementById('miniaturki').innerHTML += '<img src="' + zdjecia[i][1] + '" onclick="zmien(' + i + ')" />';
	zmien(0);
}
function zmien(id) {
	document.getElementById('zdjecie').innerHTML += '<div id="ladowanie"></div>';
	var custom = '';
	var preload = new Image();
	preload.onload = function() {
		if(preload.width > max_width) 
			custom = ' style="height: '+(Math.floor(max_width / (preload.width / preload.height)))+'px;width:'+max_width+'px;"';
			
		document.getElementById('informacje').innerHTML = '<b>'+zdjecia[id][2]+'</b><br /><i>'+zdjecia[id][3]+'</i>';
		document.getElementById('zdjecie').innerHTML = '<img src="'+zdjecia[id][0]+'"'+custom+' />';
	}
	preload.src = zdjecia[id][0];
}
window.onload = laduj;
</script>
<style type="text/css">
#ladowanie {
	display: block;
	position: absolute;
	top: 0;
	_top: 50%; /* IE */
	left: 0;
	width: 100%;
	height: 100%;
	background: url('loading.gif') no-repeat center center;
}
#zdjecie, #miniaturki {
	width: 520px;
	position: relative;
}
#miniaturki img {
	margin: 5px;
	cursor: pointer;
}
</style>
</head>
<body>
<h2>Galeria</h2>
<div id="informacje"></div>
<div id="zdjecie"></div>
<div id="miniaturki"></div>
</body>
</html>



<script type='text/javascript'>
		var pictures = Array(
			Array('picture', 'miniature', 'title', 'description')
			Array('photos/Cat1_3_Col2-1', 'photos/thumbs/Cat1_3_Col2-1', 'title', 'description')

		);
		var max_width = 520;

		function loadPictures() {
			for(var i = 0; i < pictures.length; i++){
				document.getElementById('miniatures').innerHTML+='<img src="'+pictures[i][1]+'" onclick="change('+i+')"/>';
				change(0);
			}
		}

		function change(id){
			document.getElementById('picture').innerHTML+= '<div id="loading"></div>';
			var custom = '';
			var preload = new Image();

			preload.onload = function() {
				if(preload.width > max_width){
					custom = 'style="height: '+(Math.floor(max_width / (preload.width / preload.height)))+'px; width: '+max_width+'px;"';
				}
				document.getElementById('info').innerHTML = '<b>'+pictures[id][2]+'</b><br><i>'+pictures[id][3]+'</i>'; 
				document.getElementById('picture').innerHTML = '<img src="'+pictures[id][0]+'"'+custom+' />';
			}
			preload.src = pictures[id][0];
		}

		window.onload = loadPictures;


	</script>


<script type="text/javascript">
var zdjecia = Array(
	Array('photos/Cat1_3_Col2-1', "photos/thumbs/Cat1_3_Col2-1", 'tytul', 'opis')

	Array('duze zdjecie', 'miniaturka', 'tytul', 'opis')
	Array('photos/Cat1_3_Col2-', "photos/thumbs/Cat1_3_Col2-", 'tytul', 'opis')
);
var max_width = 520;
function laduj() {
	for(var i = 0; i < zdjecia.length; i++)
		document.getElementById('miniaturki').innerHTML += '<img src="' + zdjecia[i][1] + '" onclick="zmien(' + i + ')" />';
	zmien(0);
}
function zmien(id) {
	document.getElementById('zdjecie').innerHTML += '<div id="ladowanie"></div>';
	var custom = '';
	var preload = new Image();
	preload.onload = function() {
		if(preload.width > max_width) 
			custom = ' style="height: '+(Math.floor(max_width / (preload.width / preload.height)))+'px;width:'+max_width+'px;"';
			
		document.getElementById('informacje').innerHTML = '<b>'+zdjecia[id][2]+'</b><br /><i>'+zdjecia[id][3]+'</i>';
		document.getElementById('zdjecie').innerHTML = '<img src="'+zdjecia[id][0]+'"'+custom+' />';
	}
	preload.src = zdjecia[id][0];
}
window.onload = laduj;
</script>
<style type="text/css">
#ladowanie {
	display: block;
	position: absolute;
	top: 0;
	_top: 50%; /* IE */
	left: 0;
	width: 100%;
	height: 100%;
	background: url('loading.gif') no-repeat center center;
}
#zdjecie, #miniaturki {
	width: 520px;
	position: relative;
}
#miniaturki img {
	margin: 5px;
	cursor: pointer;
}
</style> -->

<?php

function showProductCategory($category_id){
	global $pdo;

	$stmt_category = $pdo->prepare("SELECT * FROM categories WHERE category_id = :cid");
	$stmt_category->bindValue(':cid', $category_id, PDO::PARAM_INT);
	$stmt_category->execute();

	$row_category = $stmt_category->fetch(PDO::FETCH_ASSOC);
	$category_name = $row_category['name'];

	// echo "Kategoria: $category_name<br />";

}

		
function showProductColors($product_index){
	global $pdo;

	$stmt_color = $pdo->prepare('SELECT * FROM colors');
	$stmt_color->execute();


	$product_color_rows = getOtherColorsOfProduct($product_index);

	$rows_color = $stmt_color->fetchAll(PDO::FETCH_ASSOC);
	echo "<div class='textAvailableColors'>Dostępne kolory:</div>";
	echo "<div class='availableProductColors'>";

		foreach ($product_color_rows as $product_color_row) {

			$product_id = $product_color_row['id'];
			$color_id = $product_color_row['color_id'];
			$style = getColorStyle(getColorValue($color_id));
			echo "<a href='product.php?product_id=$product_id'><div class='colorStyle colorStyleLink' ".$style."></div></a>";

		}

	echo "</div>";
	echo "<div class='clear'></div>";
} 

function showProductSizes($product_index, $id){
	global $pdo;

	$stmt_product = $pdo->prepare('SELECT s.size_value, p.size_id FROM sizes s LEFT OUTER JOIN products p ON (s.size_id = p.size_id) WHERE product_index = :product_index ORDER BY s.size_value ASC');
	$stmt_product->bindValue(':product_index', $product_index, PDO::PARAM_STR);
	$stmt_product->execute();
	

	echo "<form action='addToCart.php?id=$id' method='post'>";
		echo "<div class='productChooseSize filter sizes'>";

			echo "<div class='filterName textSizes'>";
				echo "Wybierz rozmiar: ";
			echo "</div>";
			
			$j=1;
			echo "<div class='sizeRadios'>";
				while($row = $stmt_product->fetch(PDO::FETCH_ASSOC)){
					$size_id = $row['size_id'];
					$size_value = $row['size_value'];

					echo "<div class='filterSingle singleSize'>";
						echo "<div class='checkboxFilter checkboxSize".$j."'>";
							echo "<input type='radio' id='checkboxSize".$j."' onclick='enable()' name='size' value='$size_id'>";
							echo "<label for='checkboxSize".$j."' style='background: #9DADB3;'></label>";
						echo "</div>";
						echo "<div class='checkboxFilterName checkboxSizeName'>";
							echo "$size_value";
						echo "</div>";
					echo "</div>";
					$j++;
				}
			echo "</div>";
			echo "<input type='submit' id='add_to_cart' value='Dodaj do koszyka' disabled>";

		echo "</div>";
	echo "</form>";
}


function showProductPictures($index){
	echo "<div id='mainPicture'>";
	echo "</div>";
	echo "<div class='pictures'>";
		$i = 1;
		foreach (getProductImages($index) as $image) {
			echo "<a data-lightbox='category' href='photos/$image'>";
				
				echo "<div class='picture'>";
					echo "<img src='photos/$image' onclick='change(".$i.")'>";
				echo "</div>";
				
				// echo "<div class='picture photo' id='photo-".$image."'>";
				// 	echo "<img src='photos/$image'>";
				// echo "</div>";
			echo "</a>";
			$i++;
		}
	echo "</div>";
}

function showProductPrice($price){
	$price_final = number_format($price, 2, '.', ',');
	echo "<div class='productPrice'>";
		echo "$price_final zł";
	echo "</div>";
}
function showProductDescription($description){
	echo "<div class='productDescription'>";
		echo "$description";
	echo "</div>";
}

function showProduct($id){
	global $pdo;
	
	$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();

	if($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
		$name = $row['name'];
		$category_id = $row['category_id'];
		$product_index = $row['product_index'];
		$price = $row['net_price'];
		$id = $row['id'];
		$description = $row['description'];


		echo "<h2>".$name."</h2>";

		// echo "<div class='lineHorizontal'></div>";
		echo "<div class='productContent'>";
			showProductPictures($product_index);
			
			echo "<div class='productInfo'>";
				showProductColors($product_index);
		echo "<div class='lineHorizontal'></div>";

				showProductPrice($price);
				showProductDescription($description);
		echo "<div class='lineHorizontal'></div>";

				showProductSizes($product_index, $id);
				// echo "$id";
			echo "</div>";

		echo "</div>";
	}
	else{
		header('Location: index.php');
		exit;
	}
?>


	

<?php


		//showProductCategory($category_id);     																		//dodać//
		//showProductSizes($product_index);																			//dodać//

		

	
/*
<script type="text/javascript">
var zdjecia = Array(
	Array('duze zdjecie', 'miniaturka', 'tytul', 'opis')
	// Array('photos/Cat1_3_Col2-1.jpg', 'Cat1_3_Col2-1', 'tytul', 'opis')

);
var max_width = 520;
function laduj() {
	for(var i = 0; i < zdjecia.length; i++)
		document.getElementById('miniaturki').innerHTML += '<img src="' + zdjecia[i][1] + '" onclick="zmien(' + i + ')" />';
	zmien(0);
}
function zmien(id) {
	document.getElementById('zdjecie').innerHTML += '<div id="ladowanie"></div>';
	var custom = '';
	var preload = new Image();
	preload.onload = function() {
		if(preload.width > max_width) 
			custom = ' style="height: '+(Math.floor(max_width / (preload.width / preload.height)))+'px;width:'+max_width+'px;"';
			
		document.getElementById('informacje').innerHTML = '<b>'+zdjecia[id][2]+'</b><br /><i>'+zdjecia[id][3]+'</i>';
		document.getElementById('zdjecie').innerHTML = '<img src="'+zdjecia[id][0]+'"'+custom+' />';
	}
	preload.src = zdjecia[id][0];
}
window.onload = laduj;*/

?>
<script type="text/javascript">
	// function change(id) {
	// 	document.getElementById('mainPicture').innerHTML += 'aaaaaaaa';
	// }

	// $(document).ready(function() {

	// 	$('.picture').mouseover(function() {
	// 		$(this).addClass('disablePic');
	// 		id = "photo-"+this.id;
	// 		// alert(id);
	// 		$(id).removeClass('disablePic');
	// 		document.getElementById('id').innerHTML = 'ajhefia';
	// 		document.getElementById(id).innerHTML = 'a';
		   
	// 	});

		// $(".picture").mouseleave(handler);

		// $(".picture").hover(
		// 	function(){
		// 		// $('.picture').display = none;
		// 		$('.thumb').removeClass('enablePic');
		// 		$('.thumb').addClass('disablePic');
		// 		$('.photo').removeClass('disablePic');
		// 		$('.photo').addClass('enablePic');

		// 		// document.getElementByClassName('thumb').innerHTML = "<img src=''>"


		// 	}, 
		// 	function(){
		// 		$('.thumb').removeClass('diablePic');
		// 		$('.thumb').addClass('enablePic');
		// 		$('.photo').removeClass('enablePic');
		// 		$('.photo').addClass('diablePic');
				
		// 	}
		// );
	// });

</script>

<?php

		//echo "<a href='addToCart.php?id=$id'>Dodaj do koszyka</a></br></br>";
		// echo $row['description'];
		//var_dump($row);
	}
// }
?>


<?php
	echo "<div class='container'>";
		if(isset($_GET['product_id'])){
			echo "<script src='dist/js/lightbox-plus-jquery.js'></script>";
			echo "<div class='product'>";
				showProduct($_GET['product_id']);
			echo "</div>";
			echo "<div class='clear'></div>";
			
		}
		else{
			header('Location: index.php');
			exit;
		}
	echo "</div>";
?>


<?php
	require('footer.php');
?>