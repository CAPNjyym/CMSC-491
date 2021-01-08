/* Jyym Culpepper
	CMSC 491
	Spring 2012 */

// Function to validate all inputs on "ORDER!"
// Will call each subfunction for validating each input field, exiting if an error is found
// Otherwise, will return true, allowing form to submit
function validate(){
	return (validateName() && validateAddress() &&  validateCard() && validatePhone() && validateEmail() && validateRange(0) && validateOne());
}

// Validates that the name field is filled out properly
function validateName(){
	var name = document.forms[0]["name"].value, error = "";
	
	if (name == null || name == "")
		error = "Name must be entered.";
	else{
		var name_pass = name.match(/^[A-Z][a-z]+\s+[A-Z]\.?\s+[A-Z][a-z]+$/);
		if (name_pass == null)
			error = "Name is not properly formatted.  It should be formatted as such:\n\nFirstname M. Lastname\n\nNOTE: The period after the middle initial is optional.";
	}
	
	if (error != ""){
		alert(error);
		
		document.forms[0]["name"].focus();
		document.forms[0]["name"].select();
		
		return false;
	}
	
	return true;
}

// Validates that the address field is filled out properly
function validateAddress(){
	var add1 = document.forms[0]["address1"].value, error = "";
	
	if (add1 == null || add1 == "")
		error = "Address must be entered.\nNOTE:The second address field is not required (and thus is not checked).";
	else{
		var add1_pass = add1.match(/^\d+\s+[A-Z]{1}[a-z]+(\s+[A-Z]{1}[a-z]+)?$/g);
		if (add1_pass == null)
			error = "The address is not properly formatted.  It should be formatted as such:\n\nNumber Street1 Street2\n\nNOTE: Street2 is not required.\nThe second address field is not required (and thus is not checked).";
	}
	
	if (error != ""){
		alert(error);
		
		document.forms[0]["address1"].focus();
		document.forms[0]["address1"].select();
		
		return false;
	}
	
	return true;
}

// Validates that the credit card number field is filled out properly
function validateCard(){
	var card = document.forms[0]["cardNum"].value, error = "";
	
	if (card == null || card == "")
		error = "Credit Card number must be entered.";
	else{
		var card_pass = card.match(/^\d{16}$/);
		if (card_pass == null)
			card_pass = card.match(/^\d{4}-\d{4}-\d{4}-\d{4}$/);
		if (card_pass == null)
			error = "The credit card number is not properly formatted.  It should be formatted as such:\n\nxxxx-xxxx-xxxx-xxxx\n\nNOTE: Dashes are optional.";
	}
	
	if (error != ""){
		alert(error);
		
		document.forms[0]["cardNum"].focus();
		document.forms[0]["cardNum"].select();
		
		return false;
	}
	
	return true;
}

// Validates that the phone number field is filled out properly
function validatePhone(){
	var phone = document.forms[0]["phone"].value, error = "";
	
	if (phone == null || phone == "")
		error = "Phone number must be entered.";
	else{
		var phone_pass = phone.match(/^\d{10}$/);
		if (phone_pass == null)
			phone_pass = phone.match(/^\d{3}\.\d{3}\.\d{4}$/);
		if (phone_pass == null)
			phone_pass = phone.match(/^\d{3}-\d{3}-\d{4}$/);
		if (phone_pass == null)
			error = "The phone number is not properly formatted.  It should be formatted as such:\n\nxxx.xxx.xxxx\n\nNOTE: Periods are optional and can be replaced with dashes.";
	}
	
	if (error != ""){
		alert(error);
		
		document.forms[0]["phone"].focus();
		document.forms[0]["phone"].select();
		
		return false;
	}
	
	return true;
}

