<?php


namespace AppBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
	/**
	 * @Route("/login",name="security_login")
	 *
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function login()
	{

			$this->addFlash('notice', 'Successfully Register!');

		return $this->render('security/login.html.twig.');
	}

	/**
	 * @Route("/logout",name="security_logout")
	 * @throws \Exception
	 */
	public function logout(): void
	{
		throw new \Exception('Logout failed');
	}



}