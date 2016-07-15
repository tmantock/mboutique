<?php
require_once('db_connect.php');
$return = [];

function nameRegex ($string){
  global $return;
  $exp = "/^[a-z ,.'-]+$/i";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['name_city'] = "Invalid name or city";
    return false;
  }
}

function emailRegex ($string){
  global $return;
  $exp = "/\S+@\S+\.\S+/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['email'] = "Invalid email";
    return false;
  }
}

function passwordRegex ($string) {
  global $return;
  $exp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['password'] = "Invalid password";
    return false;
  }
}

function phoneRegex ($string) {
  global $return;
  $exp = "/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['phone'] = "Invalid phone number";
    return false;
  }
}

function addressRegex ($string) {
  global $return;
  $exp = "/[A-Za-z0-9'\.\-\s\,]/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['address'] = "Invalid address";
    return false;
  }
}

function zipRegex ($string) {
  global $return;
  $exp = "/^[0-9]{5}$/";
  if(preg_match($exp,$string)){
    return true;
  } else {
    $return['success'] = false;
    $return['error']['validation']['zip'] = "Invalid zip";
    return false;
  }
}

function stateRegex ($string) {
  $states = array(
  	'AL'=>'ALABAMA',
  	'AK'=>'ALASKA',
  	'AS'=>'AMERICAN SAMOA',
  	'AZ'=>'ARIZONA',
  	'AR'=>'ARKANSAS',
  	'CA'=>'CALIFORNIA',
  	'CO'=>'COLORADO',
  	'CT'=>'CONNECTICUT',
  	'DE'=>'DELAWARE',
  	'DC'=>'DISTRICT OF COLUMBIA',
  	'FM'=>'FEDERATED STATES OF MICRONESIA',
  	'FL'=>'FLORIDA',
  	'GA'=>'GEORGIA',
  	'GU'=>'GUAM GU',
  	'HI'=>'HAWAII',
  	'ID'=>'IDAHO',
  	'IL'=>'ILLINOIS',
  	'IN'=>'INDIANA',
  	'IA'=>'IOWA',
  	'KS'=>'KANSAS',
  	'KY'=>'KENTUCKY',
  	'LA'=>'LOUISIANA',
  	'ME'=>'MAINE',
  	'MH'=>'MARSHALL ISLANDS',
  	'MD'=>'MARYLAND',
  	'MA'=>'MASSACHUSETTS',
  	'MI'=>'MICHIGAN',
  	'MN'=>'MINNESOTA',
  	'MS'=>'MISSISSIPPI',
  	'MO'=>'MISSOURI',
  	'MT'=>'MONTANA',
  	'NE'=>'NEBRASKA',
  	'NV'=>'NEVADA',
  	'NH'=>'NEW HAMPSHIRE',
  	'NJ'=>'NEW JERSEY',
  	'NM'=>'NEW MEXICO',
  	'NY'=>'NEW YORK',
  	'NC'=>'NORTH CAROLINA',
  	'ND'=>'NORTH DAKOTA',
  	'MP'=>'NORTHERN MARIANA ISLANDS',
  	'OH'=>'OHIO',
  	'OK'=>'OKLAHOMA',
  	'OR'=>'OREGON',
  	'PW'=>'PALAU',
  	'PA'=>'PENNSYLVANIA',
  	'PR'=>'PUERTO RICO',
  	'RI'=>'RHODE ISLAND',
  	'SC'=>'SOUTH CAROLINA',
  	'SD'=>'SOUTH DAKOTA',
  	'TN'=>'TENNESSEE',
  	'TX'=>'TEXAS',
  	'UT'=>'UTAH',
  	'VT'=>'VERMONT',
  	'VI'=>'VIRGIN ISLANDS',
  	'VA'=>'VIRGINIA',
  	'WA'=>'WASHINGTON',
  	'WV'=>'WEST VIRGINIA',
  	'WI'=>'WISCONSIN',
  	'WY'=>'WYOMING',
  	'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
  	'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
  	'AP'=>'ARMED FORCES PACIFIC'
  );

  foreach($states as $key=>$value){
    if($value === $string){
      return true;
    }
  }
}

function getUserBase () {
  global $db, $conn, $return;
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);

  $password = $request->password;

  $id = uniqid('mbq',false).time();
  $name = $request->name;
  $email = $request->email;
  $phone = $request->phone;
  $address = $request->address;
  $city = $request->city;
  $state = $request->state;
  $zip = $request->zip;
  $status = $request->status;

  if(emailRegex($email) && passwordRegex($password)){
    //conver password for interaction with database
    $password = md5($password);
    $password = sha1($password);

    if($status === 'exist'){
      $user = $db -> query("SELECT `email` , `password`, `user_id` FROM `customers` WHERE `email` = '".$email."'");
      if($user -> num_rows === 1) {
        $db -> query("UPDATE `customers` SET `password` = '$password' WHERE `email` = '$email'");
      }else{
        $return['success'] = false;
        $return['error']['message'] = "Unable to find email";
      }
    }
    else if($status === false && phoneRegex($phone) && addressRegex($address) && nameRegex($city) && zipRegex($zip) && stateRegex($state)){
      $return['check'] = 'made it staus of true';
      $check = $db -> query("SELECT `email` FROM `customers` WHERE `email` ='$email'");
      if($check -> num_rows === 0){
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
        header('Content-Type: application/json');
        echo(json_encode($return));
        exit();
      }
    }

    $user = $db -> query("SELECT `email` , `password`, `user_id` FROM `customers` WHERE `email` = '".$email."'");
    if($user -> num_rows === 1) {
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
        $return['error']['password'] = false;
        $return['error']['message'] = "Error you have entered the wrong password.";
      }
    }
    else {
      $return['success'] = false;
      $return['error']['message'] = "Error we don't have any records of ".$email." in our records.";
    }
  }
  $return = json_encode($return);
  header('Content-Type: application/json');
  echo($return);
}

getUserBase();
?>
