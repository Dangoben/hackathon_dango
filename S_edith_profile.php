<?php
SESSION_START();
include('connect_data.php');
include('S_compression_unit.php');
$page='advanced_form_components.php';
// include('Function_Mail.php');

function validatePassword($password) {
    // Vérifier si le mot de passe a au moins 8 caractères
    if(strlen($password) >= 8) {
        return true;
    }
    return false;
}

if(isset($_POST['nom']) && isset($_POST['tel']) && isset($_POST['adresse']) && isset($_POST['mail']) && isset($_POST['mdp']) && isset($_POST['nmdp']) && isset($_FILES['profile'])) {
    $nom = strip_tags($_POST['nom']);
    $tel = strip_tags($_POST['tel']);
    $adresse = strip_tags($_POST['adresse']);
    $mail = strip_tags($_POST['mail']);
    $mdp = strip_tags($_POST['mdp']);
    $nmdp = strip_tags($_POST['nmdp']);

    // Vérifier si l'utilisateur existe dans la base de données
    $ben = $bdd->prepare('SELECT * FROM membre WHERE id = :id');
    $ben->execute(array('id' => $_SESSION['id']));
    $information = $ben->fetch();

    if(empty($information)) {
        $reponse = 'Utilisateur introuvable.';
        header("location:index.php?aff_reponse_fausse=".$reponse);
        exit();
    }

    // Vérifier si le mot de passe est correct
    if(password_verify($mdp, $information['password'])) {
        // Vérifier la validité du nouveau mot de passe
        if(validatePassword($nmdp)) {
            // Hacher le nouveau mot de passe
            $hashedPassword = password_hash($nmdp, PASSWORD_DEFAULT);

            // Mettre à jour les informations de l'utilisateur
            $update = $bdd->prepare('UPDATE membre SET nom = :nom, tel = :tel, adresse = :adresse, mail = :mail, password = :nmdp WHERE id = :id');
            $update->execute(array(
                'nom' => $nom,
                'tel' => $tel,
                'adresse' => $adresse,
                'mail' => $mail,
                'nmdp' => $hashedPassword,
                'id' => $_SESSION['id']
            ));

            // Vérifier si la mise à jour a réussi
            if($update) {
                // Mettre à jour les informations dans la session
                $_SESSION['nom'] = $nom;
                $_SESSION['tel'] = $tel;
                $_SESSION['adresse'] = $adresse;
                $_SESSION['mail'] = $mail;
                $_SESSION['mdp'] = $nmdp;

                // Vérifier si un fichier d'image a été téléchargé
                if (isset($_FILES['profile']['name'])) {
                    // COMPRESSION DU FICHIER
                    $file_name= $_FILES['profile']['name'];
                    $source= $_FILES['profile']['tmp_name'];
                    $file_error= $_FILES['profile']['error'];
                    $file_size= $_FILES['profile']['size'];
                    $destination= 'img/profile';
                    $mime=$_FILES['profile']['type'];
                    $quality= 50;
                    $code=$information['codehash'];

                    INCLUDE('S_picture_upload.php');

                    $_SESSION['profile_picture'] = $chemin_acces_img_produit;
                }

                $reponse = 'Vos informations ont été mises à jour avec succès.';
                header("location:".$page."?aff_reponse=".$reponse);
                exit();
            } else {
                $reponse = 'Une erreur est survenue lors de la mise à jour des informations.';
                header("location:".$page."?aff_reponse_fausse=".$reponse);
                exit();
            }
        } else {
            $reponse = 'Le nouveau mot de passe doit comporter au moins 8 caractères.';
            header("location:".$page."?aff_reponse_fausse=".$reponse);
            exit();
        }
    } else {
        $reponse = 'Mot de passe incorrect.';
        header("location:".$page."?aff_reponse_fausse=".$reponse);
        exit();
    }
} else {
    $reponse = 'Veuillez remplir tous les champs.';
    header("location:".$page."?aff_reponse_fausse=".$reponse);
    exit();
}
?>
