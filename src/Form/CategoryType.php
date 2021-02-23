<?php

namespace App\Form;

use App\Entity\Category;
use App\Services\EntryTagEntityManagerService;
use App\SilverHead\Form\TagType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tagManagerService = new EntryTagEntityManagerService($this->manager);

        $builder
            ->add('label', TextType::class, [
                'label' => 'category.form.label.label'
            ])
            ->add('badgeColor', ColorType::class, [
                'label' => 'category.form.label.badgeColor'
            ])
            ->add('tags', TagType::class, [
                'entity_manager_for_data_transformer' => $tagManagerService,
                'label' => 'category.form.label.keywords'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
