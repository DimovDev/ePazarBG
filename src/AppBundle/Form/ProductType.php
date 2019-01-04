<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
		$parentsQueryBuilder = function (EntityRepository $er) {
			return $er->createQueryBuilder('c')
				->orderBy('c.path', 'ASC');
		};


		$builder->add('title')
			->add('description')
			->add('image', FileType::class,
				['data' => null])
			->add('price')
			->add('phone')
//		        ->add('categories', EntityType::class,
//			        array('class' => Category::class,
////				        'label' => 'Parent Category',
////				        'query_builder' => $parentsQueryBuilder,
////				        'placeholder' => '/',
////				        'choice_label' => 'getNameWithSpaces'
////			        ));
//				        'choice_label' =>'getNameTree',
////					        function ($category, $key, $value) {
////						        /** @var Category $category */
//						        return $category->getName(['name'=>$this->getParent()]);
//					        },
			->add('categories', null, [
				'label' => 'Parent Category',
				'query_builder' => $parentsQueryBuilder,
				'placeholder' => '/',
				'choice_label' => 'getOptionPath',
			]) //   getPathFormatted
//				        'group_by' => 'parent'));
			->add('location', null, [
				'attr' => [
					'class' => 'controls',
					'placeholder' => 'Enter your full address',
				],
			]);


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
