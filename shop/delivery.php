<?php
require('header.php');
?>
<div class='container deliveryContainer'>
<?php

	// $inCart = $cart->getProducts();
	$products_in_cart = $cart->getProductsQuantity();

	//var_dump($inCart);
	$price = $cart->getProductsPrice();
	$price = number_format($price, 2, '.', ',');

	if($products_in_cart > 0){

		echo "
			<div class='orderNavigation'>
				<a href='showCart.php'><div class='orderNavActive orderNavCart button1'>Koszyk</div></a>
				<a href='#'><div class='orderNavActive orderNavDelivery button1'>Dostawa</div></a>
				<div class='orderNav orderNavEvidence'>Twoje dane</div>
				<div class='orderNav orderNavPay'>Płatność</div>
			</div>
		";
		echo "<div class='lineHorizontal'></div>";

		echo "<div class='textChooseDeliveryMethod'>Wybierz sposób dostawy</div>";





		echo "<div class='deliveryTable'>";
			echo "<table>
				<tr>
					<th><div class='uppercase'>przesyłka</div></th>
					<th><div class='uppercase'>płatne</div></th>
					<th><div class='uppercase'>cena przesyłki</div></th>
					<th><div class='uppercase'>cena z przesyłką</div></th>
					<th><div class='uppercase'>wybierz</div></th>
				</tr>";


			

			$stmt = $pdo->prepare('SELECT * FROM delivery');
			$stmt->execute();

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

				$delivery_id = $row['id'];
				$delivery_method = $row['delivery_method'];
				$payment_method = $row['payment_method'];

				$delivery_price = $row['delivery_price'];
				$delivery_price = number_format($delivery_price, 2, '.', ',');

				$final_price = $price + $delivery_price;
				$final_price = number_format($final_price, 2, '.', ',');


			
				echo "
					<tr>
						<th><div class='textDelivery'>$delivery_method</div></th>
						<th><div class='textPaymentMethod'>$payment_method</div></th>
						<th><div class='textDeliveryPrice'>$delivery_price zł</div></th>
						<th><div class='textFinalPrice'>$final_price zł</div></th>
						<th><a href='orderSummary.php?delivery=".$delivery_id."'><div class='textOrder button1'>złóż zamówienie</div></a></th>
					</tr>";

			}
			echo "</table>";
		echo "</div>";

		// echo "<div class='lineHorizontal'></div>";

		// echo "<div class='cartSummary'>";
		// 	echo "<div class='cartTextFinalpPrice'>Cena zakupów: $price zł</div>";
		// 	echo "<a href='orderSummary.php'><div class='textOrder button1'>Złóż zamówienie</div></a>";
		// echo "</div>";
	}
	else{
		header('Location: showCart.php');
		exit;
	}
	
?>
</div>

<?php
require('footer.php');
?>



