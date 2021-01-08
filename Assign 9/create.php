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
mysql_close($connect);
print_header("Okay");
?>
		<p>
			Select the table for which you will insert data: <br />
			<input type="radio" name="table" value="owner" onclick="showhide(this.value)" /> owner <br />
			<input type="radio" name="table" value="vehicle" onclick="showhide(this.value)" /> vehicle <br />
			<input type="radio" name="table" value="owns" onclick="showhide(this.value)" /> owns <br /> <br />
		</p>
		
		<form id="owner" method="post" action="execute_create.php" style="display:none">
			<table>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="data1" /></td>
				</tr>
				<tr>
					<td>Middle Name:</td>
					<td><input type="text" name="data2" /></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="data0" /></td>
				</tr>
				<tr>
					<td>Gender (M or F):</td>
					<td><input type="text" name="data3" size="1" maxlength="1" /></td>
				</tr>
			</table>
			<p>
				<input type="hidden" name="table" value="owner" />
				<input type="submit" value="Insert" /> <br />
			</p>
		</form>
		
		<form id="vehicle" method="post" action="execute_create.php" style="display:none">
			<table>
				<tr>
					<td>Make:</td>
					<td><input type="text" name="data0" /></td>
				</tr>
				<tr>
					<td>Model:</td>
					<td><input type="text" name="data1" /></td>
				</tr>
				<tr>
					<td>Color:</td>
					<td><input type="text" name="data2" /></td>
				</tr>
				<tr>
					<td>License Plate:</td>
					<td><input type="text" name="data3" size="8" maxlength="8" /></td>
				</tr>
			</table>
			<p>
				<input type="hidden" name="table" value="vehicle" />
				<input type="submit" value="Insert" /> <br />
			</p>
		</form>
		
		<form id="owns" method="post" action="execute_create.php" style="display:none">
			Owner ID: <input type="text" name="data1" /> <br />
			Vehicle ID: <input type="text" name="data0" /> <br />
			<p>
				<input type="hidden" name="table" value="owns" />
				<input type="submit" value="Insert" /> <br />
			</p>
		</form>
<?php
print_footer();

// END MAIN
// BEGIN FUNCTIONS

function print_header($title){
echo('<?xml version="1.0" encoding="utf-8"?>');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Create: <?php echo($title); ?> </title>
		<script type="text/javascript">
			function showhide(id){
				document.getElementById("owner").style.display = "none";
				document.getElementById("vehicle").style.display = "none";
				document.getElementById("owns").style.display = "none";
				
				document.getElementById(id).style.display = "inline";
			}
		</script>
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