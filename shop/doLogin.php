<?php
require('header.php');
?>


<?php
	if($session -> getUser() -> isAnonymous()){
		$result = user::checkPasswords($_POST['login'], $_POST['password']);

		if($result instanceof user){
			//logged in
			$session->updateSession($result);
			//echo "Zalogowano: ".$session->getUser()->getLogin();
			header('Location: singIn.php');
		}
		else{
			$err = true;
			header('Location: login.php?err='.$err);
		}
	}

?>

<?php
require('footer.php');
?>



