<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
	    $user = $this->getUser();
	    if ($user===null){
		    $this->addFlash('error', 'You need to login or register to add  a advert');

//				die('here');

		    return $this->redirectToRoute('security_login');
	    }
        if ($form->isSubmitted() && $form->isValid()) {

        dump($form->getData());
	        /** @var UploadedFile $file */
	        $file = $form->getData()->getImage();


	        $fileName = md5(uniqid('', true)) . '.' . $file->guessExtension();

	        try {
		        $file->move($this->getParameter('product_directory'),
			        $fileName);
	        } catch (FileException $ex) {

	        }
	        $product->setImage($fileName);
	        $currentUser = $this->getUser();
	        $product->setAuthor($currentUser);
	        $product->setViewCount(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
	        $this->addFlash('notice', 'Successfully Created!');
	        return $this->redirectToRoute('homepage'
//            return $this->redirectToRoute('product_show'
	            , array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

	/**
	 * Finds and displays a product entity.
	 *
	 * @Route("/{id}", name="product_show")
	 * @Method("GET")
	 * @param $id
	 * @param Product $product
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function showAction($id,Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
		$product=$this
			->getDoctrine()
			->getRepository(Product::class )
	        ->find($id);

	    $reviews = $this->getDoctrine()
		    ->getRepository(Review::class)
		    ->findAllComments($product);

		$product->setViewCount($product->getViewCount()+1);
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($product);
	    $em->flush();

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'reviews'=>$reviews,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
	        /** @var UploadedFile $file */
	        $file = $editForm->getData()->getImage();


	        $fileName = md5(uniqid('', true)) . '.' . $file->guessExtension();

	        try {
		        $file->move($this->getParameter('product_directory'),
			        $fileName);
	        } catch (FileException $ex) {

	        }
	        $product->setImage($fileName);
	        $currentUser = $this->getUser();
	        $product->setAuthor($currentUser);
	        $product->setViewCount(0);

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($product);
	        $em->flush();
	        $this->addFlash('notice', 'Successfully Edited!');
            return $this->redirectToRoute('homepage', array('id' => $product->getId()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

	/**
	 * Deletes a product entity.
	 *
	 * @Route("/{id}/delete", name="product_delete")
	 * @Method("DELETE")
	 * @param Request $request
	 * @param Product $product
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

	/**
	 * Creates a form to delete a product entity.
	 *
	 * @param Product $product The product entity
	 *
	 *
	 * @return \Symfony\Component\Form\FormInterface
	 */
    private function createDeleteForm(Product $product): \Symfony\Component\Form\FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
