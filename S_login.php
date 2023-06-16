<?php
session_start(); // Démarrer la session dès le début du code
include('connect_data.php');

if (isset($_POST['mail']) && isset($_POST['mdp'])) {
    $mail = strip_tags($_POST['mail']);
    $mdp = strip_tags($_POST['mdp']);

    $stmt = $bdd->prepare('SELECT * FROM membre WHERE mail = ?');
    $stmt->execute(array($mail));
    $information = $stmt->fetch();

    if (empty($information)) {
        $reponse = 'Veuillez vous inscrire SVP.';
        header("location: index.php?aff_reponse_fausse=".$reponse);
        exit();
    } else {
        $hashedPassword = $information['password'];
        if (password_verify($mdp, $hashedPassword)) {
            $_SESSION['ID_connect_hackthon'] = 'Rendez-vous-project9989';
            $_SESSION['id'] = $information['id'];
            $_SESSION['nom'] = $information['nom'];
            $_SESSION['mail'] = $information['mail'];
            $_SESSION['tel'] = $information['tel'];
            $_SESSION['adresse'] = $information['adresse'];
            $_SESSION['profile_picture'] = $information['profile_picture'];

            $reponse = 'Vous êtes maintenant connecté.';
            header("location: index.php?aff_reponse=".$reponse);
            exit();
        } else {
            $reponse = 'Le mot de passe est incorrect.';
            header("location: index.php?aff_reponse_fausse=".$reponse);
            exit();
        }
    }
} else {
    $reponse = 'Veuillez remplir tous les champs.';
    header("location: index.php?aff_reponse_fausse=".$reponse);
    exit();
}
?>
