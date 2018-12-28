<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;

use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends Controller
{
	/**
	 * @Route("/admin", name="all_users" ,methods={"GET"})
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction()
	{
		$allUsers = $this
			->getDoctrine()
			->getRepository(User::class)
			->findAll();
		$allRoles = $this
			->getDoctrine()
			->getRepository(Role::class)
			->findAll();
		return $this->render('admin/main.html.twig',
			['allUsers' => $allUsers ,'allRoles'=>$allRoles]);
	}

	/**
	 * @Route("/user_profile/{id}", name="admin_user_profile")
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function userProfile($id)
	{
		$user = $this
			->getDoctrine()
			->getRepository(User::class)
			->find($id);

		return $this->render('admin/main.html.twig',
			['user' => $user]);
	}
//	/**
//	 * @Route("/admin",name="admin_panel")
//	 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
//	 */
//	public function adminPanel()
//	{
//		/** @var User $currUser */
//		$currUser = $this->getUser();
//		if (!$currUser->isAdmin()) {
//			return $this->redirectToRoute('homepage');
//		}
//		$roles = $this->getDoctrine()->getRepository(Role::class)->findAll();
//		$users = $this->getDoctrine()->getRepository(User::class)->findAll();
//		$form = $this->createForm(UserType::class, $roles);
//		return $this->render('admin/main.html.twig', ['users' => $users, 'form' => $form->createView()]);
//	}
}
