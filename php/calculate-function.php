<?php
require_once('states.php');
function calculateCost ($cart,$state,$shipping) {
  global $states;
  $total = 0;
  foreach($cart as $key=>$value){
    $quantity = $value->count;
    $price = $value->cost;
    $total += $quantity * $price;
  }
  $tax;
  foreach ($states as $key => $value) {
    if($state === $key){
      $tax = $value;
    }
  }
  $tax = $total * $tax;
  $total += $shipping + $tax;
  $object = [];
  $object['tax'] = $tax;
  $object['shipping'] = $shipping;
  $object['total'] = $total;
  return $object;
}
?>