// Validates that the email address field is filled out properly
function validateEmail(){
	var email = document.forms[0]["email"].value, error = "";
	
	if (email == null || email == "")
		error = "Email address must be entered.";
	else{
		var email_pass = email.match(/^[A-Za-z]{1}.*@.*[A-Za-z].*$/);
		if (email_pass == null)
			error = "The email address is not properly formatted.  It should be formatted as such:\n\nemail@address";
	}
	
	if (error != ""){
		alert(error);
		
		document.forms[0]["email"].focus();
		document.forms[0]["email"].select();
		
		return false;
	}
	
	return true;
}

// Validates that the each quantity ordered is between 0 and 100
// field indictes which field to check (0 checks all)
function validateRange(field){
	var prod1 = {amount: document.forms[0]["prod1"].value, max: 100, min: 0},
		prod2 = {amount: document.forms[0]["prod2"].value, max: 100, min: 0},
		prod3 = {amount: document.forms[0]["prod3"].value, max: 100, min: 0},
		prod4 = {amount: document.forms[0]["prod4"].value, max: 100, min: 0},
		error = "", errorField = 0;
	
	// uses field to determine which fields to default to passing values (so they won't be checked)
	if (field != 0){
		if (field != 1)
			prod1.amount = 0;
		if (field != 2)
			prod2.amount = 0;
		if (field != 3)
			prod3.amount = 0;
		if (field != 4)
			prod4.amount = 0;
	}
	
	// Searches for any non-digit characters
	prod1.non_digits = prod1.amount.toString().match(/\D/);
	prod2.non_digits = prod2.amount.toString().match(/\D/),
	prod3.non_digits = prod3.amount.toString().match(/\D/),
	prod4.non_digits = prod4.amount.toString().match(/\D/);
	
	if (prod1.amount < prod1.min){
		errorField = 1;
		error = "Negative amounts of products may not be ordered.";
	}
	else if (prod2.amount < prod2.min){
		errorField = 2;
		error = "Negative amounts of products may not be ordered.";
	}
	else if (prod3.amount < prod3.min){
		errorField = 3;
		error = "Negative amounts of products may not be ordered.";
	}
	else if (prod4.amount < prod4.min){
		errorField = 4;
		error = "Negative amounts of products may not be ordered.";
	}
	
	else if (prod1.amount > prod1.max){
		errorField = 1;
		error = "No more than 100 of any product may be ordered at once.";
	}
	else if (prod2.amount > prod2.max){
		errorField = 2;
		error = "No more than 100 of any product may be ordered at once.";
	}
	else if (prod3.amount > prod3.max){
		errorField = 3;
		error = "No more than 100 of any product may be ordered at once.";
	}
	else if (prod4.amount > prod4.max){
		errorField = 4;
		error = "No more than 100 of any product may be ordered at once.";
	}
	
	else if (prod1.non_digits != null){
		errorField = 1;
		error = "Only numbers may be entered in the quantity field.";
	}
	else if (prod2.non_digits != null){
		errorField = 2;
		error = "Only numbers may be entered in the quantity field.";
	}
	else if (prod3.non_digits != null){
		errorField = 3;
		error = "Only numbers may be entered in the quantity field.";
	}
	else if (prod4.non_digits != null){
		errorField = 4;
		error = "Only numbers may be entered in the quantity field.";
	}
	
	if (error != ""){
		alert(error);
		
		if (errorField == 1){
			document.forms[0]["prod1"].focus();
			document.forms[0]["prod1"].select();
		}
		else if (errorField == 2){
			document.forms[0]["prod2"].focus();
			document.forms[0]["prod2"].select();
		}
		else if (errorField == 3){
			document.forms[0]["prod3"].focus();
			document.forms[0]["prod3"].select();
		}
		else if (errorField == 4){
			document.forms[0]["prod4"].focus();
			document.forms[0]["prod4"].select();
		}
		
		return false;
	}
	
	return true;
}

