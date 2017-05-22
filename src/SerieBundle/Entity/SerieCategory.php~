<?php

namespace SerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SerieCategory
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SerieBundle\Entity\SerieCategoryRepository")
 */
class SerieCategory
{

    /**
     * @ORM\OneToMany(targetEntity="\SerieBundle\Entity\Serie", mappedBy="category")
     */
    private $series;
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * @return SerieCategory
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
     * Constructor
     */
    public function __construct()
    {
        $this->series = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add series
     *
     * @param \SerieBundle\Entity\Serie $series
     * @return SerieCategory
     */
    public function addSeries(\SerieBundle\Entity\Serie $series)
    {
        $this->series[] = $series;

        return $this;
    }

    /**
     * Remove series
     *
     * @param \SerieBundle\Entity\Serie $series
     */
    public function removeSeries(\SerieBundle\Entity\Serie $series)
    {
        $this->series->removeElement($series);
    }

    /**
     * Get series
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeries()
    {
        return $this->series;
    }
}
