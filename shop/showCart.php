<?php
require_once('header.php');
?>
<div class='container showCartContainer'>
<?php

	$inCart = $cart->getProducts();
	//var_dump($inCart);
	$products_in_cart = 0;
	if(!empty($inCart)){

		echo "
			<div class='orderNavigation'>
				<a href='#'><div class='orderNavActive orderNavCart button1'>Koszyk</div></a>
				<a href='delivery.php'><div class='orderNavActive orderNavDelivery button1'>Dostawa</div></a>
				<div class='orderNav orderNavEvidence'>Twoje dane</div>
				<div class='orderNav orderNavPay'>Płatność</div>
			</div>
		";
		echo "<div class='lineHorizontal'></div>";



		$price = 0;
		echo "<div class='cartTable'>";
		echo "<table>
			<tr>
				<th><div class='uppercase'>Produkt</div></th>
				<th><div class='uppercase'>Nazwa</div></th>
				<th><div class='uppercase'>Rozmiar</div></th>
				<th><div class='uppercase'>Cena</div></th>
				<th><div class='uppercase'>Ilość </div></th>
				<th><div class='uppercase'>Cena razem</div></th>
			</tr>";
			

		foreach($inCart as $product){

			$productCartId = $product['id'];
			$net_price = $product['net_price'];
			$quantity = $product['quantity'];
			$index = $product['product_index'];
			$name = $product['name'];
			$size_id = $product['size_id'];

			$size_value = getSizeValue($size_id);

			$id = $product['pid'];


			$images = getProductImages($index);
			if(!empty($images)){
				$image = $images[0];
			}
			else{
				$image = 'no-photo.jpg';
			}
			

			$net_price = number_format($net_price, 2, '.', ',');
			$price = $price + $quantity * $net_price;
			$price = number_format($price, 2, '.', ',');
			$net_price_multiple_quantity = $quantity * $net_price;
			$net_price_multiple_quantity = number_format($net_price_multiple_quantity, 2, '.', ',');

			echo "<tr>";
				echo "<th><div class='showCartPicture'><img class='thumbImages' src='photos/thumbs/$image'></div></th>";
				echo "<th><div class='cartTextName'>";
					echo "<a href='product.php?product_id=$id'>$name</a>";
				echo "</div><div class='cartTextId'>id: $id</div></th>";
				echo "<th><div class='cartTextSize'>$size_value</div></th>";
				echo "<th><div class='cartTextPrice'>$net_price zł</div></th>";
				echo "<th><div class='productQuantity'>";
					echo "<a href='remFromCart.php?id=$id'><div class='textMinus textChangeQuantity button1'>minus</div></a>";
					echo "<div class='textQuatity'>$quantity</div>";
					echo "<a href='addToCart.php?id=$id'><div class='textPlus textChangeQuantity button1'>plus</div></a>";
				echo "</div></th>";

				echo "<th><div class='cartTextPriceMultipleQuantity'>$net_price_multiple_quantity zł</div></th>";
			echo "</tr>";


			$products_in_cart = $products_in_cart+$quantity;
		}
		echo "</table>";
		echo "</div>";
		echo "<div class='lineHorizontal'></div>";

		echo "<div class='cartSummary'>";
			echo "<div class='cartTextFinalpPrice'>Cena zakupów: $price zł</div>";
			echo "<a href='delivery.php'><div class='textDelivery button1'>Dostawa</div></a>";
		echo "</div>";
	}
	else{
		echo "<div class='textEmptyCart'>Koszyk jest pusty.</div>";
		echo "<a href='index.php'><div class='indexLink button1'>Rozpocznij zakupy!</div></a>";
	}

	// echo $cart->getProductsQuantity();
	// echo $products_in_cart;
	// $_SESSION['products_in_cart'] = $products_in_cart;
	// $_SESSION['price'] = $price;

	
?>
</div>

<?php
require('footer.php');
?>



