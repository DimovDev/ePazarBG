<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Review;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ReviewType;
use Symfony\Component\Routing\Annotation\Route;


class ReviewController extends Controller
{
    /**
     * Lists all review entities.
     *
     * @Route("reviews/", name="reviews_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('AppBundle:Review')->findAll();

        return $this->render('review/index.html.twig', array(
            'reviews' => $reviews,
        ));
    }

	/**
	 * Creates a new review entity.
	 *
	 * @Route("/product/{id}/review", name="reviews_new")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request
	 * @param Product $product
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function newAction(Request $request,Product $product)
    {
    	    	dump($product);
	    $user = $this->getUser();
dump($user);
	    /** @var User $author */
	    $author = $this
		    ->getDoctrine()
		    ->getRepository(User::class)
		    ->find($user->getId());

        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        $review->setAuthor($author);
        $review->setProduct($product);

        $author->addReview($review);
        $product->addReview($review);
//        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
//        }

//        return $this->render('review/new.html.twig', array(
//            'review' => $review,
//            'form' => $form->createView(),
//        ));
    }

    /**
     * Finds and displays a review entity.
     *
     * @Route("reviews/{id}", name="reviews_show")
     * @Method("GET")
     */
    public function showAction(Review $review)
    {
        $deleteForm = $this->createDeleteForm($review);

        return $this->render('review/show.html.twig', array(
            'review' => $review,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing review entity.
     *
     * @Route("reviews/edit/{id}", name="reviews_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Review $review)
    {
        $deleteForm = $this->createDeleteForm($review);
        $editForm = $this->createForm('AppBundle\Form\ReviewType', $review);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_show', array('id' => $review->getId()));
        }

        return $this->render('review/edit.html.twig', array(
            'review' => $review,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a review entity.
     *
     * @Route("reviews/delete/{id}", name="reviews_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Review $review)
    {
        $form = $this->createDeleteForm($review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($review);
            $em->flush();
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * Creates a form to delete a review entity.
     *
     * @param Review $review The review entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Review $review): \Symfony\Component\Form\FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reviews_delete', array('id' => $review->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