// Validates that the at least 1 item is ordered
function validateOne(){
	var prod1 = document.forms[0]["prod1"].value,
		prod2 = document.forms[0]["prod2"].value,
		prod3 = document.forms[0]["prod3"].value,
		prod4 = document.forms[0]["prod4"].value, error = "";
	
	if (prod1 < 1 && prod2 < 1 && prod3 < 1 && prod4 < 1)
		error = "At least 1 product must be ordered.";
	
	if (error != ""){
		alert(error);
		
		document.forms[0]["prod1"].focus();
		document.forms[0]["prod1"].select();
		
		return false;
	}
	
	return true;
}

// Display example forms
function example(){
	// Sets the real input forms to not display
	document.forms[0]["prod1"].style.display		= "none";
	document.forms[0]["prod2"].style.display		= "none";
	document.forms[0]["prod3"].style.display		= "none";
	document.forms[0]["prod4"].style.display		= "none";
	document.forms[0]["name"].style.display			= "none";
	document.forms[0]["address1"].style.display		= "none";
	document.forms[0]["address2"].style.display		= "none";
	document.forms[0]["cardNum"].style.display		= "none";
	document.forms[0]["phone"].style.display		= "none";
	document.forms[0]["email"].style.display		= "none";
	
	// Sets the example input forms to display
	document.forms[0]["prod1Ex"].style.display		= "inline";
	document.forms[0]["prod2Ex"].style.display		= "inline";
	document.forms[0]["prod3Ex"].style.display		= "inline";
	document.forms[0]["prod4Ex"].style.display		= "inline";
	document.forms[0]["nameEx"].style.display		= "inline";
	document.forms[0]["address1Ex"].style.display	= "inline";
	document.forms[0]["address2Ex"].style.display	= "inline";
	document.forms[0]["cardNumEx"].style.display	= "inline";
	document.forms[0]["phoneEx"].style.display		= "inline";
	document.forms[0]["emailEx"].style.display		= "inline";
	document.forms[0]["emailEx"].style.display		= "inline";
	
	// Disables "ORDER!" and reset buttons, hides the "See Example" button, displays the "Close Example" button
	document.forms[0]["order"].disabled = "disabled";
	document.forms[0]["reset"].disabled = "disabled";
	document.forms[0]["exampleButton"].style.display = "none";
	document.forms[0]["closeButton"].style.display = "inline";
}

// Closes example forms
function closeExample(){
	// Sets the real input forms to not display
	document.forms[0]["prod1"].style.display		= "inline";
	document.forms[0]["prod2"].style.display		= "inline";
	document.forms[0]["prod3"].style.display		= "inline";
	document.forms[0]["prod4"].style.display		= "inline";
	document.forms[0]["name"].style.display			= "inline";
	document.forms[0]["address1"].style.display		= "inline";
	document.forms[0]["address2"].style.display		= "inline";
	document.forms[0]["cardNum"].style.display		= "inline";
	document.forms[0]["phone"].style.display		= "inline";
	document.forms[0]["email"].style.display		= "inline";
	
	// Sets the example input forms to display
	document.forms[0]["prod1Ex"].style.display		= "none";
	document.forms[0]["prod2Ex"].style.display		= "none";
	document.forms[0]["prod3Ex"].style.display		= "none";
	document.forms[0]["prod4Ex"].style.display		= "none";
	document.forms[0]["nameEx"].style.display		= "none";
	document.forms[0]["address1Ex"].style.display	= "none";
	document.forms[0]["address2Ex"].style.display	= "none";
	document.forms[0]["cardNumEx"].style.display	= "none";
	document.forms[0]["phoneEx"].style.display		= "none";
	document.forms[0]["emailEx"].style.display		= "none";
	document.forms[0]["emailEx"].style.display		= "none";
	
	// Enables "ORDER!" and reset buttons, displays the "See Example" button, hides the "Close Example" button
	document.forms[0]["order"].disabled = false;
	document.forms[0]["reset"].disabled = false;
	document.forms[0]["exampleButton"].style.display = "inline";
	document.forms[0]["closeButton"].style.display = "none";
}


