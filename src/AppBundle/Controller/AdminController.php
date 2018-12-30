<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;

use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
			['allUsers' => $allUsers, 'allRoles' => $allRoles]);
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

	/**
	 * @Route ("/edit" , name="admin_edit")
	 * @param $id
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editProfileAction(Request $request): \Symfony\Component\HttpFoundation\Response
	{
		$allRoles = $this
		->getDoctrine()
		->getRepository(Role::class)
		->findAll();
		$user = $this->getUser();

		$form = $this->createForm(UserType::class, $user);
		dump($user);

		if ($user === null) {
			return $this->redirectToRoute('homepage');
		}


		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

//
			$role = $this
				->getDoctrine()
				->getRepository(Role::class)
				->findAll();
//		$user =$this
//			->getDoctrine()
//			->getRepository(User::class)
//			->findOneBy($allUsers);
			$user = $this->getUser();
//			dump($this->getUser());
//		$user->getRoles($role);
			$user->editRoles($role);
			dump($user);
//		$user = $this->getUser()->editRoles($role);
			$currentUser = $this->getUser();
			dump($currentUser);


			$em = $this->getDoctrine()->getManager();
			$em->merge($currentUser);
			$em->flush();
			return $this->redirectToRoute('user_profile');
		}

return $this->render('admin/edit.html.twig', ['form' => $form->createView(), 'user' => $user,'allRoles' => $allRoles]);
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
