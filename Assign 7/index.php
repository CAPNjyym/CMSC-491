<?php /*
Jyym Culpepper
CMSC 491
Spring 2012 */

$dt[1] = $_POST["month"];
$dt[2] = $_POST["day"];
$dt[3] = $_POST["year"];
$dt[4] = $_POST["hour"];
$dt[5] = $_POST["minute"];

$sempass = $_POST["sempass"];
$daypass = $_POST["daypass"];
$snum = $_POST["student"];

$time = $_POST["time"];
if ($time == "")
	$time = -1;

$class = file("classinfo.data");
for ($i=0; $i<count($class); $i++)
	$class[$i] = trim($class[$i]);

if ($dt[1] > 0 && $dt[1] < 13){
	if (checkdate($dt[1], $dt[2], $dt[3])){
		$timeset = "Set";
		$time = strtotime("$dt[1]/$dt[2]/$dt[3] $dt[4]:$dt[5]");
	}
	else
		$timeset = "";
}
else if ($time >= 0){
	$timeset = "Set";
}
else{
	$timeset = "System";
	$hour = 1 * date("G");
	$minute = 1 * date("i");
}

if ($time < 0){
	$datetime = date("l, F j Y; H:i:s (e O)");
	$attendfile = "".date("Y-n-j").".data";
	$weekday = 1 * date("N");
	$hour = 1 * date("G");
	$min = 1 * date("i");
}
else{
	$datetime = date("l, F j Y; H:i:s (e O)", $time);
	$attendfile ="".date("Y-n-j", $time).".data";
	$weekday = 1 * date("N", $time);
	$hour = 1 * date("G", $time);
	$min = 1 * date("i", $time);
}

$begin = explode(":", $class[2]);
$end = explode(":", $class[3]);
$beginhour = 1 * $begin[0];
$beginmin = 1 * $begin[1];
$endhour = 1 * $end[0];
$endmin = 1 * $end[1];

$illegaltime = $weekday > 5 || $hour < $beginhour || $hour > $endhour || ($hour == $beginhour && $min < $beginmin) || ($hour == $endhour && $min > $endmin);

$students = file("students.data");
for ($i=0; $i<count($students); $i++)
	$students[$i] = explode(";", trim($students[$i]));

$passwords = file("passwords.data");
for ($i=0; $i<count($passwords); $i++){
	$passwords[$i] = explode(";", trim($passwords[$i]));
	if ($passwords[$i][0].".data" == $attendfile){ // gets the daily password
		$password = $passwords[$i][1];
		break;
	}
}

$error = "";
if ($snum != "" && ($sempass == "" || $sempass != $students[$snum][3]))
	$error = "Semester password is incorrect.";
elseif ($snum != "" && ($daypass == "" || $daypass != $password))
	$error = "Daily password is incorrect.";

if ($snum != ""){ // a student has signed in, opens and modifies attendance file
	if (file_exists($attendfile)){
		$attendance = file($attendfile);
		for ($i=0; $i<count($attendance); $i++)
			$attendance[$i] = explode(";", trim($attendance[$i]));
	}
	else{
		for ($i=0; $i<count($students); $i++){
			$attendance[$i][0] = $students[$i][0];
			$attendance[$i][1] = $students[$i][1];
			$attendance[$i][2] = "";
		}
	}
	
	if (!$illegaltime && $error == ""){
		if ($time < 0)
			$realtime = time();
		else
			$realtime = $time;
		$attendance[$snum][2] = $time;
		
		$file = fopen($attendfile, "w");
		for ($i=0; $i<count($attendance); $i++){
			fputcsv($file, $attendance[$i], ";");
		}
		fclose($file);
	}
	elseif ($error == ""){
		$error = "Class time is over.  You can only sign in during class time.";
	}
}
elseif (file_exists($attendfile)){ // opens the attendance file for today
	$attendance = file($attendfile);
	for ($i=0; $i<count($attendance); $i++)
		$attendance[$i] = explode(";", trim($attendance[$i]));
}

echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> <?php echo($class[0]); ?> </title>
	</head>
	
	<body>
<?php
if ($error != "")
?>		<h4> <?php echo($error); ?> </h4>
		<h1> <?php echo($class[0]); ?> </h1>
		<h3> <?php echo("$class[1] $class[2] - $class[3]"); ?> </h3>
		<h4> <?php
if ($timeset == ""){
	?>Illegal Time Set; Using System <?php
}
echo($timeset); ?> Time: <?php echo($datetime); ?> </h4>
		<form action="changetime.php" method="post">
			<input type="hidden" name="time" value="<?php echo($time); ?>" />
			<input type="submit" name="change" value="Change Time" />
		</form>
		<p><br /></p>
		<h2> Student Sign In </h2>
		<p>
			<form action="studentsignin.php" method="post">
				<?php
for ($i=0; $i<count($students); $i++){
	if (is_array($attendance) && $attendance[$i][2] != ""){
		echo($students[$i][0]." ".$students[$i][1]);
?> signed in at <?php echo(date("H:i", $attendance[$i][2])); ?><br />
				<?php
	}
	else{
?>
<input type="radio" name="student" value="<?php echo($i); ?>"/> <?php echo($students[$i][0]." ".$students[$i][1]); ?><br />
				<?php
	}
}

if ($illegaltime){
?>
				<br /> You may only sign in during class time.<br /><br />
<?php
}
else{
?><br /><input type="submit" name="studentin" value="Sign In" /><br /><br /><br />
<?php
}
?>			<input type="hidden" name="time" value="<?php echo($time); ?>" />
			</form>
		</p>
		<h2> Administrator Sign-In </h2>
		<form action="admin.php" method="post">
			Password: <input type="text" name="adminpass" /><br /><br />
			<input type="hidden" name="time" value="<?php echo($time); ?>" />
			<input type="submit" name="adminin" value="Sign In" />
		</form>
	</body>
</html>

