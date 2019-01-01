<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Review;

class ReviewType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content',TextType::class)
//	        ->add('dateAdded')->add('rating')->add('product')->add('author')
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Review::class
        ));
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function getBlockPrefix()
//    {
//        return 'appbundle_review';
//    }


}
