<?php
require_once('db_connect.php');

function orderNumber () {
  return uniqid('ORD',false);
}


  $result = [];
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $token = $request->token;

  $shipDateConversion = strtotime("+3 days");
  $shippingDate = date("Y-m-d H:i:s",$shipDateConversion);

  $orderCount = $request->quantity;
  $orderDiscount = $request->discount;
  $orderTax = $request->tax;
  $orderTotal = $request->total;
  $orderNumber = orderNumber();

  $token_result = $db -> query("SELECT * FROM `token` WHERE `token`='$token'");
  $row = $token_result->fetch_assoc();
  $timestamp = $row['unix_timestamp'];
  $username = $row['username'];
  if(($timestamp - time()) > 1800 ){
    $result['success'] = false;
    $result['error'] = true;
    $result['error']['message'] = "Error: Your session has expired. Please sign in again.";
    $result = json_encode($result);
    print($result);
    exit();
  }
  else {
    $user = $db -> query("SELECT * FROM `customers` WHERE `username` = '$username'");
    $customer_info = $user->fetch_assoc();
    $id = $customer_info['user_id'];
    $name = $customer_info['name'];

    $customer = "INSERT INTO `orders` (`user_id`,`order_id`,`name`,`item_count`,`order_discount`,`order_tax`,`order_total`,`ship_date`) VALUES ('$id','$orderNumber','$name','$orderCount','$orderDiscount','$orderTax','$orderTotal','$shippingDate')";
    if(mysqli_query($conn,$customer)){
      foreach ($request->cart as $key => $value) {
        $cart_id = $value->id;
        $cart_item = $key;
        $cart_item_quantity = $value->quantity;
        $cart_item_cost = $value->cost;

        $db -> query("INSERT INTO `order_item` (`order_id`,`product_id`,`unit_cost`,`unit_count`,`product_name`,`shipped_date`) VALUES ('$orderNumber','$cart_id','$cart_item_cost','$cart_item_quantity','$cart_item','$shippingDate')");
      }

      $result['success']['success'] = true;
      $result['success']['order_number'] = $orderNumber;
    }
    else {
      $result['error'] = true;
      $result['success'] = false;
      $result['message'] = "Error: Unable to add order!";
    }

  }

  $result = json_encode($result);
  print($result);

?>
