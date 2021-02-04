<?php
declare(strict_types=1);
require_once "../vendor/autoload.php";
require_once "parametres.php";

use \app\entitieswebImmo\Personne;


ini_set("upload_max_filesize", "0");
header('Content-type: text/html; charset=utf-8');

if(!(isset($_POST["origine"]) && $_POST["origine"] == "FormulairePersonne")){
    echo "erreurorigine";
    exit;
}


$personne = new personne();
//$personne -> setAdresse($_POST["adresse"]);

$personne -> setNRue($_POST["nRue"]);
$personne -> setRue($_POST["rue"]);
$personne -> setCodePostal($_POST["codePostal"]);
$personne -> setVille($_POST["ville"]);
$personne -> setNom($_POST["nom"]);
$personne -> setPrenom($_POST["prenom"]);
$personne -> setProprietaire(intval($_POST["proprietaire"]));
$personne -> setMail($_POST["mail"]);
$personne -> setTelephone($_POST["telephone"]);




$validationPersonne = new app\entitiesValidation\PersonneValidation($personne);

if(count($validationPersonne->validerBien()) > 0){
    echo "le bien n'est pas correct";
}

else {
    try {
        \app\dao\MyPDO::parametres(DSN, USER, PSWD);
        $pdo = \app\dao\MyPDO::getInstancePDO();
        $PersonneDao = new \app\entitiesDao\PersonneDao($pdo);
        $PersonneDao->insert($personne);
        echo "Ajout BD ok";
    }catch(\PDOException $e){
        echo $e->getMessage();
        exit;
    }catch(\Exception $e){
        echo $e->getMessage();
        exit;
    }

}