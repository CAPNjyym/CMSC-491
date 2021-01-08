/*	Jyym Culpepper
	CMSC 491
	Spring 2012 */

// variables used in the image stacking (5.)
var z1 = 4, z2 = 3, z3 = 2, z4 = 1;

// variables used in moving the logo (6.)
var logo, x, y, minX = -18, maxX = 17, minY = -17, maxY = 14, lr = 0, ud = 1;

// 1. moves the title image to a new location if the new x and y are within range
function move(){
	var x = document.getElementById("titleX").value,
		y = document.getElementById("titleY").value,
		maxX = 490, maxY = 50, error = "";
	
	//alert(x + " " + y + "\n" + x.toString().match(/\D/) + " " + y.toString().match(/\D/));
	
	if (x.toString().match(/\D/) != null || y.toString().match(/\D/) != null)
		error = "Only positive numbers should be entered for the position of the title image.";
	else if (x < 0 || x > maxX)
		error = "x value is out of range.\nRange is between 0 and " + maxX;
	else if (y < 0 || y > maxY)
		error = "y value is out of range.\nRange is between 0 and " + maxY;
	
	if (error != "")
		alert(error);
	else{
		document.getElementById("title").style.left = (x - maxX / 2) + "px";
		document.getElementById("title").style.top = (y - maxY / 2 + 5) + "px";
	}
}

// 2. displays the additional purchase information
function show(){
	document.getElementById("api").style.visibility = "visible";
	document.getElementById("limitedOffer").style.visibility = "visible";
}

// 2. hides the additional purchase information
function hide(){
	document.getElementById("api").style.visibility = "hidden";
	document.getElementById("limitedOffer").style.visibility = "hidden";
}

// 3. changes the BG color and FG color based on which button was pressed
function changeColors(option){
	if (option == 1){
		document.getElementById("main").style.backgroundColor = "rgb(140,197,206)";
		document.getElementById("nav").style.backgroundColor = "rgb(255,214,108)";
		document.getElementById("footer").style.backgroundColor = "rgb(189,108,1)";
		document.getElementById("main").style.color = "black";
		document.getElementById("footer").style.color = "white";
	}
	else if (option == 2){
		document.getElementById("main").style.backgroundColor = "rgb(255,214,108)";
		document.getElementById("nav").style.backgroundColor = "rgb(140,197,206)";
		document.getElementById("footer").style.backgroundColor = "rgb(189,108,1)";
		document.getElementById("main").style.color = "black";
		document.getElementById("footer").style.color = "white";
	}
	else if (option == 3){
		document.getElementById("main").style.backgroundColor = "rgb(189,108,1)";
		document.getElementById("nav").style.backgroundColor = "rgb(140,197,206)";
		document.getElementById("footer").style.backgroundColor = "rgb(255,214,108)";
		document.getElementById("main").style.color = "white";
		document.getElementById("footer").style.color = "black";
	}
	else if (option == 4){
		document.getElementById("main").style.backgroundColor = "rgb(0,0,0)";
		document.getElementById("nav").style.backgroundColor = "rgb(255,214,108)";
		document.getElementById("footer").style.backgroundColor = "rgb(189,108,1)";
		document.getElementById("main").style.color = "white";
		document.getElementById("footer").style.color = "white";
	}
}

// 4. changes font and color when you mouse over a link
function lookAtLink(link){
	document.getElementById("link"+link).style.font = "italic normal normal 80% \"Georgia\", Times, serif";
	document.getElementById("link"+link).style.color = "green";
}

// 4. resets font and color when you mouse out a link
function unlookAtLink(link){
	document.getElementById("link"+link).style.font = "inherit";
	document.getElementById("link"+link).style.color = "blue";
}

// 5. brings #img image to the top of the stack
function topStack(img){
	var z = document.getElementById("img" + img).style.zIndex;
	
	if (z < 4){
		if (img == 1){
			document.getElementById("img1").style.zIndex = z1 = 4;
			document.getElementById("desc").innerHTML = "Graffiti: Perfect for annoying neighbors and causing all kinds of mischief!";
		}
		else if (img == 2){
			document.getElementById("img2").style.zIndex = z2 = 4;
			document.getElementById("desc").innerHTML = "Squirtle Submarines: Suprise a group of unsuspecting kids!";
		}
		else if (img == 3){
			document.getElementById("img3").style.zIndex = z3 = 4;
			document.getElementById("desc").innerHTML = "Squirtle Shades: Look cool!  Plus keep all the nasty UV rays out of your face!";
		}
		else if (img == 4){
			document.getElementById("img4").style.zIndex = z4 = 4;
			document.getElementById("desc").innerHTML = "Water Gun: A 100% free source of water that can be used for practically anything!";
		}
		
		if (img != 1 && z1 > z)
			document.getElementById("img1").style.zIndex = (--z1);
		if (img != 2 && z2 > z)
			document.getElementById("img2").style.zIndex = (--z2);
		if (img != 3 && z3 > z)
			document.getElementById("img3").style.zIndex = (--z3);
		if (img != 4 && z4 > z)
			document.getElementById("img4").style.zIndex = (--z4);
	}
}

// 6. initializes moveLogo()
function initLogo(){
	logo = document.getElementById("logo").style;
	
	x = 1 * logo.left.match(/\d+/);
	y = 1 * logo.top.match(/\d+/);
	
	moveLogo();
}

// 6. moves logo around in a rectagular area
function moveLogo(){
	logo.left = (x += lr) + "px";
	logo.top = (y += ud) + "px";
	
	if (lr != 0 && (x == maxX || x == minX)){
		lr = 0;
		
		if (x == maxX)
			ud = -1;
		else
			ud = 1;
	}
	else if (ud != 0 && (y == maxY || y == minY)){
		ud = 0;
		
		if (y == maxY)
			lr = 1;
		else
			lr = -1;
	}
	
	setTimeout("moveLogo()", 33);
}

