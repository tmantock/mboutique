<?php
session_start();
require_once('db_connect.php');

function orderNumber () {
  return uniqid('order#',false);
}

if(!empty($_POST['cart'])) {
  $shipDateConversion = strtotime("+3 days");
  $shippingDate = date("Y-m-d H:i:s",$shipDateConversion);

  $orderCount = $_POST['itemCount'];
  $orderDiscount = $_POST['discount'];
  $orderTax = $_POST['tax'];
  $orderTotal = $_POST['total'];
  $orderNumber = orderNumber();

  if(isset($_SESSION['user_id'])) {
    $user = $db -> query("SELECT * FROM `users` WHERE `user_id`='".$_SESSION['user_id']."'");
    if($user -> num_rows == 1){
      while($info = $user -> fetch_assoc()){
        $id = $_SESSION['user_id'];
        $name = $user['name'];
        $email = $user['email'];
        $phone = $user['phone'];
        $address = $user['street_address'];
        $city = $user['city'];
        $state = $user['state'];
        $zip = $user['zip'];
      }

      $customer = "INSERT INTO `customers` SET (`user_id`,`order_id`,`name`,`email`,`phone_number`,`street_address`, `city`,`state`,`zip`,`item_count`,`order_discount`,`order_tax`,`order_total`,`shipping_date`) VALUES ('$id','$orderNumber','$name','$email','$phone','$address','$city','$state','$zip','$orderCount','$orderDiscount','$orderTax','$orderTotal','$shippingDate')";
      if(mysqli_query($conn,$customer)){
        echo "Customer Successfully added";
      } else {
        echo "Unable to abb customer to system.";
      }
      foreach ($_POST['cart'] as $key => $value) {
        $cart_id = $value['id'];
        $cart_item = $key;
        $cart_item_quantity = $value['quantity'];
        $cart_item_cost = $value['cost'];

        $db -> query("INSERT INTO `orders` SET (`order_id`,`product_id`,`unit_cost`,`unit_count`,`product_name`,`shipping_date`) VALUES ('$orderNumber','$cart_id','$cart_item_cost','$cart_item_quantity','$cart_item','$shippingDate')");
      }
    }
  }
  else {
    foreach($_POST as $key => $value){
      if(empty($_POST[$key])){
        $error = "Error: Please enter your ". ucfirst($key) .'.';
        exit();
      }
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['street_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    $customer = "INSERT INTO `customers` SET (`user_id`,`order_id`,`name`,`email`,`phone_number`,`street_address`, `city`,`state`,`zip`,`item_count`,`order_discount`,`order_tax`,`order_total`,`shipping_date`) VALUES ('null','$orderNumber','$name','$email','$phone','$address','$city','$state','$zip','$orderCount','$orderDiscount','$orderTax','$orderTotal','$shippingDate')";
    if(mysqli_query($conn,$customer)){
      echo "Customer Successfully added";
    } else {
      echo "Unable to abb customer to system.";
    }
    foreach ($_POST['cart'] as $key => $value) {
      $cart_id = $value['id'];
      $cart_item = $key;
      $cart_item_quantity = $value['quantity'];
      $cart_item_cost = $value['cost'];

      $db -> query("INSERT INTO `orders` SET (`order_id`,`product_id`,`unit_cost`,`unit_count`,`product_name`,`shipping_date`) VALUES ('$orderNumber','$cart_id','$cart_item_cost','$cart_item_quantity','$cart_item','$shippingDate')");
    }

  }
} else {
  echo "Cart is empty";
  exit();
}


?>
