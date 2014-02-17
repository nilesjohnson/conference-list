<?php

  /*
   * To do this manually, open mysql and choose database with
   * USE <databasename>;
   * then copy/paste from $table_create below
   */
print "<h1>hello world</h1>";

$user_name = "root";
$password = "";
$database = "conflist";
$server = "127.0.0.1";

$conn = mysqli_connect($server, $user_name, $password, $database);


if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

if ($conn) {
print "Connected!<br/>";


$table_create = "
CREATE TABLE conferences (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
edit_key VARCHAR(10),
title VARCHAR(200),
start_date DATE,
end_date DATE,
institution VARCHAR(100),
city VARCHAR(100),
country VARCHAR(100),
meeting_type VARCHAR(100),
subject_area VARCHAR(100),
homepage VARCHAR(400),
contact_name VARCHAR(100),
contact_email VARCHAR(100),
description TEXT
);
";


/*
// create table
if (mysqli_query($conn,$table_create)) {
  print "created conferences table<br/>";
}
else {
  echo "Error creating table: " . mysqli_error($conn) . "<br/>";
}
/**/



$table_data =  "INSERT INTO conferences (title, edit_key, start_date, end_date, duration, institution, city, region, country, meeting_type, subject_area, homepage, contact_name, contact_email, description) 
VALUES 
  ('Test Conference 1', 'edit key', '2100-06-01', '2100-06-02', 'University', 'City', 'Country', 'conference', 'math', 'http://example.com', 'Name', 'test@example.com', 'This is an example entry.'),
  ('Test Conference 2', 'edit key', '2110-06-01', '2110-06-02', 'University', 'City', 'Country', 'conference', 'math', 'http://example.com', 'Name', 'test@example.com', 'This is an example entry.'),
  ('Test Conference 3', 'edit key', '2120-06-01', '2120-06-02', 'University', 'City', 'Country', 'conference', 'math', 'http://example.com', 'Name', 'test@example.com', 'This is an example entry.'),
  ('Test Conference 4', 'edit key', '2130-06-01', '2130-06-02', 'University', 'City', 'Country', 'conference', 'math', 'http://example.com', 'Name', 'test@example.com', 'This is an example entry.'),




/*
// add entries to table
if (mysqli_query($conn,$table_data)) {
  print "inserted initial table data<br/>";
}
else {
  echo "Error inserting data: " . mysqli_error($conn) . "<br/>";
}


/**/


// show data
$row_result = mysqli_query($conn,"SELECT * FROM conferences");
while ($row = mysqli_fetch_array($row_result,MYSQLI_ASSOC)) {
  print "<pre>";
  print_r ($row);
  print "</pre>";
}


mysql_close($conn);
}
else {

print "Database NOT Found ";
mysql_close($conn);

}

?>
