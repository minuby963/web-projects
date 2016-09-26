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
		$stmt = $pdo->prepare('SELECT * FROM sizes ORDER BY size_value ASC');
		$stmt->execute();

		echo "<div class='editFilter editSizes'>";

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$size_value = $row['size_value'];
				$size_id = $row['size_id'];
				
				echo "<form action='doEditSize.php?size_id=$size_id' method='post'>";
					echo "<div class='singleEditFilter singleEditSize'>";
						
						echo "<div class='textFilterId textSizeId'>$size_id.</div>";
						echo "<input type='text' name='$size_id' value='$size_value'>";
						echo "<input type='submit' value='Edytuj rozmiar'> ";

						echo "<a href='deleteSize.php?size_id=$size_id'><div class='textDeleteFilterRow textDeleteSize button1'>";
							echo "Usuń rozmiar";
						echo "</a></div>";

					echo "</div>";
				echo "</form>";

			}
			$size_id++;
			echo "<form action='doAddSize.php' method='post'>";
				echo "<div class='singleEditFilter singleEditSize'>";

					echo "<div class='textFilterId textSizeId'>$size_id.</div>";
					echo "<input type='text' name='new_size'>";
					echo "<input type='submit' value='Dodaj nowy rozmiar'>";
					
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



