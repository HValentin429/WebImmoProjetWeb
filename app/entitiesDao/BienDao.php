<?php
declare(strict_types=1);
namespace app\entitiesDao;

use app\entitieswebImmo\BienImmobilier;
use app\entitiesTools\ArrayCollection;

class BienDao extends Dao
{
    public function insert(?Object $obj):void
    {
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof BienImmobilier))
            throw new \Exception("Votre objet doit être de type bienImmopbilier");

        if($obj->getIdBienImmobilier() != 0)
            throw new \Exception("L'objet a déjà été enregistré");


        $sql = "INSERT INTO bienImmobilier (prix,chauffage,surface,commentaire,PEB,cuisine,controleElectricite,nbPieces,parking,typeBien,proprietaire, achatLocation, nRue, rue, codePostal, ville)
                VALUES (:prix, :chauffage,:surface,:commentaire,:PEB,:cuisine,:controleElectricite,:nbPieces ,:parking,:typeBien,:proprietaire, :achatLocation, :nRue, :rue, :codePostal, :ville)";

        $st = $this->pdo->prepare($sql);



        $st->bindValue("prix", $obj->getPrix(), \PDO::PARAM_INT);
        $st->bindValue("nRue", $obj->getnRue(), \PDO::PARAM_STR);
        $st->bindValue("rue", strtolower($obj->getRue()), \PDO::PARAM_STR);
        $st->bindValue("codePostal", $obj->getCodePostal(), \PDO::PARAM_STR);
        $st->bindValue("ville", strtolower($obj->getVille()), \PDO::PARAM_STR);
        $st->bindValue("surface", strval($obj->getSurface()), \PDO::PARAM_STR);
        $st->bindValue("chauffage", $obj->getChauffage(), \PDO::PARAM_STR);
        $st->bindValue("commentaire", $obj->getCommentaire(), \PDO::PARAM_STR);
        $st->bindValue("PEB", $obj->getPEB(), \PDO::PARAM_STR);
        $st->bindValue("cuisine", $obj->getCuisine(), \PDO::PARAM_STR);
        $st->bindValue("controleElectricite", $obj->isControleElectricite(), \PDO::PARAM_INT);
        $st->bindValue("nbPieces", $obj->getNbPieces(), \PDO::PARAM_INT);
        $st->bindValue("parking", $obj->getParking(), \PDO::PARAM_STR);
        $st->bindValue("typeBien", $obj->getTypeBien(), \PDO::PARAM_STR);
        $st->bindValue("achatLocation", $obj->getAchatLocation(), \PDO::PARAM_STR);
        $st->bindValue("proprietaire", $obj->getProprietaire(), \PDO::PARAM_INT);
        $st->bindValue("visible", $obj->getVisible(), \PDO::PARAM_INT);
        $st->bindValue("estimation", $obj->getEstimation(), \PDO::PARAM_INT);

        $st->execute();
        $obj->setIdBienImmobilier((int)$this->pdo->lastInsertId());

    }


    public function update(Object $obj):void{
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof BienImmobilier))
            throw new \Exception("Votre objet doit être de type bienImmopbilier");

        if($obj->getIdBienImmobilier() == 0)
            throw new \Exception("L'objet n'a pas encore été enregistré");


        $sql = "UPDATE bienImmobilier
                SET prix=:prix,chauffage =:chauffage,surface =:surface,commentaire = :commentaire, PEB = :PEB, cuisine = :cuisine, controleElectricite = :controleElectricite, nbPieces = :nbPieces , parking =:parking, typeBien =:typeBien,achatLocation = :achatLocation, proprietaire =:proprietaire, nRue=:nRue, rue=:rue,codePostal=:codePostal,ville=:ville
                WHERE id_BienImmobilier=:id_bienImmobilier";
        $st = $this->pdo->prepare($sql);
        $st->bindValue("id_bienImmobilier",$obj->getIdBienImmobilier(),\PDO::PARAM_INT);
        $st->bindValue("prix", $obj->getPrix(), \PDO::PARAM_INT);
        $st->bindValue("nRue", $obj->getnRue(), \PDO::PARAM_STR);
        $st->bindValue("rue", strtolower($obj->getRue()), \PDO::PARAM_STR);
        $st->bindValue("codePostal", $obj->getCodePostal(), \PDO::PARAM_STR);
        $st->bindValue("ville", strtolower($obj->getVille()), \PDO::PARAM_STR);
        $st->bindValue("surface", strval($obj->getSurface()), \PDO::PARAM_STR);
        $st->bindValue("chauffage", $obj->getChauffage(), \PDO::PARAM_STR);
        $st->bindValue("commentaire", $obj->getCommentaire(), \PDO::PARAM_STR);
        $st->bindValue("PEB", $obj->getPEB(), \PDO::PARAM_STR);
        $st->bindValue("cuisine", $obj->getCuisine(), \PDO::PARAM_STR);
        $st->bindValue("controleElectricite", $obj->isControleElectricite(), \PDO::PARAM_INT);
        $st->bindValue("nbPieces", $obj->getNbPieces(), \PDO::PARAM_INT);
        $st->bindValue("parking", $obj->getParking(), \PDO::PARAM_STR);
        $st->bindValue("typeBien", $obj->getTypeBien(), \PDO::PARAM_STR);
        $st->bindValue("achatLocation", $obj->getAchatLocation(), \PDO::PARAM_STR);
        $st->bindValue("proprietaire", $obj->getProprietaire(), \PDO::PARAM_INT);
        $st->bindValue("visible", $obj->getVisible(), \PDO::PARAM_INT);
        $st->bindValue("estimation", $obj->getEstimation(), \PDO::PARAM_INT);

        $st->execute();
    }
    public function delete(Object $obj):void{
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof BienImmobilier))
            throw new \Exception("Votre objet doit être de type bienImmopbilier");

        if($obj->getIdBienImmobilier() == 0)
            throw new \Exception("L'objet n'a pas encore été enregistré");

        $sql = "DELETE FROM bienImmobilier WHERE id_bienImmobilier = :id_bienImmobilier";
        $st = $this->pdo->prepare($sql);
        $st->bindValue("id_bienImmobilier", $obj->getIdBienImmobilier(), \PDO::PARAM_INT);
        $st->execute();

    }
    public function find(int $id):object{
        if($id <= 0)
            throw new Exception("L'id est invalide");

        $sql = "SELECT * FROM bienImmobilier WHERE id_bienImmobilier = $id";
        $st = $this->pdo->query($sql);
        $result = $st->fetch(\PDO::FETCH_ASSOC);
        //Après select on libère le curseur
        $st->closeCursor();
        if($result == false)
            throw new \Exception("Le bien n'existe pas");
//        echo "<pre>";
//        var_dump($result);
//        echo "</pre>";
        //Attention PDO récupere que des String
        //Modifier ID en int, datenaissance en DateTime, confirmation en Booleen, Catégorie en Tableau
        $bienImmobilier = new BienImmobilier();
        $result2 = array();

        $arrayExclude = ["id_bienImmobilier", "proprietaire"];
        foreach($result as $key=>$value){
            if(!in_array($key,$arrayExclude))
                $result2[$key] = $value;
        }
        $result2["surface"] = floatval($result2["surface"]) ; //transformation en float du string retourne par pdo
        $result2["controleElectricite"] = intval($result2["controleElectricite"]);
        $result2["nbPieces"] = intval($result2["nbPieces"]);

        $bienImmobilier->hydrate($result2);

        $bienImmobilier->setIdBienImmobilier((int)$result["id_bienImmobilier"]);
        return $bienImmobilier;
    }
    public function findAll():ArrayCollection{

    }
    public function count():int{
        $sql = "SELECT COUNT(id_bienImmobilier) AS nb FROM bienImmobilier";
        //Récupération d'un tableau associatif avec 1 seule cellule et index nb
        $st = $this->pdo->query($sql);
        $result = $st->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['nb'];
    }

}
