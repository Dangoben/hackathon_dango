<?php

if (!empty($source)) {
    if ($file_error == 0) {
        if ($file_size <= 10000000) {
            $file_name = $file_name;
            $infosfichier = pathinfo($file_name);
            $extension_upload = strtolower($infosfichier['extension']);
			$extensions_autorisees=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG' );

            if (in_array($extension_upload, $extensions_autorisees)) {

                compressImage($source, $destination.'/'.$file_name, $quality, $mime);

                // Chemin d'accès à l'image du produit
                $chemin_acces_img_produit = 'img/profile/'.$file_name;

                $reponse = $bdd->prepare('UPDATE membre SET profile_picture= :profile WHERE codehash=:codehash ');
                $reponse->execute(array(
                    'profile' => $chemin_acces_img_produit,
                    'codehash' => $code
                ));
            } else {
                $reponse = 'CE FICHIER N\'EST PAS UNE IMAGE.';
                header("location: ".$page."?aff_reponse_fausse=" . $reponse);
                exit();
            }
        } else {
            $reponse = 'IMAGE TROP LOURDE.';
            header("location:  ".$page."?aff_reponse_fausse=" . $reponse);
            exit();
        }
    } else {
        $reponse = 'ERREUR DE CHARGEMENT DE L\'IMAGE.';
        header("location:  ".$page."?aff_reponse_fausse=" . $reponse);
        exit();
    }
}
?>
