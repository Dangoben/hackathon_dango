<?PHP 

// Importation des class
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer \ PHPMailer \ SMTP ;


//Load Composer's autoloader
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

// try {

  //Server settings 1998
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'dangoben601@gmail.com';                     //SMTP username
    $mail->Password   = 'Disponible.123';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    // Définition du nom d'hôte
    $mail->Hostname = '197.149.232.37';

    //Recipients
    $mail->setFrom('dangoben601@gmail.com', 'HACKATHON');
    $mail->addAddress('dango.ben@djazy.ci' , '');     //Add a recipient
    $mail->addReplyTo('dangoben601@gmail.com', 'TEST ');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/img/logo.png', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'TEST';
    $mail->Body   .= 'Validation du test';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    
// } catch (Exception $e) {
//     $reponse =  'ERREUR SERVER MAIL.';
//     header("location:index.php?aff_reponse_fausse=".$reponse);
// }

?>