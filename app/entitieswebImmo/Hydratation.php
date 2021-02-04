<?php
declare(strict_types=1);

namespace app\entitieswebImmo;
trait Hydratation {
    //hydrate une objet  en lui passant un tableau associatif
    // index = nom de l'attribut, value = valeur à assigner à l'attribut
    // méthode générique ...
    public function hydrate(array $array): void{
        foreach ($array as $key=>$value){
            $methode = "set".ucfirst($key); // setter commence set suivi 1ère lettre en majuscules
            if (method_exists($this, $methode)){
                $this->$methode($value);
            }
        }
    }
}