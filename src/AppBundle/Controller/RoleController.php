<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\RoleType;
use Symfony\Component\HttpFoundation\Response;


/**
 * Role controller.
 *
 * @Route("roles")
 *
 */
class RoleController extends Controller
{
	/**
	 * Lists all role entities.
	 *
	 * @Route("/", name="roles_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$roles = $em->getRepository('AppBundle:Role')->findAll();

		return $this->render('role/index.html.twig', array(
			'roles' => $roles,
		));
	}

	/**
	 * Creates a new role entity.
	 *
	 * @Route("/new", name="roles_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$role = new Role();
		$form = $this->createForm(RoleType::class, $role);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($role);
			$em->flush();

			return $this->redirectToRoute('roles_show', array('id' => $role->getId()));
		}

		return $this->render('role/new.html.twig', array(
			'role' => $role,
			'form' => $form->createView(),
		));
	}

	/**
	 * Finds and displays a role entity.
	 *
	 * @Route("/{id}", name="roles_show")
	 * @Method("GET")
	 */
	public function showAction(Role $role)
	{
		$deleteForm = $this->createDeleteForm($role);

		return $this->render('role/show.html.twig', array(
			'role' => $role,
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing role entity.
	 *
	 * @Route("/{id}/edit", name="roles_edit", methods={"GET", "POST"})
	 * @param Role $role
	 * @param Request $request
	 * @return RedirectResponse|Response
	 */
	public function editAction(Role $role, Request $request)
	{
		$deleteForm = $this->createDeleteForm($role);
		$existingUsers = $role->getUsers()->toArray();
		$oldName = $role->getName();

		$editForm = $this->createForm(RoleType::class, $role);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {

			$newName = $role->getName();

			if ($oldName !== $newName && $this->getDoctrine()->getRepository(Role::class)->findOneBy(['name' => $newName])) {
				$this->addFlash('error',
					"Cannot rename to $newName because this name is already taken!");
			} else {
				$em = $this->getDoctrine()->getManager();
				$newUsers = $role->getUsers()->toArray();

				// detach the existing teg-article relations
				foreach ($existingUsers as $user) {
					/** @var User $user */
					$role->getUsers()->removeElement($user);
					$user->removeRole($role);
					$em->persist($user);
				}

				// attach the newly selected tag-article relations
				foreach ($newUsers as $user) {
					$role->addUser($user);
					$em->persist($user);
				}
				$em->persist($role);
				$em->flush();

				$this->addFlash('success',
					"$role successfully updated");
			}

			return $this->redirectToRoute('roles_index', array('id' => $role->getId()));
		}

		return $this->render('role/edit.html.twig', array(
			'role' => $role,

			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Deletes a role entity.
	 *
	 * @Route("/delete/{id}", name="roles_delete")
	 * @Method("DELETE")
	 */
	public
	function deleteAction(
		Request $request, Role $role)
	{
		$form = $this->createDeleteForm($role);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($role);
			$em->flush();
		}

		return $this->redirectToRoute('roles_index');
	}

	/**
	 * Creates a form to delete a role entity.
	 *
	 * @param Role $role The role entity
	 *
	 * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
	 */
	private
	function createDeleteForm(
		Role $role)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('roles_delete', array('id' => $role->getId())))
			->setMethod('DELETE')
			->getForm();
	}


}
