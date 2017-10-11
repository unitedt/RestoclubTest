<?php

namespace Journal\JournalBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Journal\JournalBundle\Entity\AuthorArticle;
use Journal\JournalBundle\Entity\CommonArticle;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
	protected $discriminator = null;
	
    public function getLatestArticles($iLimit = null)
    {
		$oQB = $this->createQueryBuilder('a')
		            ->select('a')
		            ->addOrderBy('a.published', 'DESC');

		if (false === is_null($iLimit))
			$oQB->setMaxResults($iLimit);
		
		if(false === is_null($this->discriminator)) {
			$oQB->where('a INSTANCE OF ?1');
			$oQB->setParameter(1, $this->discriminator);
		}

		return $oQB->getQuery()
		           ->getResult();
    }
    
    
    public function getOrCreateArticle($sDiscriminator, $id = null)
    {
        if (!$id) {
	        $oArticle = $sDiscriminator == 'author' ? new AuthorArticle() : new CommonArticle();
	        
    	} else {
        	$oArticle = $this->find($id);
  	
    	}
    	
    	return $oArticle;
    }
    
    
    public function persistArticle(\Journal\JournalBundle\Entity\Article $oArticle, $aTags = []) 
    {
		if ($oArticle instanceof CommonArticle) {
			$oArticle->clearTags();
			$this->_em->getRepository('JournalJournalBundle:CommonArticle')->addTagsToArticles($oArticle, $aTags);
		}
            
		$this->_em->persist($oArticle);
		$this->_em->flush();
    }
	
}
