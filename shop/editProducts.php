<?php
require('header.php');

if(isset($_GET['s']))
	session_unset();

if(isset($_GET['cat_id']))
	$category_id = $_GET['cat_id'];
else
	$category_id=null;

if(isset($_GET['order_by']))
	$order_by = $_GET['order_by'];
else
	$order_by='id_d';

if(isset($_GET['page']))
	$page = $_GET['page'];
else
	$page=1;


if(isset($_GET['on_page'])){
	$on_page = $_GET['on_page'];
	$_SESSION['on_page'] = $on_page;
}
else{
	if(isset($_SESSION['on_page']))
		$on_page = $_SESSION['on_page'];
	else
		$on_page=10;	
}

if(isset($_POST['sizes'])){
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
	$colors=null;	
	if(!isset($_SESSION['colors']))
		$_SESSION['colors'] = $colors;
	else
		$_SESSION['colors']=null;
	$colors = $_SESSION['colors'];
}
?>

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){
		$admin = true;
		echo "<div class='editProducts'>";
			echo "<form action='editProducts.php' method='post'>";
				echo "Index: <input type='text' name='index'><br />";
				echo "Nazwa: <input type='text' name='name'><br />";
				echo "<input type='submit' value='Wyszukaj'>";
			echo "</form>";
		echo "</div>";
		echo "<div class='clear'></div>";


		$stmt = $pdo->prepare("SELECT * FROM categories");
		$stmt->execute();

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo" Kategorie: <br />";

		$stmt = $pdo->prepare("SELECT * FROM categories");
		$stmt -> execute();

		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
			$name =  $row['name'];
			$id = $row['category_id'];
			echo "<a href='editProducts.php?cat_id=$id'>$name</a> ";
			//echo "<br />";
		}
		echo "<br />";


		searchAndOrderForm($order_by, $on_page, $category_id, $page, $colors, $sizes, "editProducts.php");//-IN FUNCTIONS.PHP-//
		$name = null;
		/*if(isset($_SESSION['edit_search_name'])) {
			$name = $_SESSION['edit_search_name'];
			unset($_SESSION['edit_search_name']);
			showSearchResult("", $name, $admin);
		}*/
	

		if((isset($_POST['index']) && ($_POST['index'] != '')) || (isset($_POST['name']) && ($_POST['name'] != ''))) {
			$product_index = $_POST['index'];
			$name = $_POST['name'];
			showSearchResult($product_index, $name);

		}
		else{
			echo "<div class='products'>";
	  			$number_of_rows = showCategory($order_by, $on_page, $category_id, $page, $colors, $sizes, $name, $admin);   //-----IN FUNCTIONS.PHP-----//
			echo "</div>";
		}
	}
}

?>

<?php
require('footer.php');
?>



