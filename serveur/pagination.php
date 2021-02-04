<?php
declare(strict_types=1);
require_once "../vendor/autoload.php";
require_once "parametres.php";


if(!isset($_GET["type"])){
    $type = '';
} else{
    $type = $_GET["type"];
}

if(!isset($_GET["typeListing"])){
    $typeListing = '';
} else{
    $typeListing = $_GET["typeListing"];
}

if(!isset($_GET["codePostal"])){
    $codePostal = '';
} else{
    $codePostal = $_GET["codePostal"];
}


try {
    \app\dao\MyPDO::parametres(DSN, USER, PSWD);
    $pdo = \app\dao\MyPDO::getInstancePDO();
    $bienRepository = new \app\entitiesDao\BienRepository($pdo);
    $maxPages = $bienRepository->compteMaxPagesRecherche($type,$typeListing, $codePostal);

    echo $maxPages;

}catch(\PDOException $e){
    echo $e->getMessage();
    exit;
}catch(\Exception $e){
    echo $e->getMessage();
    exit;
}
