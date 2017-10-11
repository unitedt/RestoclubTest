<?php

namespace Journal\JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Journal\JournalBundle\Entity\Repository\ArticleRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"common" = "CommonArticle", "author" = "AuthorArticle"})
 * @ORM\Table(name="articles")
 * @ORM\HasLifecycleCallbacks
 */
abstract class Article {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $content;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $slug;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $published;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $created;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $updated;
	
	
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
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
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug($this->title);

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
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
    public function getContent($iLength = null)
	{
	    if (false === is_null($iLength) && $iLength > 0)
	        return substr($this->content, 0, $iLength);
	    else
	        return $this->content;
	}

    /**
     * Set slug
     *
     * @param string $slug
     * @return Article
     */
    public function setSlug($slug)
    {
    	$this->slug = $this->slugify($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set published
     *
     * @param \DateTime $published
     * @return Article
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Article
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return Article
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
	public function slugify($sText)
	{
		// replace non letter or digits by -
		$sText = preg_replace('~[^\\pL\d]+~u', '-', $sText);

		// trim
		$sText = trim($sText, '-');

		// transliterate
	    $aMap = [
	    	'а' => 'a',   'б' => 'b',   'в' => 'v',  'г' => 'g',  'д' => 'd',  'е' => 'e',  'ж' => 'zh', 'з' => 'z',
	    	'и' => 'i',   'й' => 'y',   'к' => 'k',  'л' => 'l',  'м' => 'm',  'н' => 'n',  'о' => 'o',  'п' => 'p',
	    	'р' => 'r',   'с' => 's',   'т' => 't',  'у' => 'u',  'ф' => 'f',  'х' => 'h',  'ц' => 'ts', 'ч' => 'ch',
	    	'ш' => 'sh',  'щ' => 'sht', 'ъ' => 'y',  'ы' => 'y',  'ь' => '\'', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A',
	    	'Б' => 'B',   'В' => 'V',   'Г' => 'G',  'Д' => 'D',  'Е' => 'E',  'Ж' => 'Zh', 'З' => 'Z',  'И' => 'I',
	    	'Й' => 'Y',   'К' => 'K',   'Л' => 'L',  'М' => 'M',  'Н' => 'N',  'О' => 'O',  'П' => 'P',  'Р' => 'R',
	    	'С' => 'S',   'Т' => 'T',   'У' => 'U',  'Ф' => 'F',  'Х' => 'H',  'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh',
	    	'Щ' => 'Sht', 'Ъ' => 'Y',   'Ь' => '\'', 'Ю' => 'Yu', 'Я' => 'Ya'
 		];
	    
 		$sText = strtr($sText, $aMap);
  
		// lowercase
		$sText = strtolower($sText);

		// remove unwanted characters
		$sText = preg_replace('~[^-\w]+~', '', $sText);

		if (empty($sText)) {
			$sText = 'n-a';
		}

		return $sText;
	}
	
	abstract public function getFormClass();
	
}
