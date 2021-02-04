<?php
declare(strict_types = 1);
namespace app\entitiesTools;
// namespace spécifique des tools

interface IArrayCollection {

    function addObj(object $obj):void;
    // ajouter un objet au tableau interne

    function addArrayObj(array $array):void;
    // ajouter un tableau d'objets

    function addMergeObj(array $array):void; // idem

    function addCollObj(object $obj):void;
    // ajouter une ArrayCollection d'objets

    function remove(object $obj):void;
    // supprimer un objet si présent dans le tableau interne

    function clear():void;
    // vider le tableau interne

    function contains(object $obj):bool;
    // vérifier si le tableau interne contient un objet

    function isEmpty():bool;
    // vérifier si le tableau interne est vide

    function sort():void;
    // trier le tableau interne d'objets avec usort et une fonction static comparative
}