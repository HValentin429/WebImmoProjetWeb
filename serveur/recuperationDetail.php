<?php
declare(strict_types=1);

namespace webImmo\serveur;
require_once "../vendor/autoload.php";
require_once "parametres.php";

use app\entitieswebImmo\BienImmobilier;

$id_bienImmobilier = intval($_GET["id"]) ;


try {
    \app\dao\MyPDO::parametres(DSN, USER, PSWD);
    $pdo = \app\dao\MyPDO::getInstancePDO();
    $bienRepository = new \app\entitiesDao\BienRepository($pdo);
    $array = $bienRepository->findWithId($id_bienImmobilier);
    $encode = json_encode($array);

    echo $encode;

}catch(\PDOException $e){
    echo $e->getMessage();
    exit;
}catch(\Exception $e){
    echo $e->getMessage();
    exit;
}
