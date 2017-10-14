<?php

namespace Journal\JournalBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommonArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommonArticleRepository extends EntityRepository
{
	
    public function getTaggedArticles($sTagName, $iLimit = null)
    {
		$oQB = $this->createQueryBuilder('a')
		            ->select('a')
		            ->join('a.tags', 't', 'WITH', 't.name = ?1')
		            ->addOrderBy('a.published', 'DESC');
		
		$oQB->setParameter(1, $sTagName);

		if (false === is_null($iLimit))
			$oQB->setMaxResults($iLimit);
		
		return $oQB->getQuery()
		           ->getResult();
    }
    
    
    public function addTagsToArticles(\Journal\JournalBundle\Entity\CommonArticle $oArticle, $aTags)
    {
    	foreach ($aTags as $oTagStub) {
			$oTag = $this->_em->getRepository('JournalJournalBundle:Tag')->getOrAddTagByName($oTagStub->getName());
			$oArticle->addTag($oTag);
    	}
    	
    	return $oArticle;
    }
    
}