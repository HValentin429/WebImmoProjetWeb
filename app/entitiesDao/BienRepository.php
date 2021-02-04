<?php


namespace app\entitiesDao;
use app\entitieswebImmo\BienImmobilier;
use app\entitiesTools\ArrayCollection;

class BienRepository extends Repository
{

    public function findWithCursor(int $cursor , int  $group, string $type,String $typeListing, string $codePostal ){
        if($cursor < 0 || $group < 0)
            throw new \Exception("Arguments invalides");

        $collection = null;
        $sql=  "SELECT id_bienImmobilier, chauffage,surface,commentaire,PEB,cuisine,controleElectricite,nbPieces,parking,typeBien,proprietaire, achatLocation, nRue, rue, codePostal,ville,nomPhoto,prix 
        FROM bienImmobilier
        LEFT JOIN photobien
        ON bienImmobilier.id_bienImmobilier = photobien.bienImmobilier
        WHERE achatLocation LIKE '%$typeListing%' AND codePostal LIKE '%$codePostal%' AND typeBien LIKE '%$type%' AND thumbnail = 1 LIMIT $cursor, $group";

        $st = $this->pdo->query($sql);
        $result = $st->fetchAll(\PDO::FETCH_ASSOC);

        $st->closeCursor();
        if(!$result)
            throw new \Exception("Pas d'enregistrements dans la table");

        $collection = Array();
        //$collection->setTypeClasse("app\\entitieswebImmo\\BienImmobilier");

        //$arrayExclude = ["id_bienImmobilier"];
        for($i = 0; $i < count($result); $i++){
            //$bienImmobilier = new bienImmobilier();
            $result2 = array();
            foreach($result[$i] as $key=>$value){
                //if(!in_array($key, $arrayExclude))
                $result2[$key] = $value;
            }
            $result2["surface"] = floatval($result[$i]["surface"]) ; //transformation en float du string retourne par pdo
            $result2["controleElectricite"] = intval($result[$i]["controleElectricite"]);
            $result2["nbPieces"] = intval($result[$i]["nbPieces"]);
            $result2["proprietaire"] = intval($result[$i]["proprietaire"]);
            $result2["prix"] = intval($result[$i]["prix"]);
            //$bienImmobilier->hydrate($result2);
            $result2["id_BienImmobilier"]= intval($result[$i]["id_bienImmobilier"]);

            array_push($collection,$result2);
        }

        return $collection;

    }

    public function delete(int $id): void
    {
        if ($id == 0)
            throw new \Exception("L'objet n'a pas été enregistré");

        //Verifier que l'ID existe avec find

        $sql = "DELETE FROM bienImmobilier WHERE id = " . $id;
        $this->pdo->exec($sql);
    }


    public function compteMaxPagesRecherche(string $type,String $typeListing, string $codePostal) : int{
        $sql= "SELECT COUNT(id_bienImmobilier) AS compteEntrees FROM bienImmobilier
        LEFT JOIN photobien
        ON bienImmobilier.id_bienImmobilier = photobien.bienImmobilier
        WHERE achatLocation LIKE '%$typeListing%' AND codePostal LIKE '%$codePostal%' AND typeBien LIKE '%$type%' AND thumbnail = 1";
        $st = $this->pdo->query($sql);
        $result = $st->fetchAll(\PDO::FETCH_ASSOC);

        return $result[0]["compteEntrees"];
    }

    public function findWithid(int $id){
        if($id == 0) {
            throw new \Exception("Arguments invalides");
        }
        $collection = null;
        $sql=  "SELECT id_bienImmobilier, chauffage,surface,commentaire,PEB,cuisine,controleElectricite,nbPieces,parking,typeBien,proprietaire, achatLocation, nRue, rue, codePostal,ville,prix 
        FROM bienImmobilier
        WHERE id_bienImmobilier = $id";

        $st = $this->pdo->query($sql);
        $result = $st->fetchAll(\PDO::FETCH_ASSOC);

        $st->closeCursor();
        if(!$result)
            throw new \Exception("Pas d'enregistrements dans la table");

        $collection = Array();
        //$collection->setTypeClasse("app\\entitieswebImmo\\BienImmobilier");

        //$arrayExclude = ["id_bienImmobilier"];
        /*
        $result["surface"] = floatval($result["surface"]) ; //transformation en float du string retourne par pdo
        $result["controleElectricite"] = intval($result["controleElectricite"]);
        $result["nbPieces"] = intval($result["nbPieces"]);
        $result["proprietaire"] = intval($result["proprietaire"]);
        $result["prix"] = intval($result["prix"]);
        $result["id_BienImmobilier"]= intval($result["id_bienImmobilier"]);
        */

        return $result[0];

    }

}


