<?php
require_once('header.php');
         
if(isset($_SESSION['category_id']))
	$category_id = $_SESSION['category_id'];
else
	$category_id = null;

if(isset($_SESSION['order_by']))
	$order_by = $_SESSION['order_by'];
else
	$order_by = 'id_d';

if(isset($_SESSION['on_page']))
	$on_page = $_SESSION['on_page'];
else
	$on_page = 10;	

if(isset($_SESSION['sizes']))
	$sizes = $_SESSION['sizes'];
else
	$sizes = null;

if(isset($_SESSION['colors']))
	$colors = $_SESSION['colors'];
else
	$colors = null;


if(isset($_GET['page']))
	$page = $_GET['page'];
else
	$page = 1;


/*if(isset($_POST['sizes'])){
	$sizes = $_POST['sizes'];
	$_SESSION['sizes'] = $sizes;
}
else{
	$sizes=null;	
	if(!isset($_SESSION['sizes']))
		$_SESSION['sizes'] = $sizes;
	else
		$_SESSION['sizes']=null;
	$sizes = $_SESSION['sizes'];
}



if(isset($_POST['colors'])){
	$colors = $_POST['colors'];
	$_SESSION['colors'] = $colors;
}
else{
	
	$stmt_color = $pdo->prepare('SELECT * FROM colors');
	$stmt_color->execute();

	$i=0; 																			///////KOLORY czy checkować?/////////
	while($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC)){
		$colors[$i] = $row_color['color_id'];
		$i++;
	}
	$colors=null;	
	if(!isset($_SESSION['colors']))
		$_SESSION['colors'] = $colors;
	else
		$_SESSION['colors']=null;
	$colors = $_SESSION['colors'];
}*/











echo "<div class='container'>";
	$admin = false;



////////////////delete///////////////
	$to_do = "-logowanie <br>".
		"-ZMIANA NAZWY admin I NIE UMIESZCZANIE NA GŁÓWNEJ STRONIE LINKU<br>".
		"-editProducts on_page<br>".
		"-produkt powiększanie przy najechaniu<br>".
		"-payu<br>".
		"-wysyłanie email<br>".
		"-podgląd produktu wygląd<br>".
		"-produkt wygląd<br>".
		"-admin naprawić <br>".
		"-edycja wszystkich rozmiarów buta <br>".
		"-logo<br>";		

	//echo $to_do;
	$time = time() - SESSION_COOKIE_EXPIRE;
	//echo time()." - ".SESSION_COOKIE_EXPIRE." = ".$time;
////////////////delete///////////////
	

	$name = null;

	if(isset($_SESSION['main_search_name'])) {
		$name = $_SESSION['main_search_name'];
	}
	$rows = searchForProducts($number_of_rows, $order_by, $on_page, $category_id, $page, $colors, $sizes, $name, $admin); //-IN FUNCTIONS.PHP-//

	searchAndOrderForm($order_by, $on_page, $category_id, $page, $colors, $sizes, $number_of_rows, "index.php");   //-IN FUNCTIONS.PHP-//

	echo "<div class='products'>";
		if($number_of_rows == 0){
			echo "<h1>Nie znaleziono produktów :(</h1>";
		}
		else{
			foreach ($rows as $row) {
				showProductLink($row, $admin);
			}
			echo "<div class='lineHorizontal'></div>";

		}
	echo "</div>";

	echo "<div class='underContainer'>";
		echo "<div class='numberOfRows'>";
			echo "Wszystkich wyników: $number_of_rows<br />";
		echo "</div>";
		pagesForm($page, $on_page, $number_of_rows, "index.php");
	echo "</div>";

	// **********************************       PAGES         ************************************ //
	// if($number_of_rows != 0){
	// 	echo "<br />Wszystkich wyników: $number_of_rows<br />";

	// 	echo "<div class='pages'>";
	// 		$pages = $number_of_rows / $on_page;
	// 		if($pages != floor($pages)){
	// 			$pages =floor($pages)+1;
	// 		}
	// 		echo "strona: ";

			
	// 		if($page>1){
	// 			$prev = $page-1;
	// 			echo "<a href='index.php?page=$prev'> < poprzednia</a> ";
	// 		}
	// 		else{
	// 			echo " < poprzednia ";
	// 		}
	// 		$i=$page - NUMBER_OF_PAGES; 
	// 		if($i<1){
	// 			$i=1;
	// 		}
	// 		while($i<$page){
				
	// 			echo "<a href='index.php?page=$i'>$i</a> ";
	// 			$i++;

	// 		}

	// 		echo "$i ";
	// 		$i++;

	// 		while(($i<NUMBER_OF_PAGES+$page+1) && ($i<=$pages)){
				
	// 			echo "<a href='index.php?page=$i'>$i</a> ";
	// 			$i++;

	// 		}
	// 		echo "z ";
	// 		if($i != $pages){
	// 			echo "<a href='index.php?page=$pages'>$pages</a> ";
	// 		}
	// 		else{
	// 			echo "$pages ";
	// 		}

	// 		if($page<$pages){
	// 			$next = $page+1;
	// 			echo "<a href='index.php?page=$next'>następna > </a> ";
	// 		}
	// 		else{
	// 			echo "następna > ";
	// 		}
			
	// 	echo "</div>";

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
			
		echo "</div>";
	}*/


echo "</div>";
echo "<div class='clear'></div>";
require('footer.php');

?>

