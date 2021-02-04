<?php
declare(strict_types=1);
namespace app\dao;
use app\entitiesTools;

//Final class = pas d'héritage
final class MyPDO
{
// Singleton = Classe instanciée qu'une seule fois (static)
// Utilisation d'une méthode pour instancier (Design Pattern) avec constructeur en private
// Constructeur utilisé via getInstancePDO
    private static $mypdo = null;
// Message de debogage
    private static $debug = true;
// Data Source Name
    private static $dsn = null;
// Utilisateur
    private static $user = null;
// Mot de passe
    private static $pass = null;
// gestion Charset
    private static $charsetUTF8 = true;
// Connexion à la base
    private  $pdo = null;
// path fichier Log
    private static $pathLog = null;

// Constructeur privé
    private function __construct(){
        //self::msg("Demande construction PDO...");
        if( is_null(self::$dsn) || is_null(self::$user) || is_null(self::$pass) )
            throw new \Exception("Construction impossible : les paramètres de connexion sont absents");
        // Etablir la connexion
        $this->pdo = new \PDO(self::$dsn, self::$user, self::$pass);
        // PDO classe faisant partie du namespace global
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        //gestion des exceptions
        //Attention récupération de tableau associatif mais le type des cellules = String
        //Il faudra donc caster
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        // type par défaut pour fetch - fetchAll, redéfinir si autre type
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        // on gère donc le cast quand nécessaire
        /*
         * influence de ce paramètre au niveau performance ...
         *
        problème de gestion correcte des données avec fetch & fetchall
        pour la récupération des int PK et FK
        si ATTR_EMULATE_PREPARES à true on récupère des types string
        si ATTR_EMULATE_PREPARES à false on récupère les types corrects définis au niveau de la structure sql
        prévoir la migration vers php7 avec un type strict ...
        */

        if (self::$charsetUTF8 === true)
            $this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        // on aurait pu utiliser au niveau du dsn  dans le constructeur ;charset = utf-8
        // prévoir un query spécifique avant insertion et/ou update
        //self::msg("Construction PDO terminée");
    }

// Destructeur
    public function __destruct(){
        //self::msg("Demande de destruction PDO...");
// S'il y a une connexion établie...
        if(!is_null($this->pdo))
        {
            // ... il faut se deconnecter
            //self::msg("Demande de déconnexion...");
            $this->pdo = null;
            self::$mypdo = null;
            //self::msg("Deconnexion effectuée");
        }
        //self::msg("Destruction PDO terminée");
    }

// Récupérer l'objet pdo
    public static function getInstancePDO(){
        //self::msg("Recherche de l'instance...");
// Une instance est-elle disponible ?
        if(!isset(self::$mypdo))
            self::$mypdo = new MyPDO();
        //self::msg("Instance trouvée");
        return self::$mypdo->pdo;
    }

    public function getPdo()
    {
        return $this->pdo;
    }




// Fixer les paramètres de connexion
public static function parametres ($_dsn,$_user, $_pass){
self::$dsn=$_dsn;
self::$user=$_user;
self::$pass=$_pass;
}

// Fixer path fichier Log
//public static function param_path ($path) {
//    self::$pathLog = $path;
//}

// changer attribut static
public static function param_charset ($bool){
    self::$charsetUTF8 = $bool;
}

// Interdit le clonage du singleton
public function __clone(){
    throw new \Exception("Clonage de ".__CLASS__."interdit !");
}

// Récupérer le singleton
public static function getInstanceSingleton(){
    //self::msg("Recherche de l'instance...");
// Une instance est-elle disponible ?
    if(!isset(self::$mypdo))
        self::$mypdo = new MyPDO();
    //self::msg("Instance trouvée");
// return self::$mypdo->pdo;
    return self::$mypdo;
}

// Surcharge de toutes les méthodes indisponibles de myPDO pour pouvoir appeler celles de PDO
public function __call($methodName,$methodArguments){
// La méthode appelée fait-elle partie de la classe PDO
    if(!method_exists($this->pdo, $methodName))
        throw new \Exception("PDO::$methodName n'existe pas");
// Message de debogage
    //self::msg("PDO::$methodName(" . implode($methodArguments, ", ") . ")");
// Appel de la méthode avec l'objet PDO
    $result=call_user_func_array(array($this->pdo, $methodName),$methodArguments);
    return $result;
}
    // Affichage de messages de contrôle
//    public static function msg($m){
//        if(self::$debug)
//            \entitiesTools\Logger::writeLog (self::$pathLog,"TRACE_PDO",$m);
//    }
    // Mise en marche du debogage
    public static function debug_on(){
        self::$debug=true;
    }
    // Arrêt du debogage
    public static function debug_off(){
        self::$debug=false;
    }


}