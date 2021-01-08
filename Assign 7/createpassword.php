<?php /*
Jyym Culpepper
CMSC 491
Spring 2012 */

$snum = $_POST["student"];
$vnum = $_POST["Vnumber"];
$newpass = $_POST["newpass"];
$conpass = $_POST["conpass"];

$time = $_POST["time"];
if ($time < 0){
	$timeset = "System";
	$datetime = date("l, F j Y; H:i:s (e O)");
}
else{
	$timeset = "Set";
	$datetime = date("l, F j Y; H:i:s (e O)", $time);
}

// gets the student file and puts all the data into the $students array
$students = file("students.data");
if (is_array($students))
	for ($i=0; $i<count($students); $i++)
		$students[$i] = explode(";", trim($students[$i]));
else
	$status = 10;

// attempts to write new password, outputs a number for the status of the function exit
function writePass($snum, $vnum, $newpass, $conpass, $students){
	if ($vnum != $students[$snum][2])
		return 0;
	else if (strlen($newpass) <= 0)
		return 1;
	else if ($newpass != $conpass)
		return 2;
	else
		$students[$snum][3] = $newpass;
	
	$file = fopen("students.data", "w");
	for ($i=0; $i<count($students); $i++){
		fputcsv($file, $students[$i], ";");
	}
	fclose($file);
	
	return -1;
}

if ($status != 10)
	$status = writePass($snum, $vnum, $newpass, $conpass, $students);

echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Create Password</title>
	</head>
	
	<body>
		<h2> Create Password </h2>
		<h3> <?php echo($timeset); ?> Time: <?php echo($datetime); ?> </h3>
		<p><br /></p>
		<h4> <?php echo($students[$snum][0]." ".$students[$snum][1]); ?> </h4>
		<p>
<?php
if ($status >= 0){ // there was an error
	if ($status == 0){
?>
			Incorrect V number.  Please re-enter V number and semester password.
<?php
	}
	else if ($status == 1){
?>
			You must enter a password.  Please re-enter V number and semester password.
<?php
	}
	else if ($status == 2){
?>
			Password fields must match.  Please re-enter V number and semester password.
<?php
	}
	else if ($status == 10){
?>
			Unable to access student file.  Try again later.
<?php
	}
?>
			<form action="createpassword.php" method="post">
				V number: <input type="text" name="Vnumber" /><br />
				Semester password: <input type="text" name="newpass" /><br />
				Confirm password: <input type="text" name="conpass" /><br /><br />
				<input type="submit" name="create" value="Create Password" /><br /><br />
<?php
}
// reprint password form on password creation failure
else{
?>
			Password saved successfully.  Click on the button to return to the sign in page.
			<form action="studentsignin.php" method="post">
				<input type="submit" name="signin" value="Go to Sign In page" /><br /><br />
<?php
}
?>
				<input type="hidden" name="time" value="<?php echo($time); ?>" />
				<input type="hidden" name="student" value="<?php echo($snum); ?>" />
			</form><br /><br />
			<form action="index.php" method="post">
				<input type="hidden" name="time" value="<?php echo($time); ?>" />
				<input type="submit" name="home" value="Back to Home" />
			</form>
		</p>
	</body>
</html>

