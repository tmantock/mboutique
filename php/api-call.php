<?php

require_once('db_connect.php');

function getUserBase () {

  global $db;

  $return = [];

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $username = $request->username;
  $password = $request->password;

  $password = md5($password);
  $password = sha1($password);

  $user = $db -> query("SELECT `username` , `password`, `user_id` FROM `users` WHERE `username` = '".$username."'");

  if($user -> num_rows == 1) {
    $password = $db -> query("SELECT `username` , `password`, `user_id` FROM `users` WHERE `username` = '".$username."' AND `password` = '".$password."'");
    if($password->num_rows==1){
      $token = uniqid('mbq',true);
      $token = sha1($token);
      $time = time();
      $token = $token.uniqid('token',true).$time;
      $token = sha1($token);

      $return['success']['success'] = true;
      $return['success']['token'] = $token;

      $db->query("INSERT INTO `token`(`username`, `token`,`unix_timestamp`) VALUES ('$username' , '$token','$time')");

      $return = json_encode($return);

      print($return);
    }
    else {
      $return['success'] = false;
      $return['error']['message'] = "Error you have entered the wrong password.";
    }
  }
  else {
    $return['success'] = false;
    $return['error']['message'] = "Error you have entered the wrong username.";
  }
}

getUserBase();

?>
