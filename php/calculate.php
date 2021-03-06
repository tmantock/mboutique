<?php
require_once('shipping.php');
require_once('states.php');
require_once('calculate-function.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$state = $request->state;
$cart = $request->cart;
$ship_calc = new Shipping(intval($request->shipping_time));
$shipping = $ship_calc->calculateShipping();

$calculate = new Calculate($states_tax,$cart,$state,$shipping['cost']);
$calculation = $calculate->totalCost();

$return =[];
$return['success'] = true;
$return['tax'] = $calculation['tax'];
$return['shipping'] = $calculation['shipping'];
$return['total'] = $calculation['total'];
header('Content-Type: application/json');
echo(json_encode($return));
?>
