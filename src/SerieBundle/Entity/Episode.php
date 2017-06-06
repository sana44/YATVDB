<?php

namespace SerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Episode
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SerieBundle\Entity\EpisodeRepository")
 */
class Episode
{
  /**
   * @ORM\OneToOne(targetEntity="\SerieBundle\Entity\Image", cascade={"persist"})
   */
  private $image;

  /**
   * @ORM\ManyToOne(targetEntity = "\SerieBundle\Entity\Season", inversedBy="episodes")
   * @ORM\JoinColumn(nullable = false)
   */
  private $season;

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
   * @ORM\Column(name="episode_number", type="integer")
   */
  private $episodeNumber;

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
   * Set episodeNumber
   *
   * @param integer $episodeNumber
   * @return Episode
   */
  public function setEpisodeNumber($episodeNumber)
  {
    $this->episodeNumber = $episodeNumber;

    return $this;
  }

  /**
   * Get episodeNumber
   *
   * @return integer 
   */
  public function getEpisodeNumber()
  {
    return $this->episodeNumber;
  }

  /**
   * Set name
   *
   * @param string $name
   * @return Episode
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
   * @return Episode
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
   * @return Episode
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
     * Set image
     *
     * @param \SerieBundle\Entity\Image $image
     * @return Episode
     */
    public function setImage(\SerieBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \SerieBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set season
     *
     * @param \SerieBundle\Entity\Season $season
     * @return Episode
     */
    public function setSeason(\SerieBundle\Entity\Season $season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \SerieBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set serie
     *
     * @param \SerieBundle\Entity\Serie $serie
     * @return Episode
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
