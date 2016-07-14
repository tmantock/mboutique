<?php
require_once ("db_connect.php");
header('Content-Type: application/json;charset=utf-8');
//Query for selecting all macarons and saving it to a variable
$result = $db -> query("SELECT * FROM `products` ORDER BY `products`.`category` ASC");
//declare object array to hold the macarons
$object = [];
//Conditional for determining if there are macarons present to be pushed into the object array
if($result->num_rows>0) {
  //while loop for pushing each macaron row into teh object array
  while($row = $result -> fetch_assoc()){
    array_push($object,$row);
  }
  //json encode the object array and assigning it to the output variable
  $output = json_encode($object);
  //print the output variable to be printed for the AJAX call
  echo($output);
}
//if thre is are no macarons in the database, then prent error message
else {
  echo("Error 76 from Server: unable to read data.");
}
//close the database connections
mysqli_close($conn);
mysqli_close($db);
?>
