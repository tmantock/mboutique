<?php
require_once('db_connect.php');
require_once('states-list.php');
//return array to be used as an associative array to be returned to the client
$return = [];
//function for validating the name
function nameRegex ($string){
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^[a-z ,.'-]+$/i";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['name_city'] = "Invalid name or city";
    return false;
  }
}
//function for validating the email
function emailRegex ($string){
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/\S+@\S+\.\S+/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['email'] = "Invalid email";
    return false;
  }
}
//function for validating the password
function passwordRegex ($string) {
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,50}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['password'] = "Invalid password";
    return false;
  }
}
//function for validating the phone number
function phoneRegex ($string) {
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['phone'] = "Invalid phone number";
    return false;
  }
}
//function for validating the address
function addressRegex ($string) {
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^[A-Za-z0-9'\.\#\-\s\,]*$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['address'] = "Invalid address";
    return false;
  }
}
//function for validating the zip code
function zipRegex ($string) {
  global $return;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  $exp = "/^[0-9]{5}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['zip'] = "Invalid zip";
    return false;
  }
}
//function for validating the state
function stateRegex ($string) {
  global $states_list;
  //Returns a string with backslashes stripped off
  $string = stripslashes($string);
  //returns a string with whitespace stripped from the beginning and end of string
  $string = trim($string);
  for($i = 0; $i < count($states_list); $i++){
    if(strtolower($states_list[$i]) === strtolower($string)){
      return true;
    }
  }
}
//function for getting the user from the database if they exist or create a new user
function login () {
  global $db, $conn, $return;
  //convert the post data in to useable data. Angular does something whne it comes to post data and php
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  //assign the variables for ease of use later on
  $password = $request->password;
  //generate a unique user id for the user
  $id = uniqid('mbq',false).time();
  $name = $request->name;
  $email = $request->email;
  $phone = $request->phone;
  $address = $request->address;
  $city = $request->city;
  $state = $request->state;
  $zip = $request->zip;
  $status = $request->status;
  $reason = $request->reason;

  //if the email and regex passes
  if(emailRegex($email) && passwordRegex($password)){
    //convert password for interaction with database. This would not be displayed on Github in a production environment, however since the purpose of this project is to demostrate my knowledge, I have allowed it to be stored on Github for examination.
    $password = md5($password);
    $password = sha1($password);
    //if the customer already exists and wants to change their password
    if($status === 'exist'){
      //Select all users from the database with the same email
      $user = $db -> query("SELECT `email` , `password`, `user_id` FROM `customers` WHERE `email` = '".$email."'");
      if($reason === 'update' && phoneRegex($phone) && addressRegex($address) && nameRegex($city) && zipRegex($zip) && stateRegex($state) && nameRegex(name) && $user -> num_rows === 1){
        $pass_check = $db -> query("SELECT * FROM `customers` WHERE `email`='".$email."' AND `password`='".$password."'");
        if($pass_check->num_rows===1){
          $query = "UPDATE `customers` SET `name`='$name',`phone_number`='$phone',`street_address`='$address',`city`='$city',`state`='$state',`zip`='$zip' WHERE `email`='$email'";
          if(!mysqli_query($conn,$query)){
            $return['success'] = false;
            $return['error']['message'] = "Unable to update information";
            //json_encode the $reruen array
            $return = json_encode($return);
            //set the header
            header('Content-Type: application/json');
            //echo the return to the client
            echo($return);
            exit();
          }
        }
        else {
          $return['success'] = false;
          $return['error']['message'] = "You have entered the wrong password";
          //json_encode the $reruen array
          $return = json_encode($return);
          //set the header
          header('Content-Type: application/json');
          //echo the return to the client
          echo($return);
          exit();
        }
      }
      //if ther is a user in existence
      else if($reason === 'password' && $user -> num_rows === 1) {
        //Set the users password equal to the new password
        $db -> query("UPDATE `customers` SET `password` = '$password' WHERE `email` = '$email'");
      }
      //if there is no user in teh data base then send and error message
      else{
        $return['success'] = false;
        $return['error']['message'] = "Unable to find email";
        //json_encode the $reruen array
        $return = json_encode($return);
        //set the header
        header('Content-Type: application/json');
        //echo the return to the client
        echo($return);
        exit();
      }
    }
    //if the user does not exist and regex is passed for all the values
    else if($status === false && phoneRegex($phone) && addressRegex($address) && nameRegex($city) && zipRegex($zip) && stateRegex($state)){
      //Select all users with the same email to check for duplicates and uniqueness
      $check = $db -> query("SELECT `email` FROM `customers` WHERE `email` ='$email'");
      //if there are no users with the same email
      if($check -> num_rows === 0){
        //Insert the new user into the customers table
        $query = "INSERT INTO `customers` (`user_id`,`password`,`name`,`email`,`phone_number`,`street_address`,`city`,`state`,`zip`) VALUES ('$id','$password','$name','$email','$phone','$address','$city','$state','$zip')";
        //if the insert was successful then continue, else display echo the error message
        if(mysqli_query($conn,$query)) {

        } else {
          $return['success'] = false;
          $return['error']['message'] = "Please enter all fields.";
          //json_encode the $reruen array
          $return = json_encode($return);
          //set the header
          header('Content-Type: application/json');
          //echo the return to the client
          echo($return);
          exit();
        }
      }
      //if the email is already taken, tehn echo the error message
      else {
        $return['success'] = false;
        $return['error']['email'] = false;
        $return['error']['message'] = "Error this email is already in use.";
        //json_encode the $reruen array
        $return = json_encode($return);
        //set the header
        header('Content-Type: application/json');
        //echo the return to the client
        echo($return);
        exit();
      }
    }
    //Select all users from the database with the matching email
    $user = $db -> query("SELECT `email`, `name` , `password`, `user_id` FROM `customers` WHERE `email` = '".$email."'");
    //Select from user without the password
    $userNoPassword = $db -> query("SELECT `email`, `name` , `street_address`, `zip`, `city`, `state`, `phone_number` FROM `customers` WHERE `email` = '".$email."'");
    //if there is a matching user
    if($user -> num_rows === 1 && $userNoPassword->num_rows === 1) {
      //Select all users with the matching email and password
      $password = $db -> query("SELECT `email` , `password`, `user_id` FROM `customers` WHERE `email` = '".$email."' AND `password` = '".$password."'");
      //if there is a matching user
      if($password->num_rows==1){
        //genereate a unique token. This would not be displayed on Github in a production environment, however since the purpose of this project is to demostrate my knowledge, I have allowed it to be stored on Github for examination.
        $token = uniqid('mbq',true);
        $token = sha1($token);
        $time = time();
        $token = $token.uniqid('token',true).$time;
        $token = sha1($token);

        $user = $userNoPassword->fetch_assoc();

        $return['success'] = true;
        $return['token'] = $token;
        $return['name'] = $user['name'];
        $return['user'] = $user;
        //Select all tokens where the user's email match
        $user_token = $db -> query("SELECT * FROM `token` WHERE `email`='$email'");
        //if token already exists then update the token
        if($user_token->num_rows==1){
          $db -> query("UPDATE `token` SET `token` = '$token' , `unix_timestamp` = '$time' WHERE `email` = '$email'");
        }
        //if the user does not exist in the token table then insert a new token
        else{
          $db->query("INSERT INTO `token`(`email`, `token`,`unix_timestamp`) VALUES ('$email' , '$token','$time')");
        }

      }
      //if the passwords do not match then set the error message
      else {
        $return['success'] = false;
        $return['error']['password'] = false;
        $return['error']['message'] = "Error you have entered the wrong password.";
      }
    }
    //if the user does not exist then set the error message
    else {
      $return['success'] = false;
      $return['error']['message'] = "Error we don't have any records of ".$email." in our records.";
    }
  }
  //json_encode the $reruen array
  $return = json_encode($return);
  //set the header
  header('Content-Type: application/json');
  //echo the return to the client
  echo($return);
}

login();

//close the database connections
mysqli_close($conn);
mysqli_close($db);
?>
