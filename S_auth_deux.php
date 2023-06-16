<?php
SESSION_START();

include('connect_data.php');
// INCLUDE('Function_Mail.php');

if (isset($_POST['codev']) ) {

   $codev=htmlspecialchars($_POST['codev']);

   if ($codev==$_SESSION['auth']) {
      $req = $bdd->prepare('UPDATE membre SET auth="entrer" WHERE id=:id ');
      $req->execute(array(
         'id' =>$_SESSION['id']
      ));

      $_SESSION['auth']='entrer';

      $reponse =  'CONNEXION REUSSIT';
      header("location:dashboard_user.php?aff_reponse=".$reponse);
   }
   else{

      $reponse =  'LE CODE EST INCORRECT';
      header("location:auth_d.php?aff_reponse_fausse=".$reponse);

   }

}
else{
  $reponse =  'VEUILLEZ SAISIR LE CODE RECUS PAR MAIL.';
  header("location:auth_d.php?aff_reponse_fausse=".$reponse);
}


?>