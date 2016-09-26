<?php
require_once('header.php');
?>

<?php
if($session->getUser()->isanonymous()){
	require_once('login.php');
}
else{
	echo "<div class='container'>";
	if($session->getUser()->isAdministrator()){
		$stmt = $pdo->prepare('SELECT * FROM colors');
		$stmt->execute();
		echo "<div class='editFilter editColors'>";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$color_name = $row['color_name'];
				$color_id = $row['color_id'];
				$color_value = $row['color_value'];

				$exp = explode('#', $color_value);
				$color_value_final = $exp[1];
				$style = getColorStyle($color_value);
				// echo $color_value;
				echo "<form action='doEditColor.php?color_id=$color_id' method='post'>";
					echo "<div class='singleEditFilter singleEditColor'>";

						echo "<div class='textFilterId textColorId'>$color_id.</div>";
						echo "<input type='text' name='color_name".$color_id."' value='$color_name'>";
						echo "<div class='textHash'>#</div>";
						echo "<input type='text' name='color_value".$color_id."' value='$color_value_final'>";
						echo "<div class='colorStyle' ".$style."></div>";
						echo "<input type='submit' value='Edytuj kolor'>";

						echo "<a href='deleteColor.php?color_id=$color_id'><div class='textDeleteFilterRow textDeleteColor button1'>";
							echo "Usuń kolor";
						echo "</div></a>";

					echo "</div>";
				echo "</form>";
			}
			if(isset($color_id)){
				$color_id++;
			}
			else{
				$color_id = 1;
			}

			echo "<form action='doAddColor.php' method='post'>";
				echo "<div class='singleEditFilter singleEditColor'>";

					echo "<div class='textFilterId textColorId'>$color_id.</div>";
					echo "<input type='text' name='new_color'>";
					echo "<div class='textHash'>#</div>";
					echo "<input type='text' name='color_value'>";
					echo "<input type='submit' value='Dodaj nowy kolor'>";

				echo "</div>";
			echo "</form>";
		echo "</div>";
	}
	echo "</div>";
}

?>

<?php
require('footer.php');
?>



