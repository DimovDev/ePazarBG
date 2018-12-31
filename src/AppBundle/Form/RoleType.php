<?php

namespace AppBundle\Form;



use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, TextType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Role;

class RoleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
//	        ->add('users',ChoiceType::class,array('placeholder'=>false));
	    ->add('users', EntityType::class, array(
	    // looks for choices from this entity
	    'class' => User::class,

	    // uses the User.username property as the visible option string
	    'choice_label' => 'email',

	    // used to render a select box, check boxes or radios
	     'multiple' => true,
	     'expanded' => true,
    ));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Role::class
        ));
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function getBlockPrefix()
//    {
//        return 'appbundle_role';
//    }


}
