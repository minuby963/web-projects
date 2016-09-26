function checkLogin(){
	var login = document.getElementById("loginLogin").value;
	login = login.trim();

	var errorDiv = document.getElementsByClassName("loginError");

	if((login==null) || (login=="")){
    	errorDiv[0].innerHTML = "Wpisz login!";
	}	
	else if(login.length > 40){
    	errorDiv[0].innerHTML = "Login jest za długi!";
	}
	else{
    	errorDiv[0].innerHTML = "";
	}
}
function checkPassword(){
	var password = document.getElementById("loginPassword").value;
	password = password.trim();

	var errorDiv = document.getElementsByClassName("passwordError");

	if((password==null) || (password=="")){
    	errorDiv[0].innerHTML = "Wpisz hasło!";
	}	
	else if(password.length > 40){
    	errorDiv[0].innerHTML = "Hasło jest za długie!";
	}
	else{
    	errorDiv[0].innerHTML = "";
	}
	checkLogin();
}