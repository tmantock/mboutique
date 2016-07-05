<?php
require_once("mysql_connect.config.php");
//Beginning query for joining the two tables for retrieve
$db -> query("SELECT *.`purchases`,`created_date`.`orders`,`processed_date`.`orders`, `ship_date`.`orders`,`item_count`.`orders`,`order_total`.`orders`,`order_tax`.`orders`,`order_discount`.`orders` FROM `customers` JOIN `orders` ON `ext_id` = `order_number`");
?>
