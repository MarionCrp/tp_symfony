<?php

namespace sil16\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('product_category', 'entity', array(
          'class' => 'sil16VitrineBundle:ProductCategory',
          'property' => 'name',
          'multiple' => false,
          'label' => 'Catégorie'
          )
        )->add('price')->add('description',TextareaType::class, array('required' => false))->add('stock')->add('active');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sil16\VitrineBundle\Entity\Product'
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
