<?php
require('header.php');
?>


<?php
	function changeProduct($size_id, $product_index){
		global $pdo;
		$stmt = $pdo->prepare('SELECT id FROM products WHERE product_index = :pid AND size_id = :size_id');
		$stmt->bindValue(':size_id', $size_id, PDO::PARAM_INT);
		$stmt->bindValue(':pid', $product_index, PDO::PARAM_INT);

		$stmt->execute();

		if($row = $stmt->fetch(PDO::PARAM_STR)){
			return $row['id'];
		}
		else{
			$err="Coś poszło nie tak...";
			header('Location: error.php?err='.$err);
			exit;
		}
	}
?>

<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	else{
		$err="Nie wybrano produktu!";
		header('Location: error.php?err='.$err);
		exit;
	}


	if(isset($_POST['size'])){
		$size = $_POST['size'];
		$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			if($row['size_id'] != $size){
				$id = changeProduct($size, $row['product_index']);
			}

		}
		else{
			$err="Coś poszło nie tak...";
			header('Location: error.php?err='.$err);
			exit;
		}
	}
	
	$cart->add($id);
	header('Location: showcart.php?id='.$id);
	exit;
?>

<?php
require('footer.php');
?>



