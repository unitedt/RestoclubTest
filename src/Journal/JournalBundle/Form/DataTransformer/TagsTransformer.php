<?php

namespace Journal\JournalBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Journal\JournalBundle\Entity\Tag;

class TagsTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $oManager)
    {
        $this->manager = $oManager;
    }

    /**
     * @param  Tag[] $aTags
     * @return string
     */
    public function transform($aTags)
    {
        $aTagNames = [];
        foreach ($aTags as $oTag) {
            $aTagNames[] = $oTag->getName();
        }
        return implode(', ', $aTagNames);
    }

    /**
     * @param  string $sTags
     * @return Tag[]
     */
    public function reverseTransform($sTags)
    {
        $aTags = [];

        $aTagNames = array_map('trim', explode(',', $sTags));
        
        foreach ($aTagNames as $sTagName) {
            $aTags[] = $this->manager->getRepository(Tag::class)->getOrAddTagByName($sTagName);
        }
                    
                    
        return $aTags;    
    }
    
}
