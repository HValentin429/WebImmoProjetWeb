<?php
declare(strict_types=1);

namespace app\entitiesValidation;
use app\entitieswebImmo\photoBien;


class photoBienValidation
{
    private ?photoBien $photoBien = null;
    private array $tableauErreur = [];

    public function __construct(photoBien $photoBien)
    {
        $this->photoBien = $photoBien;
    }

    public function validerPhoto(int $nPhoto): int
    {


        $target_dir = "../ressources/uploads/";
        $target_file = $target_dir . basename($this->photoBien->getNomImage());
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["photoBien"]["tmp_name"][$nPhoto]);
            if ($check !== false) {
                echo "Le fichier est une image - " . $check["mime"][$nPhoto] . ".";
                $uploadOk = 1;
            } else {
                echo "Le fichier n'est pas une image";
                $uploadOk = 0;
            }
        }

// Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

// Check file size
        if ($_FILES["photoBien"]["size"][$nPhoto] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

// Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo " Seulement JPG, JPEG, PNG & GIF files sont autorisés";
            $uploadOk = 0;
        }

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Le fichier n'a pas plus être upload";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["photoBien"]["tmp_name"][$nPhoto], $target_dir . basename($this->photoBien->getNomImage()))) {
                echo "le fichier " . htmlspecialchars(basename($_FILES["photoBien"]["name"][$nPhoto])) . " a été upload";
            } else {
                echo "Une erreur est apparue";
                $uploadOk = 0;
            }
        }


        return $uploadOk;
    }
}