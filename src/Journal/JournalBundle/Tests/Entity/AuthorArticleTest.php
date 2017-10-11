<?php

namespace Journal\JournalBundle\Tests\Entity;

use Journal\JournalBundle\Entity\AuthorArticle;

class AuthorArticleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFormClass()
    {
    	$oArticle = new AuthorArticle();
    	$this->assertEquals('Journal\JournalBundle\Form\AuthorArticleType', $oArticle->getFormClass());
    }
}
