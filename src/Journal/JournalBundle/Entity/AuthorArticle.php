<?php

namespace Journal\JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Journal\JournalBundle\Form\AuthorArticleType;


/**
 * @ORM\Entity(repositoryClass="Journal\JournalBundle\Entity\Repository\AuthorArticleRepository")
 * @ORM\Table(name="author_articles")
 */
class AuthorArticle extends Article {
	/**
	 * @ORM\Column(type="string")
	 */
	protected $author;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $url;

    /**
     * Set author
     *
     * @param string $author
     * @return AuthorArticle
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return AuthorArticle
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
    
    public function getFormClass() {
    	return AuthorArticleType::class;
    }
    
}
