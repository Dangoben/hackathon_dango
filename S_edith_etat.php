<?php
SESSION_START();
include('connect_data.php');
// INCLUDE('Function_Mail.php');

if (isset($_GET['rdv']) AND isset($_GET['statu']) AND isset($_GET['user_demandeur']) ) {

   $statu=htmlspecialchars($_GET['statu']);
   $rdv=htmlspecialchars($_GET['rdv']);
   $user_demandeur=htmlspecialchars($_GET['user_demandeur']);

   $req = $bdd->prepare('UPDATE rdv SET statu= :statu WHERE id=:id ');
   $req->execute(array(
      'statu' =>$statu,
      'id' =>$rdv
   ));


   $req = $bdd->prepare('SELECT * FROM membre WHERE id=:id ');
   $req->execute(array('id' =>$user_demandeur));
   $res_req=$req->fetch();

  // // Message a envoyé au client en cas de succes
  // $Message_valider='Bonjour monsieur/madame '.$res_req['nom'].' Votre demande de rendez-vous à été '.$statu;
    
  // // Envoye de mail commande recus au client
  // Mailer('dangoben601@gmail.com', $res_req['mail'], 'dangoben601@gmail.com', 'HACKATHON || NOTIFICATION', $Message_valider);

  // NOTIFICATION DATE
  $req = $bdd->prepare('INSERT INTO notification (id_user, id_rdv, type_notification, contenu, statu) VALUES ( :id_user, :id_rdv, :type_notification, :contenu, :statu) ');
  $req->execute(array(
    'id_user' =>$user_demandeur,
    'id_rdv' =>$rdv,
    'type_notification' =>'Etat de demande de rendez-vous',
    'contenu' =>$statu,
    'statu' =>'Envoyé'
  ));
  
  $reponse =  'ETAT COCHER.';
  header("location:dashboard_user.php?aff_reponse=".$reponse);

}
else{
  $reponse =  'VEUILLEZ CLICKER SUR UN BUTTON.';
  header("location:dashboard_user.php?aff_reponse_fausse=".$reponse);
}


?>
