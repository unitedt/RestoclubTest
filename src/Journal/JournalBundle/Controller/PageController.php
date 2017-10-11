<?php

namespace Journal\JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
		$oEM = $this->getDoctrine()->getManager();

		$aArticles = $oEM->getRepository('JournalJournalBundle:Article')
		                 ->getLatestArticles();
		$aTags = $oEM->getRepository('JournalJournalBundle:Tag')
		             ->getLatestTags();

		return $this->render('JournalJournalBundle:Page:index.html.twig', [
			'articles' => $aArticles,
			'tags' => $aTags,
		]);
    }
    
    public function authorAction()
    {
		$oEM = $this->getDoctrine()->getManager();

		$aArticles = $oEM->getRepository('JournalJournalBundle:AuthorArticle')
		                 ->getLatestArticles();

		return $this->render('JournalJournalBundle:Page:index.html.twig', [
			'articles' => $aArticles,
		]);
    }
    
    public function tagAction($name)
    {
		$oEM = $this->getDoctrine()->getManager();

		$aArticles = $oEM->getRepository('JournalJournalBundle:CommonArticle')
		                 ->getTaggedArticles($name);
		$aTags = $oEM->getRepository('JournalJournalBundle:Tag')
		             ->getLatestTags();
		
		return $this->render('JournalJournalBundle:Page:index.html.twig', [
			'articles' => $aArticles,
			'tags' => $aTags,
		]);
    }
}
