/*	Jyym Culpepper
	CMSC 491
	Spring 2012 */

function check(ordernum){
	if (ordernum == "") // empty
		document.getElementById("status").innerHTML = "";
	else if (ordernum.match(/\D/)) // any non-digit characters
		document.getElementById("status").innerHTML = "Order number must be composed only of numeric digits.";
	else if (ordernum.length < 6 || ordernum.length > 10) // improper length
		document.getElementById("status").innerHTML = "Order number must be 6 to 10 numberic digits long.";
	else{
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
				document.getElementById("status").innerHTML = xmlhttp.responseText;
			else
				document.getElementById("status").innerHTML = "Please Wait... Finding Order...";
		}
		xmlhttp.open("GET", "check.php?order=" + ordernum, true);
		xmlhttp.send();
	}
}

