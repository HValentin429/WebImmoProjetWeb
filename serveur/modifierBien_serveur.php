<?php
declare(strict_types=1);
require_once "../vendor/autoload.php";
require_once "parametres.php";

use \app\entitieswebImmo\BienImmobilier;
use \app\entitieswebImmo\photoBien;


ini_set("upload_max_filesize", "0");
header('Content-type: text/html; charset=utf-8');

if(!(isset($_POST["origine"]) && $_POST["origine"] == "FormulaireBien")){
    echo "erreurorigine";
    exit;
}

//passage par json possible, à voir prochaine iteration

$bienImmobilier = new BienImmobilier();
//$bienImmobilier -> setAdresse($_POST["adresse"]);
$bienImmobilier -> setIdBienImmobilier(intval($_POST["id_bienImmobilier"]));
$bienImmobilier -> setPrix(intval($_POST["prix"]));
$bienImmobilier -> setNRue($_POST["nRue"]);
$bienImmobilier -> setRue($_POST["rue"]);
$bienImmobilier -> setCodePostal($_POST["codePostal"]);
$bienImmobilier -> setVille($_POST["ville"]);
$bienImmobilier -> setChauffage($_POST["chauffage"]);
$bienImmobilier -> setNbPieces(intval($_POST["nbPieces"]));
$bienImmobilier -> setSurface(floatval($_POST["surface"]));
$bienImmobilier -> setCommentaire($_POST["commentaire"]);
$bienImmobilier -> setPEB($_POST["PEB"]);
$bienImmobilier -> setCuisine($_POST["cuisine"]);
$bienImmobilier -> setTypeBien(strtoupper($_POST["typeBien"]));
$bienImmobilier -> setParking($_POST["parking"]);
$bienImmobilier -> setProprietaire(intval($_POST["proprietaire"]));
$bienImmobilier -> setAchatLocation(strtoupper($_POST["achatLocation"]));
$bienImmobilier -> setControleElectricite(intval($_POST["controleElectricite"]));


$validationBien = new app\entitiesValidation\BienValidation($bienImmobilier);

if(count($validationBien->validerBien()) > 0){
    echo "le bien n'est pas correct";
    exit();
}

else {
    try {
        \app\dao\MyPDO::parametres(DSN, USER, PSWD);
        $pdo = \app\dao\MyPDO::getInstancePDO();
        $bienDao = new \app\entitiesDao\BienDao($pdo);
        $bienDao->update($bienImmobilier);
        echo "Ajout BD ok";
    } catch (\PDOException $e) {
        echo $e->getMessage();
        exit;
    } catch (\Exception $e) {
        echo $e->getMessage();
        exit;
    }
}