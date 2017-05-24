<?php

namespace SerieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class SerieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('image', 'entity', array(
                'class'=>"SerieBundle:Image",
                'property'=>"Url",
                'multiple'=>false,
                'required'=>false,
                'empty_value'=>"Choisir Url"
                ))
            ->add('category','entity', array(
                'class'=>"SerieBundle:serieCategory",
                'property'=>"name",
                'multiple'=>false,
                'required'=>true,
                'expanded'=>true
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SerieBundle\Entity\Serie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'seriebundle_serie';
    }
}
