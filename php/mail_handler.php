<?php
require_once('email_config.php');
require('phpmailer/PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->SMTPDebug = 0;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication


$mail->Username = EMAIL_USER;                 // SMTP username
$mail->Password = EMAIL_PASS;                 // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$options = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->smtpConnect($options);
$mail->From = $_POST['email'];//your email sending account
$mail->FromName = $_POST['name'];//your email sending account name
$mail->addAddress(PERSONAL_EMAIL/*your email address, or the email the sender if you are sending confirmation*/ /*email address user name*/);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo($_POST['email']/*email address of the person sending the message, so you can reply*/);
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $_POST['subject'];
$mail->Body    = $_POST['body'];
$mail->AltBody = $_POST['altBody'];

$output = [];

if(!$mail->send()) {
    //echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
    $output['error'] = 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    //echo 'Message has been sent';
    $output['success'] = "Thank You! Your message has been recieved. We will get back to you in two days. Have a Nice Day!";
}
$output = json_encode($output);
print($output);
?>
