<?php
declare(strict_types=1);

namespace app\entitieswebImmo;


class photoBien implements \JsonSerializable
{
    use Hydratation;

    private int $id_photo = 0;
    private int $bienImmobilier;
    private String $nomImage;
    private String $thumbnail;

    /**
     * @return String
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param String $thumbnail
     */
    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return int
     */


    public function getIdPhoto(): int
    {
        return $this->id_photo;
    }

    /**
     * @param int $id_photo
     */
    public function setIdPhoto(int $id_photo): void
    {
        $this->id_photo = $id_photo;
    }

    /**
     * @return int
     */
    public function getBienImmobilier(): int
    {
        return $this->bienImmobilier;
    }

    /**
     * @param int $bienImmobilier
     */
    public function setBienImmobilier(int $bienImmobilier): void
    {
        $this->bienImmobilier = $bienImmobilier;
    }

    /**
     * @return String
     */
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }

    /**
     * @param String $commentaire
     */
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return String
     */
    public function getNomImage(): string
    {
        return $this->nomImage;
    }

    /**
     * @param String $nomImage
     */
    public function setNomImage(string $nomImage): void
    {
        $this->nomImage = $nomImage;
    }





    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

}