<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Category;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->add('name')
//
//	        ->add('parent');
	    $parentsQueryBuilder = function (EntityRepository $er){
		    return $er->createQueryBuilder('c')
			    ->orderBy('c.path', 'ASC');
	    };

	    $builder
		    ->add('name')
//		    ->add('description')
		    ->add('parent', null,[
			    'label' => 'Parent Category',
			    'query_builder' => $parentsQueryBuilder,
			    'placeholder' => '/',
			    'choice_label' => 'getNameTree',
		    ]); //   getPathFormatted

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
	    $resolver->setDefaults(array(
		    'data_class' => Category::class,
		    'group_by' => function (Category $category) {
			    return $category->getParent()->getName();
		    }

	    ));
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function getBlockPrefix()
//    {
//        return 'appbundle_category';
//    }


}
