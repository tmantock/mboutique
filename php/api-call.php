<?php

require_once('db_connect.php');
function getUserBase () {

  global $db, $conn;
  $return = [];
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);

  $password = $request->password;

  $password = md5($password);
  $password = sha1($password);

  $id = uniqid('mbq',false).time();
  $name = $request->name;
  $email = $request->email;
  $phone = $request->phone;
  $address = $request->address;
  $city = $request->city;
  $state = $request->state;
  $zip = $request->zip;
  $status = $request->status;

  if($status === false){
    $check = $db -> query("SELECT `email` FROM `customers` WHERE `email` ='$email'");
    if($check -> num_rows == 0){
      $query = "INSERT INTO `customers` (`user_id`,`password`,`name`,`email`,`phone_number`,`street_address`,`city`,`state`,`zip`) VALUES ('$id','$password','$name','$email','$phone','$address','$city','$state','$zip')";
      if(mysqli_query($conn,$query)) {

      } else {
        $return['success'] = false;
        $return['error']['message'] = "Please enter all fields.";
      }
    }
    else {
      $return['success'] = false;
      $return['error']['email'] = false;
      $return['error']['message'] = "Error this email is already in use.";
      print(json_encode($return));
      exit();
    }
  }

  $user = $db -> query("SELECT `email` , `password`, `user_id` FROM `customers` WHERE `email` = '".$email."'");

  if($user -> num_rows == 1) {
    $password = $db -> query("SELECT `email` , `password`, `user_id` FROM `customers` WHERE `email` = '".$email."' AND `password` = '".$password."'");
    if($password->num_rows==1){
      $token = uniqid('mbq',true);
      $token = sha1($token);
      $time = time();
      $token = $token.uniqid('token',true).$time;
      $token = sha1($token);

      $user = $db -> query("SELECT `name`,`email` FROM `customers` WHERE `email` = '$email'");
      $name = $user->fetch_assoc();

      $return['success'] = true;
      $return['token'] = $token;
      $return['name'] = $name['name'];

      $user_token = $db -> query("SELECT * FROM `token` WHERE `email`='$email'");
      if($user_token->num_rows==1){
        $db -> query("UPDATE `token` SET `token` = '$token' , `unix_timestamp` = '$time' WHERE `email` = '$email'");
      }
      else{
        $db->query("INSERT INTO `token`(`email`, `token`,`unix_timestamp`) VALUES ('$email' , '$token','$time')");
      }

    }
    else {
      $return['success'] = false;
      $return['error']['message'] = "Error you have entered the wrong password.";
    }
  }
  else {
    $return['success'] = false;
    $return['error']['message'] = "Error you have entered the wrong email.";
  }

  header('Content-Type: application/json');
  $return = json_encode($return);
  echo($return);
}

getUserBase();

?>
