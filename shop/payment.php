<?php
	ob_start();

	require_once('header.php');

	$products_in_cart = $cart->getProductsQuantity();
	if($products_in_cart <= 0){
		header('Location: showCart.php');
		exit;
	}

	echo "<div class='container'>";
	if (isset($_POST['submit'])){
		echo "
			<div class='orderNavigation'>
				<a href='showCart.php'><div class='orderNavActive orderNavCart button1'>Koszyk</div></a>
				<a href='delivery.php'><div class='orderNavActive orderNavDelivery button1'>Dostawa</div></a>
				<a href='orderSummary.php'><div class='orderNavActive orderNavEvidence button1'>Twoje dane</div></a>
				<a href='#'><div class='orderNavActive orderNavPay'>Płatność</div></a>
			</div>
		";
		echo "<div class='lineHorizontal'></div>";
		// echo "submit";


		$delivery_id =  $_POST['delivery_id'];


		$error = false;
		$name =  htmlspecialchars($_POST['name']);
		$name = substr($name, 0, 20);
		$name = ucfirst($name);
		if($name == ''){
			echo "1";
			$error = true;
		}

		$surname =  htmlspecialchars(trim($_POST['surname']));
		$surname = substr($surname, 0, 40);
		$surname = ucfirst($surname);
		if($surname == ''){
			echo "2";

			$error = true;
		}

		$email =  htmlspecialchars($_POST['email']);
		$email = substr($email, 0, 50);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo "3";
			
			$error = true;
		}

		$city =  htmlspecialchars($_POST['city']);
		$city = substr($city, 0, 20);
		$city = ucfirst($city);
		if($city == ''){
			echo "4";
			
			$error = true;
		}

		$postalCode_1 = htmlspecialchars($_POST['postalCode_1']);	
		$postalCode_2 = htmlspecialchars($_POST['postalCode_2']);
		$postalCode = $postalCode_1.'-'.$postalCode_2;

		if (!(preg_match('/^[0-9]{2,2}-[0-9]{3,3}$/', $postalCode))) {
			echo "5";
			
			$error = true;
		}

		$street =  htmlspecialchars($_POST['street']);
		$street = substr($street, 0, 40);
		$street = ucfirst($street);
		if($street == ''){
			echo "6";
			
			$error = true;
		}

		if($error){
			$err = "Coś poszło nie tak. Spróbuj wpisać swoje dane ponownie lub skontaktuj się z nami!";
			header('Location: error.php?err='.$err);
			exit;
		}


		$stmt = $pdo->prepare("INSERT INTO orders (id, name, surname, email, city, postalCode, street, delivery_id) VALUES (null, :name, :surname, :email, :city, :postalCode, :street, :delivery_id)");
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':city', $city, PDO::PARAM_STR);
		$stmt->bindValue(':postalCode', $postalCode, PDO::PARAM_STR);
		$stmt->bindValue(':street', $street, PDO::PARAM_STR);
		$stmt->bindValue(':delivery_id', $delivery_id, PDO::PARAM_STR);
		$stmt->execute();

		$orderId = $pdo->lastInsertId();

		$orderedProducts = $cart->getProducts();

		foreach($orderedProducts as $product){
			$pid = $product['pid'];
			$qty = $product['quantity'];
			$stmt = $pdo->prepare("INSERT INTO ordersproducts (id, order_id, product_id, quantity) VALUES (null, :orderId, :pid, :qty)");
			$stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
			$stmt->bindValue(':pid', $pid, PDO::PARAM_INT);
			$stmt->bindValue(':qty', $qty, PDO::PARAM_INT);
			$stmt->execute();
		}
		$cart->clear();
?>

<style>
#payu-payment-form button[type=submit] {
    border: 0px;
    height: 52px;
    width: 292px;
    background: url('http://static.payu.com/pl/standard/partners/buttons/payu_account_button_long_03.png');
    background-repeat: no-repeat;
    cursor: pointer;
}
</style>
<div id='payu-payment-form'>
<form method="post" action="https://secure.payu.com/api/v2_1/orders">
    <input type="hidden" name="continueUrl" value="http://shop.url/continue">
    <input type="hidden" name="currencyCode" value="PLN">
    <input type="hidden" name="customerIp" value="123.123.123.123">
    <input type="hidden" name="description" value="Order description">
    <input type="hidden" name="merchantPosId" value="145227">
    <input type="hidden" name="notifyUrl" value="http://shop.url/notify">
    <input type="hidden" name="products[0].name" value="Product 1">
    <input type="hidden" name="products[0].quantity" value="1">
    <input type="hidden" name="products[0].unitPrice" value="1000">
    <input type="hidden" name="totalAmount" value="1000">
    <input type="hidden" name="OpenPayu-Signature" value="sender=145227;algorithm=SHA-256;signature=bc94a8026d6032b5e216be112a5fb7544e66e23e68d44b4283ff495bdb3983a8">
    <button type="submit" formtarget="_blank" ></button>
</form >
</div>


<?php

		//                                                                                                        SEND MAIL!!!
		// $headers = 'From: shop@example.com' . "\r\n" .
		//     'Reply-To: webmaster@example.com' . "\r\n" .
		//     'X-Mailer: Owner/';
		// //Send e-mail
		// //mail($email, "Zamówienie numer $orderId", "Potwierdzamy złożenie zamówienia", $headers)
		// 	echo "<h1>Twoje zamówienie zostało zrealizowane!</h1>";

		// }




	echo "</div>";
	}
	else{
		header('Location: orderSummary.php');
		exit;
	}
?>




<?php
require('footer.php');
	ob_end_flush();
?>