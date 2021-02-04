<?php

namespace app\entitiesDao;

use app\entitieswebImmo\Personne;
use app\entitiesTools\ArrayCollection;

class PersonneRepository extends Repository
{
    public function findWithCursor(int $cursor, int $group)
    {
        if ($cursor < 0 || $group < 0)
            throw new \Exception("Arguments invalides");

        $collection = null;
        $sql = "SELECT * FROM personne LIMIT $cursor, $group";
        $st = $this->pdo->query($sql);
        $result = $st->fetchAll(\PDO::FETCH_ASSOC);

        $st->closeCursor();
        if (!$result)
            throw new \Exception("Pas d'enregistrements dans la table");

        $collection = new ArrayCollection();
        $collection->setTypeClasse("app\\entitieswebImmo\\Personne");

        $arrayExclude = ["id_personne"];
        for ($i = 0; $i < count($result); $i++) {
            $personne = new personne();
            $result2 = array();
            foreach ($result[$i] as $key => $value) {
                if (!in_array($key, $arrayExclude))
                    $result2[$key] = $value;
            }
            $result2["proprietaire"] = intval($result2["proprietaire"]);

            $personne->hydrate($result2);
            $personne->setIdPersonne((int)$result[$i]["id_personne"]);


            $collection->addObj($personne);
        }
        return $collection;

    }

    public function findAllProprietaire()
    {
        $collection = null;
        $sql = "SELECT * FROM personne WHERE proprietaire = 1";
        $st = $this->pdo->query($sql);
        $result = $st->fetchAll(\PDO::FETCH_ASSOC);

        $st->closeCursor();
        if (!$result)
            throw new \Exception("Pas d'enregistrements dans la table");

        $collection = new ArrayCollection();
        $collection->setTypeClasse("app\\entitieswebImmo\\Personne");

        $arrayExclude = ["id_personne"];
        for ($i = 0; $i < count($result); $i++) {
            $personne = new personne();
            $result2 = array();
            foreach ($result[$i] as $key => $value) {
                if (!in_array($key, $arrayExclude))
                    $result2[$key] = $value;
            }
            $result2["proprietaire"] = intval($result2["proprietaire"]);

            $personne->hydrate($result2);
            $personne->setIdPersonne((int)$result[$i]["id_personne"]);

            $collection->addObj($personne);
        }
        return $collection;

    }

    public function delete(int $id): void
    {
        if ($id == 0)
            throw new \Exception("L'objet n'a pas été enregistré");

        //Verifier que l'ID existe avec find

        $sql = "DELETE FROM personne WHERE id = " . $id;
        $this->pdo->exec($sql);
    }

}
