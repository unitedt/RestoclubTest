<?php

namespace Journal\JournalBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testAddAuthorArticle()
    {
        $oClient = static::createClient([], ['HTTP_HOST' => 'localhost:8000']);

        $oCrawler = $oClient->request('GET', '/author_article');

        $this->assertContains('Author', $oClient->getResponse()->getContent());
    
        $oForm = $oCrawler->selectButton('Submit')->form();

        $oCrawler = $oClient->submit($oForm, [
            'journal_journalbundle_authorarticle[author]'                  => 'Author Name',
            'journal_journalbundle_authorarticle[url]'                     => 'http://author.test.com',
        	'journal_journalbundle_authorarticle[title]'                   => 'Test Author Article Title #' . rand(10000, 99999),
        	'journal_journalbundle_authorarticle[content]'                 => 'This is test article content',
        	'journal_journalbundle_authorarticle[published][date][month]'  => '10',
        	'journal_journalbundle_authorarticle[published][date][day]'    => '11',
        	'journal_journalbundle_authorarticle[published][date][year]'   => '2017',
        	'journal_journalbundle_authorarticle[published][time][hour]'   => '18',
        	'journal_journalbundle_authorarticle[published][time][minute]' => '30',
        ]);

        // Need to follow redirect
        $oCrawler = $oClient->followRedirect();

        $this->assertContains('Author Name', $oClient->getResponse()->getContent());
        $this->assertContains('This is test article content', $oClient->getResponse()->getContent());
        
    }
}
