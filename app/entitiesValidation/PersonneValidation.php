<?php


namespace app\entitiesValidation;
use app\entitieswebImmo\Personne;

class PersonneValidation
{
    private ?Personne $personne = null;
    private array $tableauErreur = [];

    public function __construct(personne $personne){
        $this->personne = $personne;
    }

    public function validerBien():array{

        $regexText = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]/";
        $regexNombreEntier = "/^[1234567890]/";
        $regexnRue = "([a-zA-Z0-9.,\/])";
        $regexEmail = "/^[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";
        $regexTelephone = "/^[0-9]{8,10}$/";

        $nrue = $this->personne->getNRue();
        $rue = $this->personne->getRue();
        $codePostal = $this->personne->getCodePostal();
        $ville = $this->personne->getVille();
        $nom = $this->personne->getNom();
        $prenom = $this->personne->getPrenom();
        $mail = $this->personne->getMail();
        $telephone = $this->personne->getTelephone();
        $proprietaire = $this->personne->getProprietaire();



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

        if (isset($nom) && strlen($nom) == 0) {
            $tableauErreur["nom"] = "Le nom est vide";
        } else if (!preg_match($regexText, $nom)) {
            $tableauErreur["nom"] = "Le nom est invalide";
        }

        if (isset($prenom) && strlen($prenom) == 0) {
            $tableauErreur["prenom"] = "Le prenom est vide";
        } else if (!preg_match($regexText, $nom)) {
            $tableauErreur["prenom"] = "Le prenom est invalide";
        }

        if (isset($mail) && strlen($mail) == 0) {
            $tableauErreur["mail"] = "Lemail est vide";
        } else if (!preg_match($regexEmail, $mail)) {
            $tableauErreur["mail"] = "Le mail est invalide";
        }

        if (isset($telephone) && strlen($telephone) == 0) {
            $tableauErreur["telephone"] = "Le telephone est vide";
        } else if (!preg_match($regexTelephone, $telephone)) {
            $tableauErreur["telephone"] = "Le telephone est invalide";
        }

        if (isset($proprietaire) && strlen($proprietaire) == 0) {
            $tableauErreur["$proprietaire"] = "Le proprietaire est vide";
        } else if (!preg_match($regexNombreEntier, $proprietaire)) {
            $tableauErreur["$proprietaire"] = "Le proprietaire est invalide";
        }





        return $this->tableauErreur;
    }
}