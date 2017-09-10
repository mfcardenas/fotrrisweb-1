<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 4/03/17
 * Time: 19:51
 */

function sendMail($user, $pass, $mailTo, $mailCc){
    $to = $mailTo;
    $subject = "Forgot Password FoTRRIS";

    $message = "
        <html>
        <head>
        <title>Forgot Password FoTRRIS</title>
        </head>
        <body>
            <br/>
            <p>Dear user,</p>
            <br/>
            <p>Your FoTRRIS password has been reset to</p>
            <p>".$pass."</p>
            <p>We recommend to change the password immediately when you log in to FoTRRIS Platform. You can change the password using the menu items click on the Picture->My Profile.</p>
            <p>Please note that for logging in you will need to use both your email and your password. Your email was shown to you when you confirmed your password reset request. If you forgot your email you should contact the webmaster (subautis@ucm.es).</p>
            <br/>
            <br/>
            <p>Best regards,<br/>FoTRRIS team.</p>
        </body>
        </html>
        ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <subautis@ucm.es>' . "\r\n";
    if ($mailCc != null){
        $headers .= 'Cc: '. $mailCc . "\r\n";
    }

    return mail($to,$subject,$message,$headers);

}

?>