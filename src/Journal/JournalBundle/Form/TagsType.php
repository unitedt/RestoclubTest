<?php

namespace Journal\JournalBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Journal\JournalBundle\Form\DataTransformer\TagsTransformer;


class TagsType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $oManager)
    {
        $this->manager = $oManager;
    }

    public function buildForm(FormBuilderInterface $oBuilder, array $options)
    {
        $oTransformer = new TagsTransformer($this->manager);
        $oBuilder->addModelTransformer($oTransformer);
    }

//     public function configureOptions(OptionsResolver $resolver)
//     {
//         $resolver->setDefaults(array(
//             'invalid_message' => 'The selected issue does not exist',
//         ));
//     }

    public function getParent()
    {
        return TextType::class;
    }
}
