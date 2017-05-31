<?php

namespace SerieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Serie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SerieBundle\Entity\SerieRepository")
 */
class Serie
{

  /**
   * @ORM\OneToMany(targetEntity="\SerieBundle\Entity\SerieComment", mappedBy="serie", cascade={"remove"})
   */
  private $comments;

    /**
     * @ORM\OneToOne(targetEntity="\SerieBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
  private $image;

    /**
     * @ORM\OneToMany(targetEntity="\SerieBundle\Entity\Season", mappedBy="serie", cascade={"remove"})
     */
    private $seasons;

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
     * @ORM\ManyToOne(targetEntity="\SerieBundle\Entity\SerieCategory", inversedBy="serie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
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
     * @ORM\Column(name="release_date", type="date")
     */
    private $releaseDate;


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
     * Set name
     *
     * @param string $name
     * @return Serie
     */
    public function setName($name)
    {
        $this->name = trim($name);

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
     * @return Serie
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
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     * @return Serie
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime 
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Set image
     *
     * @param \SerieBundle\Entity\Image $image
     * @return Serie
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
     * Add seasons
     *
     * @param \SerieBundle\Entity\Season $seasons
     * @return Serie
     */
    public function addSeason(\SerieBundle\Entity\Season $seasons)
    {
        $this->seasons[] = $seasons;

        return $this;
    }

    /**
     * Remove seasons
     *
     * @param \SerieBundle\Entity\Season $seasons
     */
    public function removeSeason(\SerieBundle\Entity\Season $seasons)
    {
        $this->seasons->removeElement($seasons);
    }

    /**
     * Get seasons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeasons()
    {
        return $this->seasons;
    }

    /**
     * Set category
     *
     * @param \SerieBundle\Entity\SerieCategory $category
     * @return Serie
     */
    public function setCategory(\SerieBundle\Entity\SerieCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \SerieBundle\Entity\SerieCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add comments
     *
     * @param \SerieBundle\Entity\SerieComment $comments
     * @return Serie
     */
    public function addComment(\SerieBundle\Entity\SerieComment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \SerieBundle\Entity\SerieComment $comments
     */
    public function removeComment(\SerieBundle\Entity\SerieComment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /*
     * Get episodes count
     */
    public function getEpisodesCount()
    {
        $total = 0;
        foreach($this->getSeasons() as $s){
            $total += count($s->getEpisodes());
        }
        return $total;
    }
}
