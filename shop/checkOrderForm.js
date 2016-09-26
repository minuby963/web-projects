function capitalizeFirstLetter(string) {
 	return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

var enable = [false, false, false, false, false, false, false];
function enableSubmitInput(do_not_check){

	// alert(enable[0]);
	// alert(enable[1]);
	// alert(enable[2]);
	// alert(enable[3]);
	// alert(enable[4]);
	// alert(enable[5]);
	// alert(enable[6]);

	// var errorDiv = document.getElementsByClassName("nameError");
 //    	errorDiv[0].innerHTML = "Wpisz imię!";


	var enableSubmit = true;
	for(i = 0; i<enable.length; i++){
		if(do_not_check == i){
			continue;
		}
		if(enable[i] == false){
			enableSubmit = false;
			break;
		}
	}
	if(enableSubmit){
    	document.getElementById("submitForm").disabled = false;
	}
}

function checkName(){
	var name = document.getElementById("nameForm").value;
	name = name.trim();

	var enable_name = false;

	var errorDiv = document.getElementsByClassName("nameError");
	if((name==null) || (name=="")){
    	errorDiv[0].innerHTML = "Wpisz imię!";
    	document.getElementById("submitForm").disabled = true;
	}	
	else if (!/^[a-zA-Z]*$/g.test(name)) {
    	errorDiv[0].innerHTML = "Imię powinno zawierać wyłącznie litery!";
    	document.getElementById("submitForm").disabled = true;
	}
	else if(name.length > 30){
    	errorDiv[0].innerHTML = "Imię jest za długie!";
    	document.getElementById("submitForm").disabled = true;
	}
	else{
    	errorDiv[0].innerHTML = "";
    	// document.getElementById("submitForm").disabled = false;
    	// bool_enable = false;

    	var new_name = capitalizeFirstLetter(name);
		document.getElementById("nameForm").value = new_name;
		enable[0]=true;
	}

	enableSubmitInput();

}


function checkSurname(){
	var surname = document.getElementById("surnameForm").value;
	surname = surname.trim();

	var errorDiv = document.getElementsByClassName("surnameError");

	if((surname==null) || (surname=="")){
    	errorDiv[0].innerHTML = "Wpisz nazwisko!";
    	document.getElementById("submitForm").disabled = true;
	}	
	else if (!/^[a-zA-Z]*$/g.test(surname)) {
    	errorDiv[0].innerHTML = "Nazwisko powinno zawierać wyłącznie litery!";
    	document.getElementById("submitForm").disabled = true;
	}
	else if(surname.length > 40){
    	errorDiv[0].innerHTML = "Nazwisko jest za długie!";
    	document.getElementById("submitForm").disabled = true;
	}
	else{
    	errorDiv[0].innerHTML = "";
    	// document.getElementById("submitForm").disabled = false;

    	var new_surname = capitalizeFirstLetter(surname);
		document.getElementById("surnameForm").value = new_surname;
		enable[1]=true;

	}
	checkName();
	enable();
}

function checkEmail(){
	var email = document.getElementById("emailForm").value;
	email = email.trim();
	var atpos = email.indexOf("@");
    	var dotpos = email.lastIndexOf(".");

	var errorDiv = document.getElementsByClassName("emailError");

	if((email==null) || (email=="")){
    	errorDiv[0].innerHTML = "Wpisz adres e-mail!";
    	document.getElementById("submitForm").disabled = true;
	}	
	else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
    	errorDiv[0].innerHTML = "Niepoprawny adres e-mail!";
    	document.getElementById("submitForm").disabled = true;
	}
	else if(email.length > 50){
    	errorDiv[0].innerHTML = "Adres e-mail jest za długi!";
    	document.getElementById("submitForm").disabled = true;
	}
	else{
    	errorDiv[0].innerHTML = "";
    	// document.getElementById("submitForm").disabled = false;
		enable[2]=true;
	}
	checkSurname();
	enable();
}

