<?php
require_once('shipping.php');
require_once('states.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$state = $request->state;
$cart = $request->cart;
if(empty($request->shipping_time)){
  $shipping = shipping(2);
} else {
  $shipping = shipping($request->shipping_time);
}
$cart = json_decode($cart);
$total = 0;
foreach($cart as $key=>$value){
  $total += $value['count'] * $value['cost'];
}
$tax;
foreach ($states as $key => $value) {
  if($state === $key){
    $tax = $value;
  }
}
$tax = $total * $tax;
$total += $shipping + $tax;

$return =[];
$return['success'] = true;
$return['tax'] = $tax;
$return['shipping'] = $shipping;
$return['total'] = $total;

header('Content-Type: application/json');
echo(json_encode($return));
?>
