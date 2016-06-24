<?php
require_once ("db_connect.php");
//Query for selecting all macarons and saving it to a variable
$result = $db -> query("SELECT `id`,`name`,`cost`,`description` FROM `products`");
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
  print($output);
}
//if thre is are no macarons in the database, then prent error message
else {
  print("Error 76 from Server: unable to read data.");
}
//close the database connections
mysqli_close($conn);
mysqli_close($db);
?>
