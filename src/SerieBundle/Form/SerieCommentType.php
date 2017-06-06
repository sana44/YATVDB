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
            ->add('content', 'textarea', ['attr' => ['class' => 'addCommentTextarea'],
                                          'label' => 'Commentaire :'])
            ->add('score', 'integer',
                  ['attr' => ['min' => 0,
                              'max' => 5,
                              'class' => 'addCommentScore'],
                   'label' => 'Note :'
                  ])
            ->add('save', 'submit', ['attr' => ['class' => 'btn btn-default addCommentSubmit'],
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
