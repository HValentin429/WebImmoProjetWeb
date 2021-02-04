<?php
declare(strict_types=1);

namespace webImmo\serveur;
require_once "../vendor/autoload.php";
require_once "parametres.php";

use app\entitieswebImmo\BienImmobilier;

$cursor = intval($_GET["cursor"]) ;
$group = intval($_GET["group"]);

if(!isset($_GET["typeListing"])){
    $typeListing = '';
} else{
    $typeListing = $_GET["typeListing"];
}

if(!isset($_GET["type"])){
    $type = '';
} else{
    $type = $_GET["type"];
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
    $photoRepository = new \app\entitiesDao\photoRepository($pdo);
    $array = $bienRepository->findWithCursor($cursor,$group,$type,$typeListing, $codePostal);

    /*for($i = 0 ; $i < count($encode);$i++){
        $array = $encode[$i];
        $id = $array -> getIdBienImmobilier();
        $id2 = $photoRepository->findNomPhoto($id);


    }*/

    $encode = json_encode($array);

    echo $encode;

}catch(\PDOException $e){
    echo $e->getMessage();
    exit;
}catch(\Exception $e){
    echo $e->getMessage();
    exit;
}
