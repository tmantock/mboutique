<?php
require_once('states-list.php');
$states = json_encode($states_list);
header('Content-Type: application/json');
echo($states);
?>
