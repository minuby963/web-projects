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
		$stmt = $pdo->prepare('SELECT * FROM categories');
		$stmt->execute();
		echo "<div class='editFilter editCategories'>";

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$category_name = $row['name'];
				$category_id = $row['category_id'];
				
				echo "<form action='doEditCategory.php?category_id=$category_id' method='post'>";
					echo "<div class='singleEditFilter singleEditCategory'>";

						echo "<div class='textFilterId textCategoryId'>$category_id.</div>";
						echo "<input type='text' name='$category_id' value='$category_name'>";
						echo "<input type='submit' value='Edytuj nazwę kategorii'> ";
						
						echo "<a href='deleteCategory.php?category_id=$category_id'>";
							echo "<div class='textDeleteFilterRow textDeleteCategory button1'>Usuń kategorię</div>";
						echo "</a>";
			
					echo "</div>";
				echo "</form>";

			}
			$category_id++;
			echo "<form action='doAddCategory.php' method='post'>";
				echo "<div class='singleEditFilter singleEditCategory'>";

					echo "<div class='textFilterId textCategoryId'>$category_id.</div>";
					echo "<input type='text' name='new_category'>";
					echo "<input type='submit' value='Dodaj nową kategorię'>";

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



