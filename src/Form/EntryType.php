<?php

namespace App\Form;

use App\Entity\Entry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('operationNumber')
            ->add('label')
            ->add('description')
            ->add('amount')
            ->add('date')
            ->add('account', EntityType::class, [
                'class' => 'App\Entity\Account',
                'choice_label' => 'label'
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entry::class,
        ]);
    }
}
