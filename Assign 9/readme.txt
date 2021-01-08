Jyym Culpepper
CMSC 491
Spring 2012

Root Document:
	index.php

The "cmsc491.sql" file in this folder contains an sql script.
This should be run to populate a "cmsc491" database.
When run, should populate a database with 3 tables (vehicle, owner, and owns)
and should also create 8 vehicles, 5 owners, and 8 owns entries.

Should you be unable to run this script for any reason,
simply creating the database and the three tables (with proper fields)
should be enough to allow the pages to work properly.
At the bottom of this readme are descriptions of every table,
which you should be able to use to properly format each table.

Login information for the database can be changed in the "database.login" file.
There should be only 4 lines (any extras will not be used).
The information contained in these lines is as follows:
	location of the MySQL (likely "localhost")
	username to log into MySQL
	password to log into MySQL
	database that is used (should be "cmsc491", but should work for whatever its named)

Note that if the given credentials in "database.login" fail to access MySQL,
then the default login credentials are attempted.

In the database, three tables are used.
Most pages will give an error if all 3 tables are not present
(NOTE: They can be present and have no data, but they must exist).
The following are the tables name, fields, and their funtionalities:

Table "owner":
	This table serves to list all owners in the database.
	An owner is uniquely identified by his/her ID.
	This ID is also linked to the "owner_id" field in the "owns" table,
	to provide a link to the vehicle(s) owned by this owner.
	
	Field "id": Serves as a unique id for every owner.
		It is set to auto_increment and is both UNIQUE and PRIMARY key.
	Field "last": Text field that contains the owner's last name.
	Field "first": Text field that contains the owner's first name.
	Field "middle": Text field that contains the owner's middle name.
	Field "gender": Varchar(1) field that contains the owner's gender.
		"M" for male or "F" for female.

Table "vehicle":
	This table serves to list all vehicles in the database.
	A vehicle is uniquely identified by its ID.
	This ID is also linked to the "vehicle_id" field in the "owns" table,
	to provide a link to the owner of this vehicle.
	
	Field "id": Serves as a unique id for every vehicle.
		It is set to auto_increment and is both UNIQUE and PRIMARY key.
	Field "make": Text field that contains the vehicle's maker.
	Field "model": Text field that contains the vehicle's model.
	Field "color": Text field that contains the vehicle's color.
	Field "license": Varchar(8) field that contains the vehicle's license plate.

Table "owns":
	This table serves to link an owner to his/her vehicle(s).
	A single owner can own multiple vehicles.
	This is represented by a single owner id being associated with multiple vehicle ids.
	However, a single vehicle id CANNOT be associated with multiple owner ids.
	
	Field "vehicle_id": Represents the id of the vehicle.
		It is both UNIQUE and PRIMARY key.
	Field "owner_id": Represents the id of the owner.

As stated above, the "cmsc491.sql" file contains an sql script to populate a database with data.
The sql file is plain text, so it can be viewed with any text editor (such as notepad).
If the script fails to work, the data contained in the script can be entered
in on the "Create" page or through phpMyAdmin or by any other means you feel acclimated to use.
