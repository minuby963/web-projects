<?php 
class cart{

	public function __construct(){

	}

	public function add($id){
		global $pdo, $session;

		$stmt = $pdo->prepare("SELECT * FROM sessioncart WHERE product_id = :id AND session_id = :sid");
		$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		if($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
			
			$qty = $row[0]['quantity'] + 1;


			$stmt = $pdo->prepare("UPDATE sessioncart SET quantity = :qty WHERE session_id = :sid AND product_id = :pid");
			$stmt->bindValue(':qty', $qty, PDO::PARAM_INT);
			$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
			$stmt->bindValue(':pid', $id, PDO::PARAM_INT);
			$stmt->execute();

		}
		else{
			$stmt = $pdo->prepare("INSERT INTO sessioncart (id, session_id, product_id, quantity) VALUES (null, :sid, :pid, 1)");
			$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
			$stmt->bindValue(':pid', $id, PDO::PARAM_INT);
			$stmt->execute();
		}

		
	}

	public function remove($id){
		global $pdo, $session;

		$stmt = $pdo->prepare("SELECT * FROM sessioncart WHERE product_id = :id AND session_id = :sid");
		$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$qty = $row[0]['quantity'];
		$qty--;
		if($qty == 0){
			echo "A";
			$stmt = $pdo->prepare("DELETE FROM sessioncart WHERE product_id = :id AND session_id = :sid");
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
			$stmt->execute();
		}
		else{
			$stmt=$pdo->prepare("UPDATE sessioncart SET quantity = :qty WHERE product_id = :id AND session_id = :sid");
			$stmt->bindValue(':qty', $qty, PDO::PARAM_INT);

			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
			$stmt->execute();
		}		
	}
	public function getProductsPrice(){
		global $pdo, $session;

		$inCart = $this->getProducts();

		$price = 0;
		foreach($inCart as $product){
			$quantity = $product['quantity'];
			$net_price = $product['net_price'];
			$price = $price + $quantity * $net_price;
		}
		return $price;
	}
	
	public function getProductsQuantity(){
		global $pdo, $session;

		$inCart = $this->getProducts();

		$products_in_cart = 0;
		foreach($inCart as $product){
			$quantity = $product['quantity'];
			$products_in_cart = $products_in_cart+$quantity;
		}

		return $products_in_cart;


	}

	public function getProducts(){
		global $pdo, $session;

		$stmt = $pdo->prepare("SELECT s.id, p.net_price, s.quantity, p.product_index, p.name, p.size_id, p.id as pid FROM sessioncart s LEFT OUTER JOIN products p ON (s.product_id = p.id) WHERE s.session_id  = :sid");

		$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	// public function getQuantityOfProductsInCart(){
	// 	global $pdo, $session;

	// 	$stmt = $pdo->prepare("SELECT s.quantity FROM sessioncart s LEFT OUTER JOIN products p ON (s.product_id = p.id) WHERE s.session_id  = :sid");

	// 	$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
	// 	$stmt->execute();

	// 	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// 	$result = 0;
	// 	foreach ($rows as $row) {
	// 		$result = $result + $row['quantity'];
	// 	}
	// 	return $result;
	// }

	public function clear(){
		global $pdo, $session;
		$stmt = $pdo->prepare("DELETE FROM sessioncart WHERE session_id = :sid");
		$stmt->bindValue(':sid', $session->getSessionId(), PDO::PARAM_STR);
		$stmt->execute();

	}


}


?>