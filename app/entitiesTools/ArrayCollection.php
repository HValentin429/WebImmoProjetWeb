<?php
declare(strict_types = 1);
namespace app\entitiesTools;
/*
toujours définir le namespace avant require ou require_once
*/
require_once("IArrayCollection.php");


// require_once("IArrayCollection.php");
// classe départ pour la gestion d'une pseudo-Collection à la manière d'une ArrayList en java
/*
 * implémente Iterator pour utiliser l'itération avec foreach
 * implémente Countable pour redéfinir la méthode count
 * impléments IArrayCollection pour nos méthodes utilitaires
 */
/*
 * extends pour l'héritage et implements pour les interfaces
 * si l'interface fait partie du même namespace que celui de la classe,
 * ne rien mettre devant le nom de l'interface
 * si l'interface fait partie du namespace global mettre un backslash
 */
class ArrayCollection implements IArrayCollection, \Countable, \Iterator  {
	
	// Countable permet de garantir qu'il existe une méthode count
	// Iterator permet l'itération de l'attribut interne de la classe
	// donc de pouvoir faire un foreach directement sur un objet ArrayCollection

    // les attributs
    private ?array $array = null; // array
    // tableau avec index numérique
    // le tableau contient le même type d'objets
    // le tableau ne peut pas comporter de doublons
    /*
     * la généricité n'existe pas en php
     * pour éviter de mélanger des objets de spécificité différente
     * on doit vérifier le nom de la classe utilisée
     */
    private ?string $typeClasse = null;

    private int $position = 0; // pour l'itérateur afin de faire un foreach directement sur l'objet

    // le constructeur
    public function __construct(?string $typeClasse = null)
    {
        $this->array = array(); // tableau vide
        // assignation de la variable private tableau vide
        $this->typeClasse = $typeClasse;
    }

    // retourne l'attribut array de la classe
    // getter
    public function getArray():array
    {
        return $this->array;
    }

    // assigne l'attribut array avec un tableau
    // setter
    // éviter d'utiliser un setter pour le tableau
    // existe des méthodes d'ajout avec vérification du type
    public function setArray(array $array):void
    {
        $this->array = $array;
    }


// getter and setter pour l'attribut $typeClasse
    public function getTypeClasse():?string{
        return $this->typeClasse;
    }
    public function setTypeClasse(string $typeClasse):void{
        $this->typeClasse = $typeClasse;
    }


    /*
     * php7 strict_types à 1
     * les méthodes lanceront une exception si problème
     * utiliser des try catch finally
     * à gérer au niveau des interfaces lors de l'utilisation des objets
     */


    // *******************************************************************
    // ajouter un élément dans l'attribut array
    public function addObj(?object $obj):void
    {
        if ($obj == null)
            throw new \Exception("objet null");
        if ( $this->typeClasse == null )
            throw new \Exception("typeClasse obligatoire");
        if (get_class($obj) != $this->typeClasse)
            throw new \Exception("type objet non respecté");
        if ($this->contains($obj))
            throw new \Exception("objet déjà présent");
        $this->array[] = $obj;
    }

    // ajouter un tableau (le 1er if pourra être supprimé avec php7 et le typage strict
    public function addArrayObj(array $array):void
    {
            foreach ($array as $val) {
                if (!$this->contains($val)) {
                    $this->addObj($val);
                }
            }
    }
    // ou autre solution en utilisant array_merge
    // array_merge fusionne des tableaux attention si index alphanumérique on tient compte du dernier index
    // possibilité d'avoir des doublons car array_merge ne vérifie que les index et non les valeurs
    public function addMergeObj(array $array):void    {
             $this->array = array_merge($this->array, $array);
    }

    // on lui passe un objet de type ArrayCollection
    public function addCollObj(object $obj):void
    {
        // $obj doit être une instance de ArrayCollection, utiliser instanceof
        if ($obj instanceof ArrayCollection) {
            //$this->array = array_merge($this->array, $obj->getArray());
            $this->addArrayObj($obj->getArray());
            //$this->addMergeObj($obj->getArray());
        }
        else
            throw new \Exception("type objet non respecté");
    }

