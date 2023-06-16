<?php
SESSION_START();
include('connect_data.php');
INCLUDE('Function_Mail.php');


if (isset($_POST['datebegin']) && isset($_POST['date_end']) && isset($_POST['time_begin']) && isset($_POST['time_end']) && isset($_POST['titre']) && isset($_POST['note']) ) {

        $user_demandeur=htmlspecialchars($_POST['user_demandeur']);
        $user_receveur=htmlspecialchars($_POST['user_receveur']);
        $titre=htmlspecialchars($_POST['titre']);
        $note=htmlspecialchars($_POST['note']);
        $date_begin=htmlspecialchars($_POST['datebegin']);
        $date_end=htmlspecialchars($_POST['date_end']);
        $time_begin=htmlspecialchars($_POST['time_begin']);
        $time_end=htmlspecialchars($_POST['time_end']);

        $req = $bdd->prepare('INSERT INTO rdv (user_demandeur, user_receveur, date_debut, heure_debut, date_fin, heure_fin, titre, statu, notes, dateposte ) VALUES(:user_demandeur, :user_receveur, :date_debut, :heure_debut, :date_fin, :heure_fin, :titre, :statu, :notes, NOW() ) ');
        $req->execute(array(
             'user_demandeur' => $user_demandeur,
             'user_receveur' => $user_receveur,
             'date_debut' => $date_begin,
             'heure_debut' => $time_begin,
             'date_fin' => $date_end,
             'heure_fin' => $time_end,
             'titre' => $titre,
             'statu' => 'attente',
             'notes' => $note
        )); 

     // RETRAIT DU ID
     $notifi_ = $bdd->prepare('SELECT * FROM rdv WHERE user_demandeur=:user_demandeur AND user_receveur=:user_receveur AND date_debut=:date_debut AND heure_debut=:heure_debut ');
     $notifi_->execute(array(
          'user_demandeur' => $user_demandeur,
          'user_receveur' => $user_receveur,
          'date_debut' => $date_begin,
          'heure_debut' => $time_begin
     ));
     $res_notifi_ = $notifi_->fetch();

     $req = $bdd->prepare('INSERT INTO notification (id_user, id_rdv, type_notification, contenu, statu) VALUES ( :id_user, :id_rdv, :type_notification, :contenu, :statu) ');
       $req->execute(array(
         'id_user' =>$user_receveur,
         'id_rdv' =>$res_notifi_['id'],
         'type_notification' =>'Nouvelle demande de rendez-vous',
         'contenu' =>'Vous avez un nouveau rendez-vous',
         'statu' =>'Envoyé'
       ));


       // Message a envoyé au client en cas de succes
       $Message_valider='Bonjour monsieur/madame vous avez recu une nouvelle demande de rendez-vous';
         
       // Envoye de mail commande recus au client
       Mailer('hackathon@prosac.ci', $_POST['user_receveur_mail'], 'dangoben601@gmail.com', 'HACKATHON || NOTIFICATION', $Message_valider);

     $reponse =  'VOTRE RENDEZ-VOUS A BIEN ETE PRIS MERCI!';
     header("location:profile.php?profile=".$user_receveur."&aff_reponse=".$reponse);
        
}
else{
  $reponse =  'REMPLISSEZ TOUS LES CHAMPS DU FORMULAIRE SVP.';
  header("location:profile.php?profile=".$user_receveur."&aff_reponse_fausse=".$reponse);
}

?>