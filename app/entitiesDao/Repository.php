<?php
declare(strict_types=1);
namespace app\entitiesDao;

use app\entities\Client;
use app\entitiesTools\ArrayCollection;

abstract class Repository {
    //Opération DB autre que CRUD
    //Exemples : récupération de record avec instruction limit
    //Pagination ex google on affiche 10aine résultat sur la page, pas tout
    protected $pdo = null;
    public function __construct(Object $pdo){
        $this->pdo = $pdo;
    }
}