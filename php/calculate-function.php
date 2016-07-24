<?php
class Calculate {

  function __construct($states,$cart,$state,$shipping){
    $this->states = $states;
    $this->cart = $cart;
    $this->state = $state;
    $this->shipping = $shipping;
  }

  function totalCost () {
    $total = 0;
    foreach($this->cart as $key=>$value){
      $quantity = $value->count;
      $price = $value->cost;
      $total += $quantity * $price;
    }
    $tax;
    foreach ($this->states as $key => $value) {
      if($this->state === $key){
        $tax = $value;
      }
    }
    $tax = $total * $tax;
    $total += $this->shipping + $tax;
    $object = [];
    $object['tax'] = $tax;
    $object['shipping'] = $this->shipping;
    $object['total'] = $total;
    return $object;
  }
}
?>
