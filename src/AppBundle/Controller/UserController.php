<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class UserController extends Controller
{
	/**
	 * @Route("/register",name="user_register")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @throws \Exception
	 */
	public function registerAction(Request $request)
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted()) {

			if ($form->isValid()) {

				// Check for already existing user with the same email
				$emailForm = $form
					->getData()
					->getEmail();

				$existingUser = $this
					->getDoctrine()
					->getRepository(User::class)
					->findOneBy(['email' => $emailForm]);

//				dump($user);
//				exit;

				if (null !== $existingUser) {
					$this->addFlash('error', 'Username with email ' . $emailForm . ' already taken!');
					return $this->redirectToRoute('user_register');
				}


				// So, go ahead and register our new user!
				$password = $this->get('security.password_encoder')
					->encodePassword($user, $user->getPassword());

				$roleRepository = $this->getDoctrine()
					->getRepository(Role::class);
				if ($this->getCountOfRegisteredUsers() === 0) {
					$userRole = $roleRepository->findOneBy(['name' => 'ROLE_ADMIN']);
					//If there is no users in DB first one should be ADMIN all others are USERS
				} else {
					$userRole = $roleRepository->findOneBy(['name' => 'ROLE_USER']);
				}

				$user->addRole($userRole);
				$user->setPassword($password);
				$em = $this->getDoctrine()->getManager();
				$em->persist($user);
				$em->flush();

				$this->addFlash('notice', 'Successfully Register!');

//				die('here');

				return $this->redirectToRoute('security_login');

			} else {

				$this->addFlash(
					'error',
					'Passwords don\'t  match');
				return $this->render('users/register.html.twig', array('form' => $form->createView()));

			}


		}
		return $this->render('users/register.html.twig', array('form' => $form->createView()));
	}
	private function getCountOfRegisteredUsers(): int
	{
		return \count($this->getDoctrine()->getRepository(User::class)->findAll());
	}
}
