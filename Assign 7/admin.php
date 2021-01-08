<?php /*
Jyym Culpepper
CMSC 491
Spring 2012 */

$password = $_POST["adminpass"];
$time = $_POST["time"];
if ($time < 0){
	$timeset = "System";
	$datetime = date("l, F j Y; H:i:s (e O)");
}
else{
	$timeset = "Set";
	$datetime = date("l, F j Y; H:i:s (e O)", $time);
}

$index = 0;
$passwords = file("passwords.data");
for($i=0; $i<count($passwords); $i++){
	$passwords[$i] = explode(";", trim($passwords[$i]));
	
	if (file_exists($passwords[$i][0].".data")){
		$meetings[$index] = file($passwords[$i][0].".data");
		for($j=0; $j<count($meetings[$index]); $j++)
			$meetings[$index][$j] = explode(";", trim($meetings[$index][$j]));
		$meetings[$index]["date"] = $passwords[$i][0];
		$meetings[$index]["pass"] = $passwords[$i][1];
		
		$index++;
	}
}

echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Admininstrator Page</title>
	</head>
	
	<body>
		<h2> Admininstrator Page </h2>
		<h3> <?php echo($timeset); ?> Time: <?php echo($datetime); ?> </h3>
<?php
if ($password != "swimfaster"){
?>
		<h4> Incorrect Password. </h4>
<?php
}
else{
?>
		<p><br /></p>
		<h4> Daily Passwords </h4>
		<table border="1">
			<tr>
				<th> Date of Meeting </th>
				<th> Daily Password </th>
			</tr>
<?php
for($i=0; $i<count($passwords); $i++){
?>
			<tr align="center">
				<td> <?php echo(date("l, F j Y", strtotime($passwords[$i][0]))); ?> </td>
				<td> <?php echo($passwords[$i][1]); ?> </td>
			</tr>
<?php
}
?>
		</table>
<?php
}
?>

		<p><br /></p>
		<h4><?php
if (count($meetings) == 0){
?> No Attendance Information Found </h4>
<?php
}
else{
?> Attendance Information </h4>
		<p>
			NOTE: Only days with attendance information are listed. <br />
			If a day is not listed, then there is no attendance information for that day.
		</p>
<?php
	for ($i=0; $i<count($meetings); $i++){
?>
		<table border="1">
			<tr align="center">
				<th colspan="2"> <?php echo(date("l, F j Y", strtotime($passwords[$i][0]))); ?> </th>
			</tr>
			<tr align="center">
				<th colspan="2"> Daily Password: <?php echo($meetings[$i]["pass"]); ?> </th>
			</tr>
			<tr align="center">
				<th> Student Name </th>
				<th> Time of Sign In </th>
			</tr>
<?php
		for ($j=0; $j<count($meetings[$i])-2; $j++){
?>
			<tr align="center">
				<td> <?php echo($meetings[$i][$j][0]." ".$meetings[$i][$j][1]); ?> </td>
				<td> <?php
				if ($meetings[$i][$j][2] != ""){
					echo(date("H:i", $meetings[$i][$j][2]));
				}
				else
					echo("Did not sign in");
				?> </td>
			</tr>
<?php
		}
?>
		</table>
		<p><br /></p>
		
<?php	
	}
}
?>
		<form action="index.php" method="post">
			<input type="hidden" name="time" value="<?php echo($time); ?>" />
			<input type="submit" name="home" value="Log Out (Back to Home)" />
		</form>
	</body>
</html>