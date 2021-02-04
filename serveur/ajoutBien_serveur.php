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
        $bienDao->insert($bienImmobilier);
        echo "Ajout BD ok";
    }catch(\PDOException $e){
        echo $e->getMessage();
        exit;
    }catch(\Exception $e){
        echo $e->getMessage();
        exit;
    }

    if($bienImmobilier->getIdBienImmobilier() > 0) {
        for ($i = 0; $i < count($_FILES["photoBien"]["name"]); $i++) {
            $photoBien = new photoBien();
            $imageFileType = strtolower(pathinfo($_FILES["photoBien"]["name"][$i], PATHINFO_EXTENSION));
            $photoBien->setBienImmobilier($bienImmobilier->getIdBienImmobilier());
            $photoBien->setNomImage(strval($bienImmobilier->getIdBienImmobilier()) . "_" . $i . "." . $imageFileType);
            if ($i == 0) {
                $photoBien->setThumbnail("1");
            } else {
                $photoBien->setThumbnail("0");
            }

            $validationPhoto = new app\entitiesValidation\photoBienValidation($photoBien);
            if ($validationPhoto->validerPhoto($i) <= 0) {
                echo "photo incorrecte";
                exit();
            } else {
                try {
                    $photoDao = new \app\entitiesDao\photoDao($pdo);
                    $photoDao->insert($photoBien);
                    echo "Ajout BD ok";
                } catch (\PDOException $e) {
                    echo $e->getMessage();
                    exit;
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    exit;
                }
            }
        }
    } else{
        echo "pas d'id, erreur sur l'ajout du bien";
    }
}