    // supprime un élément
    public function remove(object $obj):void
    {
        if ($obj == null)
            throw new \Exception("objet null");
        if (get_class($obj) != $this->typeClasse)
            throw new \Exception("type objet non respecté");
        else {
            foreach ($this->array as $key => $val) {
                if ($val === $obj) {
                    //vérifier si les 2 valeurs sont identiques
                    unset ($this->array[$key]); // delete
                    $this->array = array_values($this->array);
                    // attention : réaffectation des index sinon problème ...
                }
            }
        }
    }

    // vider le tableau en le réassignant
    public function clear():void
    {
        $this->array = array();
        // réassigner l'attribut par un tableau vide
    }

    // vérifie si un élément se trouve dans le tableau et retourne true si oui
    public function contains(object $obj):bool
    {
        if ($obj == null)
            throw new \Exception("objet null");
        if (get_class($obj) != $this->typeClasse)
            throw new \Exception("type objet non respecté");

        foreach ($this->array as $val) {
            if ($val === $obj)
                return true;
        }
        return false;
    }

    // vérifie si le tableau est vide
    // utiliser l'interface Countable
    public function isEmpty():bool
    {
        if ($this->count() == 0)
            return true;
        else
            return false;
    }

    // méthode pour trier
    // sort permet de trier des tableaux contenant des nombres ou des chaînes de caractères
    // utiliser usort avec une fonction de comparaison
    public function sort():void
    {
        if ($this->count() > 0) {
            // récupérer le nom de la classe
            $nameClass = get_class($this->getArray()[0]);
            usort($this->array, array($nameClass, "fctCompare"));
            /*
             * la classe utilisée doit comporter une méthode static pour gérer la comparaison
             */
        }
    }


    // conversion array en json sans échappement unicode
    public function convertJson():string {
        if ( $this->count() == 0 )
            throw  new \Exception("pas de valeurs dans l'ArrayCollection");
        return json_encode($this->array,JSON_UNESCAPED_UNICODE);
    }


    // ********************************************
    // méthode à redéfinir grâce à Countable
    // retourne le nombre d'éléments dans le tableau
    public function count()
    {
    return count($this->array);
    }

    // afficher le contenu de la collection
    public function listCollection():string
    {
        $contenu = "";
        // vérifier si la classe contient la méthode __toString
        foreach ($this->array as $val) {
            $contenu .= $val . "\n";
        }
        return $contenu;
    }


    // cloner l'objet
    // sera appelée quand on va cloner l'objet avec clone
    //Le mot-clé clone se contente simplement de copier bit à bit toutes les valeurs de l’objet source vers
    //l’objet destination
    public function __clone()
    {
        $obj = new ArrayCollection();
        $obj->addArrayObj($this->getArray());
        return $obj;
    }

    // redéfinition de la méthode __toString
    // on retourne le tableau en brut ...
    /*
     public function __toString(){
            return "<pre>". var_dump($this->getArray()) . "</pre>";
        }
    */

    public function __toString():string
    {
        return $this->listCollection();
    }


    // ************************************************
    // utilisation de l'interface Iterator pour parcourir l'objet avec foreach
    /**
     * Retourne l'élément courant du tableau.
     */
    public function current()
    {
        return $this->array[$this->position];
    }
    /**
     * Retourne la clé actuelle (c'est la même que la position dans notre cas).
     */
    public function key()
    {
        return $this->position;
    }
    /**
     * Déplace le curseur vers l'élément suivant.
     */
    public function next()
    {
        $this->position++;
    }
    /**
     * Remet la position du curseur à 0.
     */
    public function rewind()
    {
        $this->position = 0;
    }
    /**
     * Permet de tester si la position actuelle est valide.
     */
    public function valid()
    {
        return isset($this->array[$this->position]);
    }
}