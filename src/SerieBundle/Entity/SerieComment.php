<?php

namespace SerieBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * SerieComment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SerieBundle\Entity\SerieCommentRepository")
 * @ORM\OrderBy({"createdAt" = "ASC"}) 
 */
class SerieComment
{
    /**
     *
     * @ORM\ManyToOne(targetEntity="\SerieBundle\Entity\Serie", inversedBy="SerieComment")
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
     * @var string
     * @Assert\Length(min=5)
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "The score must be at least {{ limit }}",
     *      maxMessage = "The score must be {{ limit }} maximum"
     * )
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this-> setCreatedAt(new \DateTime());
        $this-> setUpdatedAt(new \DateTime());
    }

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
     * Set content
     *
     * @param string $content
     * @return SerieComment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SerieComment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return SerieComment
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return SerieComment
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set serie
     *
     * @param \SerieBundle\Entity\Serie $serie
     * @return SerieComment
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

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return SerieComment
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
