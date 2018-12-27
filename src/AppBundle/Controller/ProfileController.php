<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProfileType;

///**
// * Profile controller.
// *
// * @Route("profile")
// */
class ProfileController extends Controller
{
//	/**
//	 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
//	 * @Route("/profile",name="user_profile")
//	 * @param Request $request
//	 * @return \Symfony\Component\HttpFoundation\Response
//	 */
//	public function profile(Request $request)
//	{
//		$userId = $this->getUser()->getId();
//
//		$user = $this
//			->getDoctrine()
//			->getRepository(User::class)
//			->find($userId);
//		$image = new Profile();
//		$form = $this->createForm(Profile::class, $image);
//		$form->handleRequest($request);
//		if ($form->isSubmitted() && $form->isValid()) {
//			/** @var UploadedFile $file */
//			$file = $form->getData()->getImage();
//
//
//			$fileName = md5(uniqid('', true)) . '.' . $file->guessExtension();
//
//			try {
//				$file->move($this->getParameter('article_directory'),
//					$fileName);
//			} catch (FileException $ex) {
//
//			}
//
//			$image->setImage($fileName);
//			$currentUser = $this->getUser();
//			$image->setUsers($currentUser);
//
//
//			$em = $this->getDoctrine()->getManager();
//			$em->persist($image);
//			$em->flush();
//			$this->addFlash('success', 'Succesefuli Created!');
//			return $this->redirectToRoute('homepage');
//		}
//			return $this->render('profile/profile.html.twig',
//				['user' => $user]);
//	}
//    /**
//     * Lists all profile entities.
//     *
//     * @Route("/", name="profile_index")
//     * @Method("GET")
//     */
//    public function indexAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $profiles = $em->getRepository('AppBundle:Profile')->findAll();
//
//        return $this->render('profile/index.html.twig', array(
//            'profiles' => $profiles,
//        ));
//    }
//
//    /**
//     * Creates a new profile entity.
//     *
//     * @Route("/new", name="profile_new")
//     * @Method({"GET", "POST"})
//     */
//    public function newAction(Request $request)
//    {
//        $profiles = new Profile();
//        $form = $this->createForm('AppBundle\Form\ProfileType', $profiles);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($profiles);
//            $em->flush();
//
//            return $this->redirectToRoute('profile_show', array('id' => $profiles->getId()));
//        }
//
//        return $this->render('profile/new.html.twig', array(
//            'profile' => $profiles,
//            'form' => $form->createView(),
//        ));
//    }
//
//    /**
//     * Finds and displays a profile entity.
//     *
//     * @Route("/{id}", name="profile_show")
//     * @Method("GET")
//     */
//    public function showAction(Profile $profile)
//    {
//        $deleteForm = $this->createDeleteForm($profile);
//
//        return $this->render('profile/show.html.twig', array(
//            'profile' => $profile,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//	/**
//	 * Displays a form to edit an existing profile entity.
//	 *
//	 * @Route("/{id}/edit", name="profile_edit")
//	 * @Method({"GET", "POST"})
//	 * @param $id
//	 * @param Request $request
//	 * @param Profile $profile
//	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//	 */
//    public function editAction($id,Request $request, Profile $profile)
//    {
//        $deleteForm = $this->createDeleteForm($profile);
//        $editForm = $this->createForm(ProfileType::class, $profile);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('profile_edit', array('id' => $profile->getId()));
//        }
//
//        return $this->render('profile/edit.html.twig', array(
//            'profile' => $profile,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    /**
//     * Deletes a profile entity.
//     *
//     * @Route("/{id}", name="profile_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, Profile $profile)
//    {
//        $form = $this->createDeleteForm($profile);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($profile);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('profile_index');
//    }
//
//    /**
//     * Creates a form to delete a profile entity.
//     *
//     * @param Profile $profile The profile entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Profile $profile)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('profile_delete', array('id' => $profile->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
//    }
}
