<?php
session_start();
require_once('db_connect.php');

function orderNumber () {
  return uniqid('order#',false);
}


  $result = [];
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $token = $request->token;

  $shipDateConversion = strtotime("+3 days");
  $shippingDate = date("Y-m-d H:i:s",$shipDateConversion);

  $orderCount = $request->itemCount;
  $orderDiscount = $request->discount;
  $orderTax = $request->tax;
  $orderTotal = $request->total;
  $orderNumber = orderNumber();

  $token_result = $db -> query("SELECT * FROM `token` WHERE `token`='$token'");
  $row = $token->fetch_assoc();
  $timestamp = $row['unix_timestamp'];
  $username = $row['username'];
  if(($timestamp - time()) > 1800 ){
    $result['success'] = false;
    $result['error'] = true;
    $result['error']['message'] = "Error: Your session has expired. Please sign in again.";
    exit();
  }
  else {
    $user = $db -> query("SELECT * FROM `users` WHERE `username` = '$username'");
    $customer_info = $user->fetch_assoc();
    $id = $customer_info['id'];
    $name = $customer_info['name'];
    $email = $customer_info['email'];
    $phone = $customer_info['phone'];
    $address = $customer_info['street_address'];
    $city = $customer_info['city'];
    $state = $customer_info['state'];
    $zip = $customer_info['zip'];
    $customer = "INSERT INTO `customers` SET (`user_id`,`order_id`,`name`,`email`,`phone_number`,`street_address`, `city`,`state`,`zip`,`item_count`,`order_discount`,`order_tax`,`order_total`,`shipping_date`) VALUES ('$id','$orderNumber','$name','$email','$phone','$address','$city','$state','$zip','$orderCount','$orderDiscount','$orderTax','$orderTotal','$shippingDate')";

    foreach ($request->cart as $key => $value) {
      $cart_id = $value->id;
      $cart_item = $key;
      $cart_item_quantity = $value->quantity;
      $cart_item_cost = $value->cost;

      $db -> query("INSERT INTO `orders` SET (`order_id`,`product_id`,`unit_cost`,`unit_count`,`product_name`,`shipping_date`) VALUES ('$orderNumber','$cart_id','$cart_item_cost','$cart_item_quantity','$cart_item','$shippingDate')");
    }
  }

?>
