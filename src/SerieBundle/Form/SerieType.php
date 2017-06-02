<?php

namespace SerieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use SerieBundle\Form\ImageType;


class SerieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('resume', 'textarea')
            ->add('release_date', 'date', [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'attr' => ["class" => 'js-datepicker',
                           "placeholder" => 'Pick a date']
            ])
            ->add('image', new ImageType(), array(
                'required' => false))
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
