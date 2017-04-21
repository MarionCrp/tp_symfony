<?php

namespace sil16\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('customer', 'entity', array(
          'class' => 'sil16VitrineBundle:Customer',
          'property' => 'fullName',
          'multiple' => false,
          'label' => 'Client'
          )
        )->add('state')->add('created_at', 'date', ['widget' => 'single_text', 'format' => 'dd-MM-yyyy']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sil16\VitrineBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sil16_adminbundle_product';
    }


}
