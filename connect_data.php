<?PHP 

try
{
  $pdo_option[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
  // $bdd = new PDO('mysql:host=localhost;dbname=prosacci_bdd','prosacci_user','gRb$hjE[38+%',$pdo_option);
  $bdd = new PDO('mysql:host=localhost;dbname=aackathon','root','',$pdo_option);
}
catch (Exception $e){
  die('Erreur : ' . $e->getMessage());
}

?>