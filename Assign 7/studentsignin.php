<?php /*
Jyym Culpepper
CMSC 491
Spring 2012 */

$snum = $_POST["student"];
$sempass = $_POST["sempass"];
$daypass = $_POST["daypass"];
$passexists = true;

$time = $_POST["time"];
if ($time < 0){
	$timeset = "System";
	$datetime = date("l, F j Y; H:i:s (e O)");
}
else{
	$timeset = "Set";
	$datetime = date("l, F j Y; H:i:s (e O)", $time);
}

// checks to find student and check password
$student = file("students.data");
$student = explode(";", trim($student[$snum]));
if (strlen($student[3]) == 0) // no password set for user
	$passexists = false;

echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Student Sign In</title>
	</head>
	
	<body>
		<h2> Student Sign In </h2>
		<h3> <?php echo($timeset); ?> Time: <?php echo($datetime); ?> </h3>
		<p><br /></p>
		<h4> <?php echo($student[0]." ".$student[1]); ?> </h4>
		<p>
<?php
if ($passexists){
?>
			<form action="index.php" method="post">
				Please enter your semester password and the daily password below. <br /><br />
				Semester password: <input type="text" name="sempass" /><br />
				Daily password: <input type="text" name="daypass" /><br /><br />
				<input type="submit" name="signin" value="Sign In" /><br /><br />
<?php
}
else{
?>
			<form action="createpassword.php" method="post">
				You have not set a semester password yet. <br />
				Please enter your semester password below. <br /><br />
				V number: <input type="text" name="Vnumber" /><br />
				Semester password: <input type="text" name="newpass" /><br />
				Confirm password: <input type="text" name="conpass" /><br /><br />
				<input type="submit" name="create" value="Create Password" /><br /><br />
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

