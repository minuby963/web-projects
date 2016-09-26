<?php
	session_start();
?>


<?php

function showAllCategoriesLinks($category_id){
	global $pdo;

	$stmt = $pdo->prepare("SELECT * FROM categories");
	$stmt -> execute();
	echo "<div class='categoriesLinks'>";
			if($category_id != null){
				echo "<li>";
					echo "<a href='setCategory.php'>";
						echo "<div class='categoryLink'>";
							echo "wszystkie kategorie";
						echo "</div>";
					echo "</a>";
				echo "</li>";
			}
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
				$name = $row['name'];
				$id = $row['category_id'];
				

				echo "<li>";
					echo "<a href='setCategory.php?category_id=$id'>";
						echo "<div class='categoryLink'>";
							echo $name;
						echo "</div>";
					echo "</a>";
				echo "</li>";
				//echo "<br />";
			}
	echo "</div>";

}

function showMenu($cart){
	global $pdo, $session;

	if(isset($_SESSION['main_search_name'])){
		$search = $_SESSION['main_search_name'];
		$bool_unset_search = false;
	}
	else{
		$bool_unset_search = true;
	}

	if(isset($_SESSION['category_id'])){
		$category_id = $_SESSION['category_id'];
		$category_name = getCategoryName($category_id);
	}
	else{
		$category_id = null;
		$category_name = "KATEGORIE <i class='icon-down-open'></i>";
	}

	// if(isset($_SESSION['products_in_cart'])){
	// 	$products_in_cart = $_SESSION['products_in_cart'];
	// }
	// else{
	// 	$products_in_cart = 0;
	// }
	$products_in_cart = $cart->getProductsQuantity();

	// $products_in_cart = $cart->getQuantityOfProductsInCart();
	echo " <a href='unsetSession.php'>";
		echo "<div class='logo'>";
			echo "LOGO <br> STRONY";
		echo "</div>";
	echo "</a>";

	echo "<div class='searchForm'>";

		echo "<div class='searchFormMain'>";
			echo "<form action='mainSearch.php' method='post'>";
				if($bool_unset_search){
					echo "<input type='text' name='name' placeholder='Szukaj...'>";

				}
				else{
					echo "<input type='text' name='name' value='$search' />";
					// echo "<div class='line'></div>";

					echo " <a href='unsetSession.php?unset=1'><i class='icon-cancel'></i></a> ";
					// echo "<div class='line'></div>";

				}
				echo "<input type='submit' value='Wyszukaj' hidden />";
			echo "</form>";
		// echo "<div class='line'></div>";

		echo "</div>";



		echo "<div class='searchFormCategories'>";
			echo "<ol>";	
				echo "<li><a href='unsetSession.php'>$category_name</a>";
					echo "<ul>";
						showAllCategoriesLinks($category_id);
					echo "</ul>";
				echo "</li>";
			echo "</ol>";	
		echo "</div>";
	echo "</div>";


	echo "<div class='loginAndCart'>";
		if(!$session->getUser()->isAnonymous()){
			echo "<a href='logout.php'><div class='logIn button1'>Wyloguj</div></a>";

			if($session->getUser()->isAdministrator()){
				echo "<a href='singIn.php'><div class='logIn button1'>Panel</div></a><br />";
			}
		}
		else{echo "<a href='login.php'><div class='logIn button1'>";
				echo "zaloguj się";// NIE UMIESZCZANIE NA GŁÓWNEJ STRONIE TEGOŻ LINKU//
			echo "</div></a>";
		}
		// echo "<div id='demo'></div>";
		echo "<a href='showCart.php'><div class='cartIcon button1'>koszyk ($products_in_cart)</div></a> ";
	echo "</div>";


	//echo "<div class='clear'></div>";


}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
		<meta charset="utf-8"/>
		<title>menu</title>
		<meta name="description" content="description"/>
		<meta name="keywords" content="keywords"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="dist/css/lightbox.min.css" type="text/css" />

		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />

</head>
<script src='dist/js/lightbox-plus-jquery.js'></script>
<body>
<?php
//echo "<script src='dist/js/lightbox-plus-jquery.js'></script>";

	echo "";

	require('functions.php');

	require('sessions.php');
	require('request.php');
	require('user.php');

	require('cart.php');
	try{
		$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sklep','root','');
		//$pdo = new PDO('mysql:host=mysql.cba.pl;port=3306;dbname=butywsklepie','butywsklepie','sklepzbutami');
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo -> exec("SET NAMES 'utf8'");
	}
	catch(PDOException $e){
		echo 'Połączenie nie mogło zostać utworzone: '.$e->getMessage();
		exit;
	}

	$request = new userRequest();
	$session = new session();
	$cart = new cart();
?>

	<div class="menu">
		<?php showMenu($cart); ?>
	</div>
	<div class="menuMargin"></div>

	<script src="jQuery-3.1.0.js"></script>

	<script type="text/javascript">
	
		$('.menu').addClass('static');
	

		$(document).ready(function() {
			var stickyNavTop = 1; //$('.menu').offset().top;

			var stickyNav = function(){
				var scrollTop = $(window).scrollTop();

				if(scrollTop > stickyNavTop){
					$('.menu').addClass('sticky');
					$('.menu').removeClass('static');
					$('.logo').addClass('smallLogo');
					$('.loginAndCart').addClass('smallLoginAndCart');
					$('.searchForm').addClass('smallSearchForm');
					$('.searchFormMain').addClass('smallSearchFormMain');


				}
				else{
					$('.menu').removeClass('sticky');
					$('.menu').addClass('static');
					$('.logo').removeClass('smallLogo');
					$('.loginAndCart').removeClass('smallLoginAndCart');
					$('.searchForm').removeClass('smallSearchForm');
					$('.searchFormMain').removeClass('smallSearchFormMain');


				}
			};

			stickyNav();

			$(window).scroll(function() {
				stickyNav();
			});


			$(".menu").hover(
				function(){
					var scrollTop = $(window).scrollTop();
					if(scrollTop>1){
						$('.logo').removeClass('smallLogo');
						$('.loginAndCart').removeClass('smallLoginAndCart');
						$('.searchForm').removeClass('smallSearchForm');
						$('.searchFormMain').removeClass('smallSearchFormMain');


					}
				}, 
				function(){
					var scrollTop = $(window).scrollTop();
					if(scrollTop>1){
						$('.logo').addClass('smallLogo');
						$('.loginAndCart').addClass('smallLoginAndCart');
						$('.searchForm').addClass('smallSearchForm');
						$('.searchFormMain').addClass('smallSearchFormMain');

						


					}
				}
			);
		});






	</script>
	

