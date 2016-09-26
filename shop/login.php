<?php
	ob_start();
?>
<div class="loginBackground">

<?php
	require_once('header.php');

	if(!$session -> getUser() -> isAnonymous()){
		header('Location: singIn.php');
		exit;
	}
?>
<script src="checkLogin.js"></script>

<div class='container'>
	<div class='doLogin'>
	<form action='doLogin.php' method='post'>
		<input type='text' id='loginLogin' name='login' maxlength='40' onchange='checkLogin()' placeholder='Login'></br>
		<div class='loginError formError' style='padding-left: 14px;'></div>

		<input type='password' id='loginPassword' name='password' maxlength='40' onchange='checkPassword()' placeholder='Hasło'></br>
		<div class='passwordError formError'></div>

		<div class="error">
			<?php
				
				if(isset($_GET['err'])){
					echo "Nieprawidłowy login lub hasło!";
				}


			?>
		</div>
		<!-- <div class="clear"></div> -->

		<input type='submit' value='ZALOGUJ'></br>
	</form>
	</div>
</div>

<?php
	require_once('footer.php');
?>
</div>
<?php
	ob_end_flush();
?>