<?php

namespace Journal\JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="Journal\JournalBundle\Entity\Repository\TagRepository")
 * @ORM\Table(name="tags")
 * @ORM\HasLifecycleCallbacks
 */
class Tag {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $created;
	
    /**
     * @ORM\ManyToMany(targetEntity="CommonArticle", mappedBy="tags")
     */
    protected $articles;
    
	
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->articles = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Tag
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
     * Set created
     *
     * @param \DateTime $created
     * @return Tag
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add articles
     *
     * @param \Journal\JournalBundle\Entity\CommonArticle $articles
     * @return Tag
     */
    public function addArticle(\Journal\JournalBundle\Entity\CommonArticle $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Journal\JournalBundle\Entity\CommonArticle $articles
     */
    public function removeArticle(\Journal\JournalBundle\Entity\CommonArticle $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