function checkCity(){
	var city = document.getElementById("cityForm").value;
	city = city.trim();

	var errorDiv = document.getElementsByClassName("cityError");

	if((city==null) || (city=="")){
    	errorDiv[0].innerHTML = "Wpisz miasto!";
    	document.getElementById("submitForm").disabled = true;
	}	
	else if (!/^[a-zA-Z]*$/g.test(city)) {
    	errorDiv[0].innerHTML = "Nazwa miasta powinna zawierać wyłącznie litery!";
    	document.getElementById("submitForm").disabled = true;
	}
	else if(city.length > 40){
    	errorDiv[0].innerHTML = "Nazwa miasta jest za długa!";
    	document.getElementById("submitForm").disabled = true;
	}
	else{
    	errorDiv[0].innerHTML = "";
    	// document.getElementById("submitForm").disabled = false;

    	var new_city = capitalizeFirstLetter(city);
		document.getElementById("cityForm").value = new_city;
		enable[3]=true;
	}
	checkEmail();
	enable();
}



function checkPostalCode1(){
	var postal_code1 = document.getElementById("postalCode1Form").value;
	// postal_code1 = postal_code1.trim();

	var errorDiv = document.getElementsByClassName("postalCode1Error");

	if((postal_code1==null) || (postal_code1=="")){
    	errorDiv[0].innerHTML = "Wpisz kod pocztowy!";
    	document.getElementById("submitForm").disabled = true;
	}	
	else if (!/^[0-9]*$/g.test(postal_code1)) {
    	errorDiv[0].innerHTML = "Kod pocztowy powinien zawierać wyłącznie cyfry!";
    	document.getElementById("submitForm").disabled = true;
	}
	else if(postal_code1.length > 2){
    	errorDiv[0].innerHTML = "Niepoprawny kod pocztowy!";
    	document.getElementById("submitForm").disabled = true;
	}
	else if(postal_code1.length < 2){
    	errorDiv[0].innerHTML = "Niepoprawny kod pocztowy!";
    	document.getElementById("submitForm").disabled = true;
	}
	else{
    	errorDiv[0].innerHTML = "";
    	// document.getElementById("submitForm").disabled = false;
		enable[4]=true;
	}
	checkCity();
	enable();
}

function checkPostalCode2(){
	var postal_code2 = document.getElementById("postalCode2Form").value;
	// postal_code2 = postal_code2.trim();

	var errorDiv = document.getElementsByClassName("postalCode2Error");

	if((postal_code2==null) || (postal_code2=="")){
    	errorDiv[0].innerHTML = "Wpisz kod pocztowy!";
    	document.getElementById("submitForm").disabled = true;
	}	
	else if (!/^[0-9]*$/g.test(postal_code2)) {
    	errorDiv[0].innerHTML = "Kod pocztowy powinien zawierać wyłącznie cyfry!";
    	document.getElementById("submitForm").disabled = true;
	}
	else if(postal_code2.length > 3){
    	errorDiv[0].innerHTML = "Niepoprawny kod pocztowy!";
    	document.getElementById("submitForm").disabled = true;
	}
	else if(postal_code2.length < 3){
    	errorDiv[0].innerHTML = "Niepoprawny kod pocztowy!";
    	document.getElementById("submitForm").disabled = true;
	}
	else{
    	errorDiv[0].innerHTML = "";
    	// document.getElementById("submitForm").disabled = false;
		enable[5]=true;
	}
	checkPostalCode1();
	enable();
}

function checkStreet(){
	var street = document.getElementById("streetForm").value;
	street = street.trim();

	var errorDiv = document.getElementsByClassName("streetError");

	if((street==null) || (street=="")){
    	errorDiv[0].innerHTML = "Wpisz ulicę i numer domu lub mieszkania!";
    	document.getElementById("submitForm").disabled = true;
	}	
	else if(street.length > 50){
    	errorDiv[0].innerHTML = "Nazwa ulicy jest za długa!";
    	document.getElementById("submitForm").disabled = true;
	}
	else{
    	errorDiv[0].innerHTML = "";
    	// document.getElementById("submitForm").disabled = false;

    	var new_street = capitalizeFirstLetter(street);
		document.getElementById("streetForm").value = new_street;
		enable[6]=true;
	}
	checkPostalCode2();
	enable();
}