<?php

namespace SerieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SerieCommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea', ['attr' => ['class' => 'addCommentTextarea']])
            ->add('score', 'integer',
                  ['attr' => ['min' => 0,
                              'max' => 5,
                              'class' => 'addCommentScore'],
                  ])
            ->add('save', 'submit', ['attr' => ['class' => 'addCommentSubmit'],
                                     'label' => 'Envoyer'])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SerieBundle\Entity\SerieComment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'seriebundle_seriecomment';
    }
}
