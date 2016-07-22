<?php
require_once('states-list.php');
$states = json_encode($states);
header('Content-Type: application/json');
echo($states);
?>
