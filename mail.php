<?php

session_start();
include_once 'inc/config.php';
include_once 'inc/functions.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : die('ERROR: missing ID.');

if($id)
{
    $sql = "SELECT * FROM users
        WHERE users.id = $id";
    $result = mysqli_query($conn, $sql);
    
    //kontrola ci vratilo nejake vysledky
    if (mysqli_num_rows($result) > 0) 
    {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        $email = $row["email"];
        $full_name = $row["first_name"] . ' ' . $row["last_name"];
        /*
        $contribution_title = $row["title"];
        $section_title = $row["section.title"];
        $presentation_title = $row["presentation.title"];
        */


        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try 
        {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '3ae35682e5a4c3';
            $mail->Password = '942a5fc12af66a';                      

            //Recipients
            $mail->setFrom('123@conference.com', 'Conference');
            $mail->addAddress($email, $full_name);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('123@conference.com', 'Conference');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Your Contribution';
            $mail->Body    = 'Hello ' . $full_name . ',<br> Information about your contribution: ' . $contribution_title .'<br> Regards, <br> Conference team';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
            
            $mail->send();
            $_SESSION['email_ok'] = 'Email sent successfully!';
        } catch (Exception $e) {
            $_SESSION['email_error'] = 'Email sending failed Mailer Error: {$mail->ErrorInfo}';
        }
    }
    else {
            $_SESSION['email_error'] = 'User does not exist';
    }
}    
else
{
    $_SESSION['email_error'] = 'Unknown user';
}
header('location: contribution.php');
?>  