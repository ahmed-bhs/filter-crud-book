<?php

namespace InfoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class InfoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
            ->add('inv', Filters\TextFilterType::class)
            ->add('titre', Filters\TextFilterType::class)
            ->add('auteur', Filters\TextFilterType::class)
            ->add('cote', Filters\TextFilterType::class)
            ->add('expl', Filters\NumberFilterType::class)
            ->add('codeBare', Filters\NumberFilterType::class)
            ->add('exposan', Filters\TextFilterType::class)
        
        ;
        $builder->setMethod("GET");


    }

    public function getBlockPrefix()
    {
        return null;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
