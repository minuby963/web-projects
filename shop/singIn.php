<?php
require_once('header.php');
?>


<?php
echo "<div class='container'>";
	if($session->getUser()->isanonymous()){
		require_once('login.php');
	}
	else{
		if($session->getUser()->isAdministrator()){
			echo "<div class='textAdmin'><h1>Jesteś Adminem!</h1></div>";
			echo "<a href='addProducts.php'><div class='singInLinks button1'>Dodaj produkt</div></a>";
			echo "<a href='editProducts.php'><div class='singInLinks button1'>Edytuj / Usuń produkt</div></a>";
			echo "<a href='editCategories.php'><div class='singInLinks button1'>Dodaj / Edytuj kategorie</div></a>";
			echo "<a href='editColors.php'><div class='singInLinks button1'>Dodaj / Edytuj kolory</div></a>";
			echo "<a href='editSizes.php'><div class='singInLinks button1'>Dodaj / Edytuj rozmiary</div></a>";
			echo "<a href='editDelivery.php'><div class='singInLinks button1'>Dodaj / Edytuj metody dostawy</div></a>";
		}
	}
echo "</div>";
?>

<?php
require_once('footer.php');
?>



