<?php

namespace Journal\JournalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\CallbackTransformer;
use Journal\JournalBundle\Entity\Tag;

class CommonArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class)
                ->add('content', TextareaType::class)
                ->add('published', DateTimeType::class)
                ->add('tags', TextType::class);
        
        $builder->get('tags')
                ->addModelTransformer(new CallbackTransformer(
                function ($aTags) {
                    // transform the array to a string
			    	$aTagNames = [];
			    	foreach ($aTags as $oTag) $aTagNames[] = $oTag->getName();
			    	return implode(', ', $aTagNames);
                },
                function ($sTags) {
                    // transform the string back to an array
                    $aTags = [];
                    $aTagNames = array_map('trim', explode(',', $sTags)); 
                    foreach ($aTagNames as $sTagName) {
                    	$oTag = new Tag();
                    	$oTag->setName($sTagName);
                    	$aTags[] = $oTag;
                    }
                    return $aTags;
                }
        ));
                
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Journal\JournalBundle\Entity\CommonArticle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'journal_journalbundle_commonarticle';
    }


}
