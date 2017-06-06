<?php

namespace SerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SerieBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    private $date;

    private $file;


    public function __construct()
    {
        $this->newDateTime();
    }

    public function newDateTime()
    {
        $this->date = new \Datetime;
    }

    //--------------------- GUETTEURS ET SETTEURS ----------------------------------------------------------------------

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

    // On vérifie si on avait déjà un fichier pour cette entité
        if (null !== $this->url) {
            // On sauvegarde l'extension du fichier pour le supprimer plus tard
            $this->tempFilename = $this->url;

            // On réinitialise les valeurs des attributs url et alt
            $this->url = null;
            $this->alt = null;
        }
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this -> file;
    }

    //---------------------FONCTIONS UPLOAD IMAGE-----------------------------------------------------------------------

    //---- Avant de persister l'article, je définit le nom de l'url à insérer en BDD et le Alt
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if(null === $this-> file){
            return;
        }
        $this->url = $this-> getFile() ->guessExtension();
        $this->url = $this-> getWebPath();
        $this -> alt = $this -> getFile() -> getClientOriginalName();

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if(null === $this-> file) {
            return;
        }

        //----- Je déplace mon fichier dans le répertoire images (définis dans la fonction getUpladDir) et je renomme le fichier
        //----- nouveau nom = date + nom original du fichier
        $this-> getFile() -> move(
            $this->getUploadDir(),
            $this -> date -> getTimestamp(). $this -> getFile() -> getClientOriginalName()
        );
    }


    public function getUploadDir()
    {
    return 'img';
    }

    public function getWebPath()
    {
        if($this -> date == null){
            $this -> newDateTime();
        }

        return $this->getUploadDir().'/'. $this -> date -> getTimestamp(). $this -> getFile() -> getClientOriginalName();
    }
}
