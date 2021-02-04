<?php


namespace app\entitiesDao;

use app\entitiesTools\ArrayCollection;
use app\entitieswebImmo\photoBien;

class PhotoRepository extends Repository
{
    public function findNomPhoto($id)
    {
        $collection = null;
        $photoBien = new photoBien();
        $sql = "SELECT id_photo, nomPhoto, thumbnail FROM photobien WHERE bienImmobilier = $id";
        $st = $this->pdo->query($sql);
        $photoBien = $st->fetchAll(\PDO::FETCH_ASSOC);
        $st->closeCursor();
        if(isset($photoBien)) {
            for($i = 0; $i < count($photoBien);$i++){
                $array[$i] = $photoBien[$i]["nomPhoto"];
            }
            return $array;
        }
        else{
            return "default";
        }
    }
}