<?php
require('header.php');
?>
<div class='order'>
	<h1>Podaj dane</h1>
	<form action='orderSummary.php' method='post'>
		Imię: <input type='text' name='name' maxlength='20'><br />
		Nazwisko: <input type='text' name='surname' maxlength='40'><br />
		E-mail: <input type='text' name='email' maxlength='50'><br />
		Miasto: <input type='text' name='city' maxlength='20'><br />
		Kod pocztowy: <input type='text' name='postalCode_1' maxlength='2'>-<input type='text' name='postalCode_2' maxlength='3'><br />
		Ulica i numer: <input type='text' name='street' maxlength='40'><br />
		<input type='submit' value='zamawiam!'>
	</form>
</div>";

<?php
require('footer.php');
?>



