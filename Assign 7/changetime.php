<?php /*
Jyym Culpepper
CMSC 491
Spring 2012 */

$time = $_POST["time"];
if ($time < 0)
	$time = time();

$month = 1 * date("n", $time);
$day = 1 * date("j", $time);
$year = 1 * date("Y", $time);
$hour = 1 * date("G", $time);
$minute = 1 * date("i", $time);
$datetime = date("l, F j Y; H:i:s (e O)");

for($i=1; $i<13; $i++){
	$monthlist[$i] = "".date("F", strtotime("$i/1/1970"));
}

echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Change Time</title>
	</head>
	
	<body>
		<h2> Change Time </h2>
		<h3> System Time: <?php echo($datetime); ?> </h3>
		<p>
			<form action="index.php" method="post">
				<select name="month">
<?php
for($i=1; $i<13; $i++){
?>
					<option value="<?php echo($i); if ($i == $month) echo('" selected="selected');?>"><?php echo($monthlist[$i]);?></option>
<?php
}
?>
				</select>
				<select name="day">
<?php
for($i=1; $i<32; $i++){
?>
					<option value="<?php echo($i); if ($i == $day) echo('" selected="selected');?>"><?php echo($i);?></option>
<?php
}
?>
				</select>
				<input type="text" name="year" size="4" maxlength="4" value="<?php echo($year); ?>" /><br />
				
				<select name="hour">
<?php
for($i=0; $i<24; $i++){
?>
					<option value="<?php echo($i); if ($i == $hour) echo('" selected="selected'); ?>"><?php if ($i < 10) echo("0"); echo($i);?></option>
<?php
}
?>
				</select>
				:
				<select name="minute">
<?php
for($i=0; $i<60; $i++){
?>
					<option value="<?php echo($i); if ($i == $minute) echo('" selected="selected'); ?>"><?php if ($i < 10) echo("0"); echo($i);?></option>
<?php
}
?>
				</select><br /><br />
				
				<input type="submit" name="set" value="Set Time" />
			</form>
			<br />
			<form action="index.php" method="post">
				<input type="submit" name="reset" value="Use System Time" />
			</form>
		</p>
	</body>
</html>

