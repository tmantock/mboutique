<?php
function shipping($shipping_time){
  $shipping_cost;
  if($shipping_time === '2'){
    $shipping_cost = 10.99;
  } else if ($shipping_time === '3') {
    $shipping_cost = 7.99;
  } else if ($shipping_cost === '5'){
    $shipping_cost = 5.99;
  }
  return $shipping_cost;
}
?>
