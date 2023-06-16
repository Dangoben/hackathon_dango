<?php
 
/**
 * @Var string source: source de l'image dépuis le tmp_name
 * @Var string destination: le dossier dans lequel l'image sera envoyé
 * @var string quality: le pourcentage de compression 0 à 100. Plus la qualité est faible plus l'image est compresser
 * @var string mime: la valeur du mime à récuperer dépuis le tableau $_FILES de l'image
 *
 * @Return string renvoie le lien vers l'image 
 */
function compressImage($source, $destination, $quality, $mime): string { 
    // Create a new image from file
    $image = false;
    $image_data = file_get_contents($source);
    try {
          $image = imagecreatefromstring($image_data);
    } catch (Exception $ex) {
          $image = false;
    }

    if ($image !== false){
      // Save image 
     imagejpeg($image, $destination, $quality); 
    }
    // Return compressed image 
    return $destination; 
}

// $name= $_FILES['product']["name"];
// $source= $_FILES['product']["tmp_name"];
// $destination= 'js';
// $quality= 50;
// $mime= $_FILES['product']["type"];
// compressImage($source, $destination.'/'.$name, $quality, $mime);



?>