<?php
	require_once('header.php');

	$products_in_cart = $cart->getProductsQuantity();
	if($products_in_cart <= 0){
		header('Location: showCart.php');
		exit;
	}

	if(!isset($_GET['delivery'])){
		$err="Nie wybrano metody dostawy!";
		header('Location: error.php?err='.$err);
		exit;
	}
	else{
		$delivery_id = $_GET['delivery'];
	}
?>
<script src="checkOrderForm.js"></script>

<?php
function orderForm($delivery_id){
echo "
<div class='orderForm'>

	<div class='textGiveData'>Podaj dane: </div>
	<form action='payment.php' method='post'>
		<input type='text' name='delivery_id' value='$delivery_id' hidden>
		<input type='text' id='nameForm' name='name' maxlength='30' onchange='checkName()' oninput='enableSubmitInput(0)' placeholder='Imię'><br>
		<div class='nameError formError'></div>

		<input type='text' id='surnameForm' name='surname' maxlength='40' onchange='checkSurname()' oninput='enableSubmitInput(1)' placeholder='Nazwisko'><br>
		<div class='surnameError formError'></div>


		<input type='text' id='emailForm' name='email' maxlength='50' onchange='checkEmail()' oninput='enableSubmitInput(2)' placeholder='E-mail' ><br>
		<div class='emailError formError'></div>

		<input type='text' id='cityForm' name='city' maxlength='40' onchange='checkCity()' oninput='enableSubmitInput(3)' placeholder='Miasto'><br>
		<div class='cityError formError'></div>


		
		<div class='orderPostalCodeForm'>
			<div class='textPostalCode'>Kod pocztowy:</div> 
			<input type='text' id='postalCode1Form' name='postalCode_1' maxlength='2' onchange='checkPostalCode1()' oninput='enableSubmitInput(4)' placeholder='XX'>
			<div class='textPostalCode'>-</div>
			<input type='text' id='postalCode2Form' name='postalCode_2' maxlength='3' onchange='checkPostalCode2()' oninput='enableSubmitInput(5)' placeholder='XXX'>
		</div>
		<div class='postalCode1Error formError'></div>
		<div class='postalCode2Error formError'></div>
		
		<input type='text' id='streetForm' name='street' maxlength='50' onchange='checkStreet()' oninput='enableSubmitInput(6)' placeholder='Ulica i numer'><br>
		<div class='streetError formError'></div>

		<input type='submit' name='submit' id='submitForm' value='zamów' disabled>
	</form>
	";
}
?>




<?php




echo "<div class='container'>";


	echo "
		<div class='orderNavigation'>
			<a href='showCart.php'><div class='orderNavActive orderNavCart button1'>Koszyk</div></a>
			<a href='delivery.php'><div class='orderNavActive orderNavDelivery button1'>Dostawa</div></a>
			<a href='#'><div class='orderNavActive orderNavEvidence button1'>Twoje dane</div></a>
			<div class='orderNav orderNavPay'>Płatność</div>
		</div>
	";
	echo "<div class='lineHorizontal'></div>";
	
	orderForm($delivery_id);

echo "</div>";

?>


<?php
require('footer.php');
?>