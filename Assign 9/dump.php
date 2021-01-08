<?php /*
Jyym Culpepper
CMSC 491
Spring 2012 */

set_error_handler("handle");

if (file_exists("database.login")){
	$login = file("database.login");
	for ($i=0; $i<count($login); $i++)
		$login[$i] = trim($login[$i]);
}
else
	$login = array("localhost", "root", "", "cmsc491");

$connect = mysql_connect($login[0], $login[1], $login[2]); // tries to login with credentials given in "database.login" file or default credentials above

if ($connect == false) // no connection made with MySQL
	kill('No connection could be made to MySQL.  Please check that the credentials in "database.login" are correct.');

mysql_select_db($login[3]);
$db[0] = mysql_query("SELECT * FROM owner");
$db[1] = mysql_query("SELECT * FROM vehicle");
$db[2] = mysql_query("SELECT * FROM owns");

if ($db[0] == false || $db[1] == false || $db[2] == false){ // Could not find database / table
	mysql_close($connect);
	kill("Query to database $login[3] failed.  Please check that the credentials in \"database.login\" are correct and that database $login[3] is created and properly formatted.");
}

print_header("Okay");

for ($i=0; $i<3; $i++){
	$row = array(); // resets row
	$rows = mysql_num_rows($db[$i]);
	$fields = mysql_num_fields($db[$i]);
	// gonna need ifs and stuff for if there is no data etc
	
	if ($i == 0)
		$table = "owner";
	else if ($i == 1)
		$table = "vehicle";
	else if ($i == 2)
		$table = "owns";
	
	
	if ($rows > 0){ // if there is data to print, then print it
		for($j=0; $j<$rows; $j++)
			$row[$j] = mysql_fetch_array($db[$i]);
		$field = array_keys($row[0]);
?>
		<h4> Table <?php echo($table); ?> </h4>
		<table border="1">
			<tr>
<?php			for ($j=0; $j<$fields; $j++){
					echo("				<th>".$field[$j*2 + 1]."</th>\n");
				}
?>			</tr>
<?php
	for ($j=0; $j<$rows; $j++){
?>
			<tr align="center">
<?php			for ($k=0; $k<$fields; $k++){
					echo("				<td>".$row[$j][$k]."</td>\n");
				}
?>
			</tr>
<?php
	}
?>
		</table>
		<p><br /></p>
		
<?php
		//echo("$rows x $fields<br/>");
		//print_r($row);
	}
	
	else{ // if there is no data to print, then print an appropriate message
?>
		<h4> There is no data for table <?php echo($table); ?> </h4>
		<p><br /></p>
		
<?
	}
}


/*
	do stuff with data
*/

mysql_close($connect);
print_footer();

// END MAIN
// BEGIN FUNCTIONS

function print_header($title){
echo('<?xml version="1.0" encoding="utf-8"?>');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Dump: <?php echo($title); ?> </title>
	</head>
	
	<body>
		<h4>
			<a href="index.php"> Main Page </a>&#8195;
			<a href="create.php"> Create </a>&#8195;
			<a href="edit.php"> Edit / Delete </a>&#8195;
			<a href="search.php"> Search </a>&#8195;
			<a href="dump.php"> Dump </a>
		</h4>
<?php
}

function print_footer(){
?>
	</body>
</html>
<?php
}

function kill($error){
	print_header("Error");
?>
		<h1> Error </h1>
		<p> <?php echo("$error </p>");
	print_footer();
	die;
}

function handle(){} // This is used just to disable the default error messages that are produced
?>