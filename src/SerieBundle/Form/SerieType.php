<?php

namespace SerieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


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
            ->add('resume')
            ->add('release_date', 'date', [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'attr' => ["class" => 'js-datepicker',
                           "placeholder" => 'Pick a date']
            ])
            ->add('image', 'entity', array(
                'class'=>"SerieBundle:Image",
                'property'=>"Url",
                // 'query_builder' => function(EntityRepository $er){
                //     $qb = $er->createQueryBuilder('b');
                //     $qb2 = $qb;
                //     $selected = $qb->select('image')
                //               ->from('SerieBundle:Serie', 's');
                //     $qb2->select('image')
                //         ->from('SerieBundle:Image', 'i')
                //         ->where($qb2->expr()->notIn('i.id', $selected->getDQL()));
                //     return $qb2;
                // },
                'multiple'=>false,
                'required'=>true,
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
