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

$id = $_POST["id"];
$table = $_POST["table"];
$idname = $_POST["idname"];
$action = $_POST["action"];

$query = "SELECT * FROM $table WHERE $idname='$id'";
$db = mysql_query($query);

if ($db == false)
	kill("Query to database failed.  Please try again.");

$rows = mysql_num_rows($db);
$fields = mysql_num_fields($db);
$data = mysql_fetch_array($db);
$field = array_keys($data);

if ($rows <=0 || $fields <= 0)
	kill("Query to database returned no results.  Please try again.");

print_header("Okay");

?>
		<h4>Confirm: <?php echo($action); ?></h4>
		<form action="execute_edit.php" method="post" id="<?php echo($table); ?>" >
			<table border="1">
				<tr >
					<th>Field</th>
					<th><?php
if ($action == "Edit"){
?>Previous <?php } ?>Value</th>
<?php
if ($action == "Edit"){
?>
					<th>New Value</th>
					<input type="hidden" name="numfields" value="<?php echo(($fields-1)); ?>" />
<?php
}
?>
				</tr>
				<tr align="center">
					<td><?php echo($field[1]); ?></td>
					<td colspan="2"><?php echo($data[0]); ?></td>
				</tr>
<?php
for($i=1; $i<$fields; $i++){
?>
				<tr align="center">
					<td><?php echo($field[$i*2 + 1]); ?></td>
					<td><?php echo($data[$i]); ?></td>
<?php
	if ($action == "Edit"){
?>
					<input type="hidden" name="field<?php echo($i); ?>" value="<?php echo($field[$i*2 + 1]); ?>" />
					<td><input type="text" name="data<?php echo($i); ?>" /></td>
<?php
	}
?>
				</tr>
<?php
}
?>
			</table>
			<input type="hidden" name="table" value="<?php echo($table); ?>" />
			<input type="hidden" name="idname" value="<?php echo($idname); ?>" />
			<input type="hidden" name="id" value="<?php echo($id); ?>" />
			<input type="submit" name="action" value="<?php echo($action); ?>" />
		</form>
<?php
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
		<title> Edit / Delete: <?php echo($title); ?> </title>
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