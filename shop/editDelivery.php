<?php
require('header.php');
?>

<div class="container">

<?php
if($session->getUser()->isanonymous()){
	require('login.php');
}
else{
	if($session->getUser()->isAdministrator()){
		$stmt = $pdo->prepare('SELECT * FROM delivery');
		$stmt->execute();

		echo "<div class='editFilter editDelivery'>";

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$delivery_id = $row['id'];
				$delivery_method = $row['delivery_method'];
				$payment_method = $row['payment_method'];
				$delivery_price = $row['delivery_price'];

				
				echo "<form action='doEditDelivery.php?delivery_id=$delivery_id' method='post'>";
					echo "<div class='singleEditFilter singleEditDelivery'>";
						
						echo "<div class='textFilterId textDeliveryId'>$delivery_id.</div>";
						echo "<input type='text' name='delivery_method".$delivery_id."' value='$delivery_method'>";
						echo "<input type='text' name='payment_method".$delivery_id."' value='$payment_method'>";
						echo "<input type='text' name='delivery_price".$delivery_id."' value='$delivery_price'>";
						echo "<input type='submit' value='Edytuj metodę dostawy'> ";

						echo "<a href='deleteDelivery.php?delivery_id=$delivery_id'>";
							echo "<div class='textDeleteFilterRow textDeleteDelivery button1'>";
								echo "Usuń rozmiar";
							echo "</div>";
						echo "</a>";

					echo "</div>";
				echo "</form>";

			}
			$delivery_id++;
			echo "<form action='doAddDelivery.php' method='post'>";
				echo "<div class='singleEditFilter singleEditDelivery'>";

					echo "<div class='textFilterId textDeliveryId'>$delivery_id.</div>";
					echo "<input type='text' name='new_delivery_method'>";
					echo "<input type='text' name='new_payment_method'>";
					echo "<input type='text' name='new_delivery_price'>";
					echo "<input type='submit' value='Dodaj nową metodę dostawy'>";
					
				echo "</div>";
			echo "</form>";

		echo "</div>";
	}
}

?>
</div>
<?php
require('footer.php');
?>



