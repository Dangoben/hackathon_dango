<?PHP 

// Importation des class
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer \ PHPMailer \ SMTP ;


//Load Composer's autoloader
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

function Mailer($ExpediteurMail, $DestinateurMail, $ReplyMail, $Objet, $Message){

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings 1998
    $mail->SMTPDebug = 'SMTP::DEBUG_SERVER';                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.prosac.ci';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'hackathon@prosac.ci';                     //SMTP username
    $mail->Password   = 'OKOKOKOK123';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


    //Recipients
    $mail->setFrom($ExpediteurMail, 'HACKATHON');
    $mail->addAddress($DestinateurMail , '');     //Add a recipient
    $mail->addReplyTo($ReplyMail, $Objet);

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/img/logo.png', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $Objet;
    $mail->Body   .= $Message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    
} catch (Exception $e) {
    $reponse =  'ERREUR SERVER MAIL.';
    header("location:index.php?aff_reponse_fausse=".$reponse);
}


}

?>