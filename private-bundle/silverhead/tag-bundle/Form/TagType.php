<?php

namespace SilverHead\Form;

use SilverHead\Form\DataTransformer\TagTransformer;
use SilverHead\TagBundle\Service\TagEntityManagerForDataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TagTransformer($options['entity_manager_for_data_transformer']), true)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'entity_manager_for_data_transformer' => null
        ]);

        $resolver->setAllowedTypes('entity_manager_for_data_transformer', TagEntityManagerForDataTransformerInterface::class);
    }

    public function getParent()
    {
        return TextType::class;
    }
}
