<?php
declare(strict_types=1);
namespace app\entitiesDao;

use app\entitiesTools\ArrayCollection;

abstract class Dao {

    protected $pdo = null;
    public function __construct(Object $pdo){
        $this->pdo = $pdo;
    }

    // les méthodes à redéfinir
    public abstract function insert(Object $obj):void; // objet par référence
    public abstract function update(Object $obj):void; // void
    public abstract function delete(Object $obj):void; // void
    public abstract function find(int $id):Object; // retourne un objet
    public abstract function findAll():ArrayCollection; // retourne une ArrayCollection d'objets
    public abstract function count():int; // retourne un integer

}