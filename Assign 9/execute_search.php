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

$table = $_POST["table"];
$field = $_POST["field"];
$search = $_POST["search"];
$query = "SELECT * FROM $table WHERE $field='$search'";
$db = mysql_query($query);
if ($db == false){ // Could not find database / table
	mysql_close($connect);
	kill("Query to database $login[3] failed.  Please check that the credentials in \"database.login\" are correct and that database $login[3] is created and properly formatted.");
}

$rows = mysql_num_rows($db);
$fields = mysql_num_fields($db);
print_header("Okay");

if ($rows <= 0 || $fields <= 0){
?>
		<h3> No results found. </h3>
		<p> No results found for search "<?php echo($search); ?>" under field "<?php echo($field); ?>" in table "<?php echo($table); ?>". <br /><?php
}
else{
?>
		<h3> Results: </h3>
		<table border="1">
			<tr align="center">
<?php
	$row = mysql_fetch_array($db);
	$field = array_keys($row);
	for ($i=0; $i<$fields; $i++){
?>
				<th><?php echo($field[$i*2 + 1]); ?></th>
<?php
	}
?>
			</tr>
<?php
	for ($i=0; $i<$rows; $i++){
		if ($i != 0)
			$row = mysql_fetch_array($db);
?>
			<tr align="center">
<?php
		for ($j=0; $j<$fields; $j++){
?>
				<td><?php echo($row[$j]);?></td>
<?php
		}
?>
			</tr>
<?php
	}
?>
		</table>
		
		<p><br /><?php
}
mysql_close($connect);
?> The query used for this search is listed below. <br /> <br />
			<?php
echo($query."</p>");
print_footer();

// END MAIN
// BEGIN FUNCTIONS

function print_header($title){
echo('<?xml version="1.0" encoding="utf-8"?>');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Search: <?php echo($title); ?> </title>
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