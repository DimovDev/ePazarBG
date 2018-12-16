<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Product;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')->add('description')
	        ->add('image')->add('price')
	        ->add('location')->add('phone')
	        ->add('categories',EntityType::class,
		        array('class'=>Category::class,
			        'choice_label' =>
				        function($category, $key, $value) {
					        /** @var Category $category */
					        return strtoupper($category->getName(['name','id']));
				        },'group_by'=>'parent'));

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class
//        ,'group_by' => function (Category $category) {
//		        return $category->getParent()->getName();
//	        }
        ));
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function getBlockPrefix()
//    {
//        return 'appbundle_product';
//    }


}
