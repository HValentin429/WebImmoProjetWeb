<?php
declare(strict_types=1);

namespace app\entitieswebImmo;


class BienImmobilier implements \JsonSerializable
{
    use Hydratation;

    private int $id_bienImmobilier = 0;
    //protected string $adresse; //Reste, maintenant split
    private string $nRue;
    private string $rue;
    private string $codePostal;
    private string $ville;
    private string $chauffage;
    private float $surface;
    private string $commentaire;
    private string $PEB;
    private string $cuisine;
    private int $controleElectricite;
    private int $nbPieces ;
    private int $prix ;
    private string $parking;
    private string $typeBien;
    private string $achatLocation;
    private int $proprietaire;



    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    /**
     * BienImmobilier constructor.
     */
    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    /**
     * @return int
     */
    public function getPrix(): int
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix(int $prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */



    public function getAchatLocation(): string
    {
        return $this->achatLocation;
    }

    /**
     * @param string $achatLocation
     */
    public function setAchatLocation(string $achatLocation): void
    {
        $this->achatLocation = $achatLocation;
    }



    /**
     * @return int
     */
    public function getIdBienImmobilier(): int
    {
        return $this->id_bienImmobilier;
    }

    /**
     * @param int $id_bienImmobilier
     */
    public function setIdBienImmobilier(int $id_bienImmobilier): void
    {
        $this->id_bienImmobilier = $id_bienImmobilier;
    }



    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getChauffage(): string
    {
        return $this->chauffage;
    }

    /**
     * @param string $chauffage
     */
    public function setChauffage(string $chauffage): void
    {
        $this->chauffage = $chauffage;
    }

    /**
     * @return float
     */
    public function getSurface(): float
    {
        return $this->surface;
    }

    /**
     * @param float $surface
     */
    public function setSurface(float $surface): void
    {
        $this->surface = $surface;
    }



    /**
     * @return string
     */
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return string
     */
    public function getPEB(): string
    {
        return $this->PEB;
    }

    /**
     * @param string $PEB
     */
    public function setPEB(string $PEB): void
    {
        $this->PEB = $PEB;
    }

    /**
     * @return string
     */
    public function getCuisine(): string
    {
        return $this->cuisine;
    }

    /**
     * @param string $cuisine
     */
    public function setCuisine(string $cuisine): void
    {
        $this->cuisine = $cuisine;
    }

    /**
     * @return int
     */
    public function isControleElectricite(): int
    {
        return $this->controleElectricite;
    }

    /**
     * @param int $controleElectricite
     */
    public function setControleElectricite(int $controleElectricite): void
    {
        $this->controleElectricite = $controleElectricite;
    }

    /**
     * @return int
     */
    public function getNbPieces(): int
    {
        return $this->nbPieces;
    }

    /**
     * @param int $nbPieces
     */
    public function setNbPieces(int $nbPieces): void
    {
        $this->nbPieces = $nbPieces;
    }

    /**
     * @return string
     */
    public function getParking(): string
    {
        return $this->parking;
    }

    /**
     * @param string $parking
     */
    public function setParking(string $parking): void
    {
        $this->parking = $parking;
    }

    /**
     * @return string
     */
    public function getTypeBien(): string
    {
        return $this->typeBien;
    }

    /**
     * @param string $typeBien
     */
    public function setTypeBien(string $typeBien): void
    {
        $this->typeBien = $typeBien;
    }

    /**
     * @return int
     */
    public function getProprietaire(): int
    {
        return $this->proprietaire;
    }

    /**
     * @param int $proprietaire
     */
    public function setProprietaire(int $proprietaire): void
    {
        $this->proprietaire = $proprietaire;
    }/**
 * @return string
 */
public function getNRue(): string
{
    return $this->nRue;
}/**
 * @param string $nRue
 */
public function setNRue(string $nRue): void
{
    $this->nRue = $nRue;
}/**
 * @return string
 */
public function getRue(): string
{
    return $this->rue;
}/**
 * @param string $rue
 */
public function setRue(string $rue): void
{
    $this->rue = $rue;
}/**
 * @return string
 */
public function getCodePostal(): string
{
    return $this->codePostal;
}/**
 * @param string $codePostal
 */
public function setCodePostal(string $codePostal): void
{
    $this->codePostal = $codePostal;
}/**
 * @return string
 */
public function getVille(): string
{
    return $this->ville;
}/**
 * @param string $ville
 */
public function setVille(string $ville): void
{
    $this->ville = $ville;
}



    public function __toString():string
    {
        return $this->$this->adresse . " " . $this->id_bienImmobilier . " " . $this-> chauffage . " " . $this->surface . " " . $this->commentaire
        . " " . $this->PEB . " " . $this->cuisine . " " . $this->controleElectricite . " " . $this->nbPieces . " " . $this->parking . " " . $this->typeBien
        . " " . $this->achatLocation . " " . $this->proprietaire;

    }


}