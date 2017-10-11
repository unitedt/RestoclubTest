<?php

namespace Journal\JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Journal\JournalBundle\Form\CommonArticleType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="Journal\JournalBundle\Entity\Repository\CommonArticleRepository")
 * @ORM\Table(name="articles_tags")
 */
class CommonArticle extends Article {
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles")
     * @ORM\JoinTable(name="articles_tags",
     *   joinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}     
     * )
     * @Assert\Count(max=3)
     */
    protected $tags;
    
    public function __construct()
    {
    	parent::__construct();
        $this->tags = new ArrayCollection();
    }


    /**
     * Add tags
     *
     * @param \Journal\JournalBundle\Entity\Tag $tags
     * @return CommonArticle
     */
    public function addTag(\Journal\JournalBundle\Entity\Tag $tags)
    {
    	$tags->addArticle($this);
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Journal\JournalBundle\Entity\Tag $tags
     */
    public function removeTag(\Journal\JournalBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * Clear tags
     *
     */
    public function clearTags()
    {
        $this->tags->clear();
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return CommonArticle
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    public function getFormClass() 
    {
    	return CommonArticleType::class;
    }
    
 }
