<?php


namespace app\entitiesDao;

use app\entitieswebImmo\Personne;
use app\entitiesTools\ArrayCollection;

class PersonneDao extends Dao
{
    public function insert(?Object $obj):void
    {
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof Personne))
            throw new \Exception("Votre objet doit être de type personne");

        if($obj->getIdPersonne() != 0)
            throw new \Exception("L'objet a déjà été enregistré");


        $sql = "INSERT INTO personne ( nom, prenom, mail, telephone, proprietaire, nRue, rue, codePostal, ville)
                VALUES ( :nom,:prenom,:mail,:telephone,:proprietaire, :nRue, :rue, :codePostal, :ville)";

        $st = $this->pdo->prepare($sql);


        $st->bindValue("nRue", $obj->getnRue(), \PDO::PARAM_STR);
        $st->bindValue("rue", $obj->getRue(), \PDO::PARAM_STR);
        $st->bindValue("codePostal", $obj->getCodePostal(), \PDO::PARAM_STR);
        $st->bindValue("ville", strtolower($obj->getVille()), \PDO::PARAM_STR);
        //$st->bindValue("adresse", $obj->getAdresse(), \PDO::PARAM_STR);
        $st->bindValue("nom", strtoupper($obj->getnom()), \PDO::PARAM_STR);
        $st->bindValue("prenom", strtolower($obj->getprenom()), \PDO::PARAM_STR);
        $st->bindValue("mail", strtolower($obj->getmail()), \PDO::PARAM_STR);
        $st->bindValue("telephone", $obj->gettelephone(), \PDO::PARAM_STR);
        $st->bindValue("proprietaire",$obj->getProprietaire(), \PDO::PARAM_INT);

        $st->execute();
        $obj->setIdPersonne((int)$this->pdo->lastInsertId());
    }

    public function update(Object $obj):void{
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof Personne))
            throw new \Exception("Votre objet doit être de type Personne");

        if($obj->getIdPersonne() == 0)
            throw new \Exception("L'objet n'a pas encore été enregistré");

        $sql = "UPDATE Personne
        SET (null,nom =:nom, prenom = :prenom, mail = :mail,telephone =:telephone, proprietaire =:proprietaire, nRue=:nRue, rue=:rue, ville=:ville, codePostal =:codePostal)
        WHERE id_personne=:id_personne";

        $st = $this->pdo->prepare($sql);
        $st->bindValue("nRue", $obj->getnRue(), \PDO::PARAM_STR);
        $st->bindValue("Rue", $obj->getRue(), \PDO::PARAM_STR);
        $st->bindValue("codePostal", $obj->getCodePostal(), \PDO::PARAM_STR);
        $st->bindValue("ville", strtolower($obj->getVille()), \PDO::PARAM_STR);
        //$st->bindValue("adresse", $obj->getAdresse(), \PDO::PARAM_STR);
        $st->bindValue("nom", strtoupper($obj->getnom()), \PDO::PARAM_STR);
        $st->bindValue("prenom", strtolower($obj->getprenom()), \PDO::PARAM_STR);
        $st->bindValue("mail", strtolower($obj->getmail()), \PDO::PARAM_STR);
        $st->bindValue("telephone", $obj->gettelephone(), \PDO::PARAM_STR);
        $st->bindValue("proprietaire",$obj->getProprietaire(), \PDO::PARAM_INT);


        $st->execute();
    }

    public function delete(Object $obj):void{
        if(is_null($obj))
            throw new \Exception("Attention votre argument est nul");

        if(!($obj instanceof Personne))
            throw new \Exception("Votre objet doit être de type personne");

        if($obj->getIdPersonne() == 0)
            throw new \Exception("L'objet n'a pas encore été enregistré");

        $sql = "DELETE FROM personne WHERE id_personne = :id_personne";
        $st = $this->pdo->prepare($sql);
        $st->bindValue("id_personne", $obj->getId(), \PDO::PARAM_INT);
        $st->execute();

    }
    public function find(int $id):object{
        if($id <= 0)
            throw new Exception("L'id est invalide");

        $sql = "SELECT * FROM personne WHERE id_personne = $id";
        $st = $this->pdo->query($sql);
        $result = $st->fetch(\PDO::FETCH_ASSOC);
        //Après select on libère le curseur
        $st->closeCursor();
        if($result == false)
            throw new \Exception("La personne n'existe pas");
//        echo "<pre>";
//        var_dump($result);
//        echo "</pre>";
        //Attention PDO récupere que des String
        //Modifier ID en int, datenaissance en DateTime, confirmation en Booleen, Catégorie en Tableau
        $personne = new personne();
        $result2 = array();

        $arrayExclude = ["id_personne"];
        foreach($result as $key=>$value){
            if(!in_array($key,$arrayExclude))
                $result2[$key] = $value;
        }
        $personne->hydrate($result2);

        $personne->setIdPersonne((int)$result["id_personne"]);
        return $personne;
    }
    public function findAll():ArrayCollection{

    }
    public function count():int{
        $sql = "SELECT COUNT(id_personne) AS nb FROM id_personne";
        //Récupération d'un tableau associatif avec 1 seule cellule et index nb
        $st = $this->pdo->query($sql);
        $result = $st->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['nb'];
    }

}