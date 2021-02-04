<?php
declare(strict_types=1);

namespace app\entitiesDao;
use app\entitieswebImmo\photoBien;
use app\entitiesTools\ArrayCollection;

class photoDao extends Dao
{
    public function insert(?Object $obj):void
    {
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof photoBien))
            throw new \Exception("Votre objet doit être de type bienImmopbilier");

        if($obj->getIdPhoto() != 0)
            throw new \Exception("L'objet a déjà été enregistré");

        $sql = "INSERT INTO photobien (bienImmobilier,nomPhoto, thumbnail)
                VALUES ( :bienImmobilier,:nomPhoto, :thumbnail)";



        $st = $this->pdo->prepare($sql);
        $st->bindValue("bienImmobilier", $obj->getBienImmobilier(), \PDO::PARAM_INT);
        $st->bindValue("nomPhoto", strtolower($obj->getNomImage()), \PDO::PARAM_STR);
        $st->bindValue("thumbnail", $obj->getThumbnail(), \PDO::PARAM_INT);

        $st->execute();
        $obj->setIdPhoto((int)$this->pdo->lastInsertId());
    }

    public function update(?Object $obj):void
    {
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof photoBien))
            throw new \Exception("Votre objet doit être de type bienImmopbilier");

        if($obj->getIdPhoto() != 0)
            throw new \Exception("L'objet a déjà été enregistré");

        $sql = "UPDATE photobien
                SET (null, bienImmobilier =:bienImmobilier, nomPhoto=:nomPhoto, thumbnail=:thumbnail)
                WHERE id_photo=:id_photo";



        $st = $this->pdo->prepare($sql);
        $st->bindValue("bienImmobilier", $obj->getBienImmobilier(), \PDO::PARAM_INT);
        $st->bindValue("nomPhoto", strtolower($obj->getNomImage()), \PDO::PARAM_STR);
        $st->bindValue("thumbnail", $obj->getThumbnail(), \PDO::PARAM_INT);

        $st->execute();
    }


    public function delete(Object $obj):void{
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof photoBien))
            throw new \Exception("Votre objet doit être de type photoBien");

        if($obj->getIdPhoto() == 0)
            throw new \Exception("L'objet n'a pas encore été enregistré");

        $sql = "DELETE FROM photoBien WHERE id_photo = :id_photo";
        $st = $this->pdo->prepare($sql);
        $st->bindValue("id_photo", $obj->getIdPhoto(), \PDO::PARAM_INT);
        $st->execute();

    }

    public function find(int $id):object{
        if($id <= 0)
            throw new Exception("L'id est invalide");

        $sql = "SELECT * FROM photoBien WHERE id_photo = $id";
        $st = $this->pdo->query($sql);
        $result = $st->fetch(\PDO::FETCH_ASSOC);
        //Après select on libère le curseur
        $st->closeCursor();
        if($result == false)
            throw new \Exception("La photo n'existe pas");
//        echo "<pre>";
//        var_dump($result);
//        echo "</pre>";
        //Attention PDO récupere que des String
        //Modifier ID en int, datenaissance en DateTime, confirmation en Booleen, Catégorie en Tableau
        $photoBien = new photoBien();
        $result2 = array();

        $arrayExclude = ["id_photoBien"];
        foreach($result as $key=>$value){
            if(!in_array($key,$arrayExclude))
                $result2[$key] = $value;
        }
        $result2["photoBien"] = intval($result2["photoBien"]);

        $photoBien->hydrate($result2);

        $photoBien->setIdPhoto((int)$result["id_photoBien"]);
        return $photoBien;
    }

    public function findAll():ArrayCollection{

    }
    public function count():int{
        $sql = "SELECT COUNT(id_photo) AS nb FROM photobien";
        //Récupération d'un tableau associatif avec 1 seule cellule et index nb
        $st = $this->pdo->query($sql);
        $result = $st->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['nb'];
    }
}