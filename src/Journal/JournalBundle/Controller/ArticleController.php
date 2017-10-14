<?php

namespace Journal\JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Journal\JournalBundle\Entity\CommonArticle;


/**
 * Article controller
 */
class ArticleController extends Controller
{
    /**
     * Show an article
     */
    public function showAction($slug)
    {
        $oEM = $this->getDoctrine()->getManager();

        $oArticle = $oEM->getRepository('JournalJournalBundle:Article')->findOneBySlug($slug);

        if (!$oArticle) {
            throw $this->createNotFoundException('Unable to find article.');
        }

        return $this->render('JournalJournalBundle:Article:show.html.twig', [
        	'discriminator' => $oArticle instanceof CommonArticle ? 'common' : 'author', 
            'article'       => $oArticle,
        ]);
    }
    
    /**
     * Edit/create article 
     */
    public function editAction(Request $oRequest, $id, $discriminator)
    {
    	$oARep = $this->getDoctrine()->getManager()->getRepository('JournalJournalBundle:Article');
     	
		if (!($oArticle = $oARep->getOrCreateArticle($discriminator, $id))) {
			throw $this->createNotFoundException('Unable to find article.');
		}
      
        $oForm = $this->createForm($oArticle->getFormClass(), $oArticle);
        $oForm->handleRequest($oRequest);

        if ($oForm->isSubmitted() && $oForm->isValid()) {
        	$oARep->persistArticle($oArticle);
        	
            return $this->redirect($this->generateUrl('JournalJournalBundle_article_show', ['slug' => $oArticle->getSlug()]));
        }
     
        return $this->render('JournalJournalBundle:Article:form.html.twig', [
        	'discriminator' => $discriminator,
        	'act'           => $id ? 'update' : 'create',
            'article'       => $oArticle,
            'form'          => $oForm->createView()
        ]);
    }
    
}
