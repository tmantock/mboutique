<?php
class Shipping {
  function __construct($shipping_time){
    $this->shipping_time = $shipping_time;
  }

  function calculateShipping(){
    if($this->shipping_time === 2){
      $shipping_cost = 6.99;
      $shipDateConversion = strtotime("+2 days");
      $shippingDate = date("Y-m-d H:i:s",$shipDateConversion);
    } else if ($this->shipping_time === 3) {
      $shipping_cost = 3.99;
      $shipDateConversion = strtotime("+3 days");
      $shippingDate = date("Y-m-d H:i:s",$shipDateConversion);
    } else if ($this->shipping_time === 5){
      $shipping_cost = 2.99;
      $shipDateConversion = strtotime("+5 days");
      $shippingDate = date("Y-m-d H:i:s",$shipDateConversion);
    }
    $ship = [];
    $ship['cost'] = $shipping_cost;
    $ship['date'] = $shippingDate;
    return $ship;
  }
}
?>
