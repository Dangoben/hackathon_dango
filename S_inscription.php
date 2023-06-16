<?php
SESSION_START();
include('connect_data.php');
include('S_compression_unit.php');
$page= 'inscription.php';
// include('Function_Mail.php');
$code = hash('sha256', (microtime()));

function validatePassword($password) {
    return strlen($password) >= 8;
}

if (
    isset($_POST['nom']) &&  
    isset($_POST['tel']) && 
    isset($_POST['adresse']) && 
    isset($_POST['mdp']) && 
    isset($_POST['rmdp']) && 
    isset($_POST['mail']) 
) {
    $nom = strip_tags($_POST['nom']);
    $tel = strip_tags($_POST['tel']);
    $email = strip_tags($_POST['mail']);
    $adresse = strip_tags($_POST['adresse']);
    $mdp = strip_tags($_POST['mdp']);
    $rmdp = strip_tags($_POST['rmdp']);
    if (isset($_FILES['profile']['name'])) {
      $image = $_FILES['profile']['name'];
    }
    else{
      $image='';
    }

    if ($mdp === $rmdp) {
        $stmt = $bdd->prepare('SELECT * FROM membre WHERE password = ? OR mail = ?'); 
        $stmt->execute(array($mdp, $email));
        $coucou = $stmt->fetch();

        if (!empty($coucou['password']) || !empty($coucou['mail'])) {
            if (!empty($coucou['password'])) {
                $reponse = 'MOT DE PASSE EXISTE, ESSAYEZ-EN UN AUTRE.';
                header("location: inscription.php?aff_reponse_fausse=".$reponse);
            } elseif (!empty($coucou['mail'])) {
                $reponse = 'ADRESSE EMAIL EXISTE, ESSAYEZ-EN UNE AUTRE.';
                header("location: inscription.php?aff_reponse_fausse=".$reponse);
            }
            exit();
        } else {
            if (validatePassword($mdp)) {
                $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT); // Hashage du mot de passe

                $reponse = $bdd->prepare('INSERT INTO membre (nom, tel, adresse, mail, password, profile_picture, codehash, date_create) VALUES (:nom, :tel, :adresse, :mail, :password, :profile_picture, :codehash, NOW())');
                $reponse->execute(array(
                    'nom' => $nom,
                    'tel' => $tel,
                    'adresse' => $adresse,
                    'mail' => $email,
                    'password' => $hashedPassword,
                    'profile_picture' => $image,
                    'codehash' => $code
                ));

                // Code pour télécharger et enregistrer l'image dans un répertoire sur le serveur
                if (isset($_FILES['profile']['name'])) {
                  // COMPRESSION DU FICHIER
                  $file_name= $_FILES['profile']['name'];
                  $source= $_FILES['profile']['tmp_name'];
                  $file_error= $_FILES['profile']['error'];
                  $file_size= $_FILES['profile']['size'];
                  $destination= 'img/profile';
                  $mime=$_FILES['profile']['type'];
                  $quality= 50;
                  INCLUDE('S_picture_upload.php');
                }

                // Message à envoyer au client en cas de succès
                // $Message_valider = 'Bonjour Monsieur/Madame '.$nom.', bienvenue chez AB Guinée Store, votre plate-forme de vente en ligne en Guinée. Nous sommes heureux de vous compter parmi nous. Vos coordonnées de connexion sont les suivantes : Adresse Email : '.$email.' / Mot de passe : '.$mdp;

                // Envoi de l'email de confirmation au client
                // Mailer('assistance@ab-guineestore.com', $email, 'abguineestore859@gmail.com', 'COMPTE || AB-Guinée', $Message_valider);

                $stmt = $bdd->prepare('SELECT * FROM membre WHERE mail = ? AND password = ?');
                $stmt->execute(array($email, $hashedPassword));
                $andré = $stmt->fetch();
                
                if (isset($andré['password']) && isset($andré['mail'])) {

                    $_SESSION['ID_connect_hackthon'] = 'Rendez-vous-project9989';
                    $_SESSION['id'] = $andré['id'];
                    $_SESSION['nom'] = $andré['nom'];
                    $_SESSION['adresse'] = $andré['adresse'];
                    $_SESSION['tel'] = $andré['tel'];
                    $_SESSION['mail'] = $andré['mail'];
                    $_SESSION['profile_picture'] = $andré['profile_picture'];
                    $_SESSION['password'] = $andré['password'];

                    $reponse = 'BIENVENUE SUR HACKATHON GESTION DE RENDEZ-VOUS.';
                    header("location: index.php?aff_reponse=".$reponse);
                } else {
                    $reponse = 'INSCRIPTION RÉUSSIE, MERCI.';
                    header("location: index.php?aff_reponse=".$reponse);
                }
            } else {
                $reponse = 'MOT DE PASSE TROP COURT, MINIMUM 8 CARACTÈRES.';
                header("location: inscription.php?aff_reponse_fausse=".$reponse);
                exit();
            }
        }
    } else {
        $reponse = 'MOTS DE PASSE DIFFÉRENTS.';
        header("location: inscription.php?aff_reponse_fausse=".$reponse);
        exit();
    }
} else {
    $reponse = 'VEUILLEZ REMPLIR TOUS LES CHAMPS DU FORMULAIRE.';
    header("location: inscription.php?aff_reponse_fausse=".$reponse);
    exit();
}
?>