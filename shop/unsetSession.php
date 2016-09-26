<?php
require('header.php');

	if(isset($_GET['unset'])){
		$unset=$_GET['unset'];
		switch ($unset) {
			case 1:                                    /* 1 - unset  main search */
				unset($_SESSION['main_search_name']);
				break;
			
			default:
				session_unset();
				break;
		}

	}
	else{
		session_unset();
	}
	header('Location: index.php');
	exit;
?>