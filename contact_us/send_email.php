<?php
// Gmail SMTP settings
$smtpServer = 'smtp.gmail.com';
$smtpUsername = 'your_email@gmail.com'; // Replace with your Gmail address
$smtpPassword = 'your_app_password_here'; // Replace with your Gmail App Password
$smtpPort = '587'; // Gmail SMTP port

// Admin email address
$adminEmail = 'walimaher00@gmail.com'; // Replace with the email address where you want to receive the contact form submissions

// Get form data
$message = $_POST['message'];

// Email content
$subject = 'New Contact Form Submission';
$body = "Message: $message";

// Email body
$emailBody = "--boundary-string\r\n";
$emailBody .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
$emailBody .= "Content-Transfer-Encoding: quoted-printable\r\n";
$emailBody .= "Content-Disposition: inline\r\n";
$emailBody .= "\r\n";
$emailBody .= "Message: $message\r\n";
$emailBody .= "\r\n";
$emailBody .= "--boundary-string\r\n";
$emailBody .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
$emailBody .= "Content-Transfer-Encoding: quoted-printable\r\n";
$emailBody .= "Content-Disposition: inline\r\n";
$emailBody .= "\r\n";
$emailBody .= "<!doctype html>\r\n";
$emailBody .= "<html>\r\n";
$emailBody .= "  <head>\r\n";
$emailBody .= "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n";
$emailBody .= "  </head>\r\n";
$emailBody .= "  <body style=\"font-family: sans-serif;\">\r\n";
$emailBody .= "    <div style=\"display: block; margin: auto; max-width: 600px;\" class=\"main\">\r\n";
$emailBody .= "      <h1 style=\"font-size: 18px; font-weight: bold; margin-top: 20px\">New Contact Form Submission</h1>\r\n";
$emailBody .= "      <p>Message: $message</p>\r\n";
$emailBody .= "    </div>\r\n";
$emailBody .= "    <style>\r\n";
$emailBody .= "      .main { background-color: white; }\r\n";
$emailBody .= "      a:hover { border-left-width: 1em; min-height: 2em; }\r\n";
$emailBody .= "    </style>\r\n";
$emailBody .= "  </body>\r\n";
$emailBody .= "</html>\r\n";
$emailBody .= "\r\n";
$emailBody .= "--boundary-string--\r\n";

// PHPMailer library
require_once('../PHPMailer/src/PHPMailer.php'); 
require_once('../PHPMailer/src/SMTP.php');  // Include SMTP class

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = $smtpServer;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port = $smtpPort;

    //Recipients
    $mail->setFrom('from@example.com', 'Magic Elves');
    $mail->addAddress($adminEmail, 'Admin Name');  // Use the adminEmail variable

    //Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $emailBody;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo "<br>Admin Email: $adminEmail";  // Debugging line
}
?>