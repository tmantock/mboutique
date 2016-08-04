<?php
require_once('db_connect.php');
require_once('shipping.php');
require_once('states.php');
require_once('calculate-function.php');
require_once('states-list.php');
//function for generating a unique order number
function orderNumber () {
  return strtoupper(uniqid('ORD',false));
}

function nameRegex ($string){
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^[a-z ,.'-]+$/i";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['name_city'] = "Invalid name or city";
    return false;
  }
}
//function for validating the email
function emailRegex ($string){
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/\S+@\S+\.\S+/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['email'] = "Invalid email";
    return false;
  }
}
//function for validating the password
function passwordRegex ($string) {
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,50}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['password'] = "Invalid password";
    return false;
  }
}
//function for validating the phone number
function phoneRegex ($string) {
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['phone'] = "Invalid phone number";
    return false;
  }
}
//function for validating the address
function addressRegex ($string) {
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^[A-Za-z0-9'\.\#\-\s\,]*$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['address'] = "Invalid address";
    return false;
  }
}
//function for validating the zip code
function zipRegex ($string) {
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^[0-9]{5}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['zip'] = "Invalid zip";
    return false;
  }
}
//function for validating the state
function stateRegex ($string) {
  global $states_list;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  for($i = 0; $i < count($states_list); $i++){
    if(strtolower($states_list[$i]) === strtolower($string)){
      return true;
    }
  }
}

//result array set to be echoed later
$result = [];
//convert the post data in to useable data. Angular does something whne it comes to post data and php
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
//variables are set for easeof use and reference
$token = $request->token;
$status = $request->customer_status;

$orderCount = $request->quantity;
$orderTotal = $request->total;
$orderNumber = orderNumber();

if($status === 'existing'){
    $user = $db->query("SELECT `state` FROM `customers` WHERE `email`='$email'");
    $user = $user->fetch_assoc();
}else if($status === 'guest'){
  $user['state'] = $request->customer->state;
}

$ship_calc = new Shipping(intval($request->shipping_time));
$shipping = $ship_calc->calculateShipping();
$shippingDate = $shipping['date'];
$calculate = new Calculate($states_tax,$request->cart,$user['state'],$shipping['cost']);
$calculation = $calculate->totalCost();
$orderTax = $calculation['tax'];
$orderShippingCost = $calculation['shipping'];
if(intval($calculation['total']) !== intval($orderTotal)){
  $result['success'] = false;
  $result['error']['status'] = true;
  $result['client_total'] = $orderTotal;
  $result['server_total'] = $calculation['total'];
  $result['error']['message'] = "Error: The total has been altered.";
  $result = json_encode($result);
  header('Content-Type: application/json;charset=utf-8');
  echo($result);
  exit();
}


if($status === 'existing'){
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
    $customer = "INSERT INTO `orders` (`user_id`,`order_id`,`name`,`item_count`,`order_shipping_cost`,`order_tax`,`order_total`,`ship_date`) VALUES ('$id','$orderNumber','$name','$orderCount','$orderShippingCost','$orderTax','$orderTotal','$shippingDate')";
    //if the order data was inserted successfully, then isert the data into the order_item table
    if(mysqli_query($conn,$customer)){
      //foreach loop to insert each cart item into the order_item table for each macaron or gift in the cart
      foreach ($request->cart as $key => $value) {
        $cart_id = $value->id;
        $cart_item = $key;
        $cart_item_quantity = $value->count;
        $cart_item_cost = $value->cost;
        //Insert the item order information into teh order_item table
        $db -> query("INSERT INTO `order_item` (`order_id`,`product_id`,`unit_cost`,`unit_count`,`product_name`,`shipped_date`) VALUES ('$orderNumber','$cart_id','$cart_item_cost','$cart_item_quantity','$cart_item','$shippingDate')");
      }
      //set the result success messages
      $result['success']['success'] = true;
      $result['success']['order_number'] = $orderNumber;
      $result['success']['shipping'] = $request->shipping_time;
    }
    //if entering the data was unsuccessful, then set the error messages
    else {
      $result['error'] = true;
      $result['success'] = false;
      $result['message'] = "Error: Unable to add order!";
    }
  }
} else if($status === 'guest'){
  $id = uniqid('mbq',false).time();
  $name = $request->customer->name;
  $email = $request->customer->email;
  $phone = $request->customer->phone;
  $address = $request->customer->address;
  $city = $request->customer->city;
  $state = $request->customer->state;
  $zip = $request->customer->zip;
  if(phoneRegex($phone) && addressRegex($address) && nameRegex($city) && zipRegex($zip) && stateRegex($state) && nameRegex($name) && emailRegex($email)){
    $query = "INSERT INTO `guests` (`user_id`,`name`,`email`,`phone_number`,`street_address`,`city`,`state`,`zip`) VALUES ('$id','$name','$email','$phone','$address','$city','$state','$zip')";
    if(mysqli_query($conn,$query)){
      $user = $db -> query("SELECT * FROM `customers` WHERE `email` = '$email'");
      $customer_info = $user->fetch_assoc();
      $id = $customer_info['user_id'];
      $name = $customer_info['name'];
      //Insert into the orders table the order contents
      $customer = "INSERT INTO `orders` (`user_id`,`order_id`,`name`,`item_count`,`order_shipping_cost`,`order_tax`,`order_total`,`ship_date`) VALUES ('$id','$orderNumber','$name','$orderCount','$orderShippingCost','$orderTax','$orderTotal','$shippingDate')";
      if(mysqli_query($conn,$customer)){
        foreach ($request->cart as $key => $value) {
          $cart_id = $value->id;
          $cart_item = $key;
          $cart_item_quantity = $value->count;
          $cart_item_cost = $value->cost;
          //Insert the item order information into teh order_item table
          $db -> query("INSERT INTO `order_item` (`order_id`,`product_id`,`unit_cost`,`unit_count`,`product_name`,`shipped_date`) VALUES ('$orderNumber','$cart_id','$cart_item_cost','$cart_item_quantity','$cart_item','$shippingDate')");
        }
      }
      //set the result success messages
      $result['success']['success'] = true;
      $result['success']['order_number'] = $orderNumber;
      $result['success']['shipping'] = $request->shipping_time;
    }else {
      $result['error'] = true;
      $result['success'] = false;
      $result['message'] = "Error: Unable to add order!";
    }
  }
}
//json encode the result
$result = json_encode($result);
//set the header
header('Content-Type: application/json;charset=utf-8');
//echo the result to the client
echo($result);

?>
