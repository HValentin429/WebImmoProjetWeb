<?php
declare(strict_types=1);

namespace app\entitiesValidation;

use app\entitieswebImmo\BienImmobilier;

class BienValidation{
    private ?BienImmobilier $bienImmobilier = null;
    private array $tableauErreur = [];

    public function __construct(BienImmobilier $bienImmobilier){
        $this->bienImmobilier = $bienImmobilier;
    }


    public function validerBien():array{

        $regexText = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]/";
        $regexTextFull = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'()-]/";
        $regexNombreEntier = "/^[1234567890]/";
        $regexnRue = "([a-zA-Z0-9.,\/])";
        $regexNombreEntierPlus = "/^[1234567890 ,.]/";
        $regexNombreDecimal = "/^[1234567890,.]/";

        $nrue = $this->bienImmobilier->getNRue();
        $rue = $this->bienImmobilier->getRue();
        $codePostal = $this->bienImmobilier->getCodePostal();
        $ville = $this->bienImmobilier->getVille();
        $cuisine = $this->bienImmobilier->getCuisine();
        $chauffage = $this->bienImmobilier->getChauffage();
        $commentaire = $this->bienImmobilier->getCommentaire();
        $PEB =$this->bienImmobilier->getPEB();
        $parking =$this->bienImmobilier->getParking();
        $nbPieces = strval($this->bienImmobilier->getNbPieces());
        $prix = strval($this->bienImmobilier->getPrix());
        $proprietaire = strval($this->bienImmobilier->getProprietaire());
        $achatLocation = $this->bienImmobilier->getAchatLocation();
        $type = $this->bienImmobilier->getTypeBien();
        $surface = strval($this->bienImmobilier->getSurface());
        $controleElectrique = strval($this->bienImmobilier->isControleElectricite());

        if (isset($nrue) && strlen($nrue) == 0) {
            $tableauErreur["nrue"] = "Le numero de rue est vide";
        } else if (!preg_match($regexnRue, $nrue)) {
            $tableauErreur["nrue"] = "Le numero de rue est invalide";
        }

        if (isset($rue) && strlen($rue) == 0) {
            $tableauErreur["rue"] = "Le nom de la rue est vide";
        } else if (!preg_match($regexText, $rue)) {
            $tableauErreur["rue"] = "Le nom de la rue est invalide";
        }

        if (isset($codePostal) && strlen($codePostal) == 0) {
            $tableauErreur["codePostal"] = "Le code postal est vide";
        } else if (!preg_match($regexNombreEntier, $nrue)) {
            $tableauErreur["codePostalcodePostal"] = "Le code Postal est invalide";
        }

        if (isset($ville) && strlen($ville) == 0) {
            $tableauErreur["ville"] = "Le nom de la ville est vide";
        } else if (!preg_match($regexText, $ville)) {
            $tableauErreur["ville"] = "Le nom de la ville  est invalide";
        }

        if (isset($chauffage) && strlen($chauffage) == 0) {
            $tableauErreur["chauffage"] = "Le chauffage est vide";
        } else if (!preg_match($regexText, $chauffage)) {
            $tableauErreur["chauffage"] = "Le chauffage est invalide";
        }


        if (isset($cuisine) && strlen($cuisine) == 0) {
            $tableauErreur["cuisine"] = "La cuisine est vide";
        } else if (!preg_match($regexText, $cuisine)) {
            $tableauErreur["cuisine"] = "La cuisine est invalide";
        }

        if (!preg_match($regexTextFull, $commentaire)) {
            $tableauErreur["cuisine"] = "La cuisine est invalide";
        }

        if (isset($PEB) && strlen($PEB) == 0) {
            $tableauErreur["PEB"] = "Le PEB est vide";
        } else if (!preg_match($regexText, $PEB)) {
            $tableauErreur["PEB"] = "Le PEB est invalide";
        }

        if (isset($parking) && strlen($parking) == 0) {
            $tableauErreur["parking"] = "Le parking est vide";
        } else if (!preg_match($regexText, $parking)) {
            $tableauErreur["parking"] = "Le parking est invalide";
        }


        if (isset($nbPieces) && strlen($nbPieces) == 0) {
            $tableauErreur["nbPieces"] = "Le nombre Pieces est vide";
        } else if (!preg_match($regexNombreEntier, $nbPieces)) {
            $tableauErreur["nbPieces"] = "Le nombre Pieces est invalide";
        }

        if (isset($prix) && strlen($prix) == 0) {
            $tableauErreur["prix"] = "Le prix est vide";
        } else if (!preg_match($regexNombreEntierPlus, $prix)) {
            $tableauErreur["prix"] = "Le prix est invalide";
        }

        if (isset($surface) && strlen($surface) == 0) {
            $tableauErreur["surface"] = "la surface est vide";
        } else if (!preg_match($regexNombreDecimal, $surface)) {
            $tableauErreur["surface"] = "La surface est invalide";
        }


        if (isset($type) && strlen($type) == 0) {
            $tableauErreur["type"] = "erreur sur le type de bien";
        } else if (!preg_match($regexText, $type)) {
            $tableauErreur["type"] = "La  type de bien est invalide";
        }

        if (isset($achatLocation) && strlen($achatLocation) == 0) {
            $tableauErreur["achatLocation"] = "erreur sur le type de la vente";
        } else if (!preg_match($regexText, $achatLocation)) {
            $tableauErreur["achatLocation"] = "La achat Location est invalide";
        }

        if (isset($proprietaire) && strlen($proprietaire) == 0) {
            $tableauErreur["proprietaire"] = "erreur sur le proprietaire";
        } else if (!preg_match($regexNombreEntier, $proprietaire)) {
            $tableauErreur["proprietaire"] = "Le proprietaire est invalide";
        }

        if (isset($controleElectrique) && strlen($controleElectrique) == 0) {
            $tableauErreur["controleElectricite"] = "erreur sur le controleElectricite";
        } else if (!preg_match($regexNombreEntier, $controleElectrique)) {
            $tableauErreur["controleElectricite"] = "Le controleElectricite est invalide";
        }





        return $this->tableauErreur;
    }
}