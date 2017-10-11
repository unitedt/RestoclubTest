<?php

namespace Journal\JournalBundle\Tests\Entity;

use Journal\JournalBundle\Entity\CommonArticle;

class CommonArticleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFormClass()
    {
    	$oArticle = new CommonArticle();
    	$this->assertEquals('Journal\JournalBundle\Form\CommonArticleType', $oArticle->getFormClass());
    }
    
	public function testSlugify()
	{
	    $oArticle = new CommonArticle();
	
	    $this->assertEquals('hello-world', $oArticle->slugify('Hello World'));
	    $this->assertEquals('proverka-zhurnala', $oArticle->slugify('Проверка журнала'));
	    $this->assertEquals('jornal', $oArticle->slugify('jornal '));
	    $this->assertEquals('jornal', $oArticle->slugify(' jornal'));
	}
}
