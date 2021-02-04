<?php
declare(strict_types=1);

namespace app\entitiesTools;


class Logger
{
    // méthode pour écrire dans un fichier texte en mode append
    public static function writeLog (string $pathLog, string $type, string $value):void{
        //crée un identifiant, on lui passe le chemin en absolu/relatif pour récupérer le fichier
        //mode r = read, w = write, a = append (prend le fichier et ajoute des commentaires)
        $idFile = fopen($pathLog,"a+");
        //Verrouille un fichier en mode exclusif (que nous pouvons l'ouvrir le temps de l'utilisation)
        flock($idFile, LOCK_EX);
        //Variable message pour ajouter des elements
        $message = "";
        $message .= "type Erreur : " .$type . "\n";
        //fonction Date prend date serveur automatiquement et ici on donne format à utiliser
        $message .= "Date Erreur : " . date("d M Y H:i:s") . "\n";
        $message .= "Message d'erreur : \n";
        $message .= $value . "\n";
        $message .= "---------------------------------\n";
        //Ecrire dans le fichier
        fwrite($idFile,$message);
        //libère le tampon
        fflush($idFile);
        //Déverrouille le fichier
        flock($idFile, LOCK_UN);
        //On ferme
        fclose($idFile);
    }
}