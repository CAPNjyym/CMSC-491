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
if ($table == "owner")
	$fields = array("last", "first", "middle", "gender");
else if ($table == "vehicle")
	$fields = array("make", "model", "color", "license");
else if ($table == "owns")
	$fields = array("vehicle_id", "owner_id");
else
	$table = null;

for ($i=0; $i<count($fields); $i++)
	$data[$i] = $_POST["data".$i];
if ($data[3])
	$data[3] = strtoupper($data[3]);

// check for correctness
if ($table == null)
	kill("Incorrect table referenced.  Please try to insert data again.");

// if inserting into owns, check that the owner & vehicle exist
if ($table == "owns"){
	$query = "SELECT * FROM owner WHERE id='$data[1]'";
	$db = mysql_query($query);
	if ($db == false || mysql_num_rows($db) <= 0)
		kill("Owner with id $data[1] does not exist.");
	$query = "SELECT * FROM vehicle WHERE id='$data[0]'";
	$db = mysql_query($query);
	if ($db == false || mysql_num_rows($db) <= 0)
		kill("Vehicle with id $data[0] does not exist.");
}

// builds the list of fields and values to insert
if (count($fields) > 0 && count($data) > 0){
	$fieldlist = "($fields[0]";
	$values = "('$data[0]'";
	
	for($i=1; $i<count($fields); $i++){
		$fieldlist .= ", $fields[$i]";
		$values .= ", '$data[$i]'";
	}
	
	$fieldlist .= ")";
	$values .= ")";
}
else
	kill("Field count or data count error.  Please try to insert again.");

// insert into table
$insert = "INSERT INTO $table $fieldlist VALUES $values";
mysql_query($insert);
mysql_close($connect);

print_header("Success");
?>
		<p> Query successful.  Data inserted into database.  The query used is listed below. <br /><br />
			<?php echo($insert."</p>");
print_footer();

// END MAIN
// BEGIN FUNCTIONS

function print_header($title){
echo('<?xml version="1.0" encoding="utf-8"?>');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Insert: <?php echo($title); ?> </title>
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