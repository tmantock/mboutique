<?php
require_once('db_connect.php');
//function for generating a unique order number
function orderNumber () {
  return uniqid('ORD',false);
}

//result array set to be echoed later
$result = [];
//convert the post data in to useable data. Angular does something whne it comes to post data and php
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
//variables are set for easeof use and reference
$token = $request->token;

$shipDateConversion = strtotime("+3 days");
$shippingDate = date("Y-m-d H:i:s",$shipDateConversion);

$orderCount = $request->quantity;
$orderDiscount = $request->discount;
$orderTax = $request->tax;
$orderTotal = $request->total;
$orderNumber = orderNumber();
//Select everything from the token table where the tokens match
$token_result = $db -> query("SELECT * FROM `token` WHERE `token`='$token'");
$row = $token_result->fetch_assoc();
$timestamp = $row['unix_timestamp'];
$email = $row['email'];
//check if the token has been issued for more than 30 minutes. If it has than echo the error message
if(($timestamp - time()) > 1800 ){
  $result['success'] = false;
  $result['error'] = true;
  $result['error']['message'] = "Error: Your session has expired. Please sign in again.";
  $result = json_encode($result);
  header('Content-Type: application/json;charset=utf-8');
  echo($result);
  exit();
}
//if the token has been issued within 30 minutes
else {
  //Select all the customer data form the customers tabler where email matches
  $user = $db -> query("SELECT * FROM `customers` WHERE `email` = '$email'");
  $customer_info = $user->fetch_assoc();
  $id = $customer_info['user_id'];
  $name = $customer_info['name'];
  //Insert into the orders table the order contents
  $customer = "INSERT INTO `orders` (`user_id`,`order_id`,`name`,`item_count`,`order_discount`,`order_tax`,`order_total`,`ship_date`) VALUES ('$id','$orderNumber','$name','$orderCount','$orderDiscount','$orderTax','$orderTotal','$shippingDate')";
  //if the order data was inserted successfully, then isert the data into the order_item table
  if(mysqli_query($conn,$customer)){
    //foreach loop to insert each cart item into the order_item table for each macaron or gift in the cart
    foreach ($request->cart as $key => $value) {
      $cart_id = $value->id;
      $cart_item = $key;
      $cart_item_quantity = $value->quantity;
      $cart_item_cost = $value->cost;
      //Insert the item order information into teh order_item table
      $db -> query("INSERT INTO `order_item` (`order_id`,`product_id`,`unit_cost`,`unit_count`,`product_name`,`shipped_date`) VALUES ('$orderNumber','$cart_id','$cart_item_cost','$cart_item_quantity','$cart_item','$shippingDate')");
    }
    //set the result success messages
    $result['success']['success'] = true;
    $result['success']['order_number'] = $orderNumber;
  }
  //if entering the data was unsuccessful, then set the error messages
  else {
    $result['error'] = true;
    $result['success'] = false;
    $result['message'] = "Error: Unable to add order!";
  }
}
//json encode the result
$result = json_encode($result);
//set the header
header('Content-Type: application/json;charset=utf-8');
//echo the result to the client
echo($result);

?>
