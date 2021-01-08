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

$numfields = $_POST["numfields"];
$table = $_POST["table"];
$idname = $_POST["idname"];
$id = $_POST["id"];
$action = $_POST["action"];
$dbact = strtoupper($action);
if ($dbact == "EDIT")
	$dbact = "UPDATE";

// if inserting into owns, check that the owner exists
if ($action == "Edit" && $table == "owns"){
	$query = "SELECT * FROM owner WHERE id='".$_POST["data1"]."'";
	$db = mysql_query($query);
	if ($db == false || mysql_num_rows($db) <= 0)
		kill("Owner with id ".$_POST["data1"]." does not exist.");
}

// build query
$query = "$dbact ";
if ($action == "Delete")
	$query .= "FROM ";
$query .= "$table ";
if ($action == "Edit"){
	$query .= "SET ".$_POST["field1"]."='".$_POST["data1"]."'";
	$_POST["data4"] = strtoupper($_POST["data4"]);
	for($i=2; $i<=$numfields; $i++)
		$query .= ", ".$_POST["field".$i]."='".$_POST["data".$i]."'";
}
$query .= " WHERE $idname='$id'";

// make sure to update corresponding table(s) that have similar ids
if ($action == "Delete" && ($table == "owner" || $table == "vehicle"))
	$query2 = "DELETE FROM owns WHERE $table"."_id='$id'";

mysql_query($query);
if ($query2 != null)
	mysql_query($query2);
mysql_close($connect);

print_header("Success");
?>
		<p> <?php echo($action) ?> successful.  The queries used are listed below. <br /><br />
			<?php echo($query."<br />");
			if ($query2 != null)
				echo($query2."</p>");
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