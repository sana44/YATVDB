<?php

namespace SerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Season
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SerieBundle\Entity\SeasonRepository")
 */
class Season
{
    /**
     * @ORM\ManyToOne(targetEntity="\SerieBundle\Entity\Serie", inversedBy="season")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="season_number", type="integer")
     */
    private $seasonNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="text")
     */
    private $resume;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="diffusion_date", type="date")
     */
    private $diffusionDate;


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
     * Set seasonNumber
     *
     * @param integer $seasonNumber
     * @return Season
     */
    public function setSeasonNumber($seasonNumber)
    {
        $this->seasonNumber = $seasonNumber;

        return $this;
    }

    /**
     * Get seasonNumber
     *
     * @return integer 
     */
    public function getSeasonNumber()
    {
        return $this->seasonNumber;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Season
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set resume
     *
     * @param string $resume
     * @return Season
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set diffusionDate
     *
     * @param \DateTime $diffusionDate
     * @return Season
     */
    public function setDiffusionDate($diffusionDate)
    {
        $this->diffusionDate = $diffusionDate;

        return $this;
    }

    /**
     * Get diffusionDate
     *
     * @return \DateTime 
     */
    public function getDiffusionDate()
    {
        return $this->diffusionDate;
    }

    /**
     * Set serie
     *
     * @param \SerieBundle\Entity\Serie $serie
     * @return Season
     */
    public function setSerie(\SerieBundle\Entity\Serie $serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return \SerieBundle\Entity\Serie 
     */
    public function getSerie()
    {
        return $this->serie;
    }
}
