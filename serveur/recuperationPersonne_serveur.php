<?php

declare(strict_types=1);

namespace webImmo\serveur;
require_once "../vendor/autoload.php";
require_once "parametres.php";

use app\entitieswebImmo\Personne;

$personne = new personne();

try {
    \app\dao\MyPDO::parametres(DSN, USER, PSWD);
    $pdo = \app\dao\MyPDO::getInstancePDO();
    $personneRepository = new \app\entitiesDao\personneRepository($pdo);
    $personneArray = $personneRepository->findAllProprietaire();
    $encode = $personneArray->getArray();

    $encode = json_encode($encode);

    echo $encode;

} catch (\PDOException $e) {
    echo $e->getMessage();
    exit;
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}
