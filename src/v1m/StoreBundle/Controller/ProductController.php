<?php

namespace v1m\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use v1m\StoreBundle\Entity\Product;
use v1m\StoreBundle\Entity\Category;
use v1m\StoreBundle\Form\ProductType;
use Symfony\Component\Security\Core\SecurityContext;

class ProductController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * 
     * 
     * 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('v1mStoreBundle:Product')->findAll();

        return $this->render('v1mStoreBundle:Store:index.html.twig', array('products' => $products));
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('v1mStoreBundle:Store:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }

    public function createAction(Request $request)
    {
    	$product = new Product();

        $form = $this->createForm(new ProductType(), $product);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // выполняем прочие действие, например, сохраняем задачу в базе данных
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Добавлен новый продукт.');
                return $this->redirect($this->get('router')->generate('v1m_store_show', array('id' => $product->getId())));
            }
        }

        return $this->render('v1mStoreBundle:Store:create.html.twig', array('product_form' => $form->createView()));
    }

    public function delete_formAction($id)
    {
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('v1mStoreBundle:Store:del.html.twig', array('delete_form' => $deleteForm->createView()));
    }

    public function showAction($id)
    {
    	$product = $this->getDoctrine()->getRepository('v1mStoreBundle:Product')->find($id);
        $categoryName = $product->getCategory()->getName();

    	// if(!$product) {
    	// 	throw $this->createNotFoundException('No product found for id '.$id);
    	// }
        $deleteForm = $this->createDeleteForm($id);


        return $this->render('v1mStoreBundle:Store:show.html.twig', array('product' => $product, 'delete_form' => $deleteForm->createView()));
    }

    public function showallAction()
    {
        $product = $this->getDoctrine()->getRepository('v1mStoreBundle:Product')->findAll();

        // $categoryName = $product->getCategory()->getName();

        // if(!$product) {
        //     throw $this->createNotFoundException('Not found any products');
        // }

        return $this->render('v1mStoreBundle:Store:show.html.twig', array('products' => $product));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('v1mStoreBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($product);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('v1mStoreBundle:Store:edit.html.twig', 
            array('product' => $product, 'product_form' => $editForm->createView(), 'delete_form' => $deleteForm->createView())
            );
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('v1mStoreBundle:Product')->find($id);

        if(!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $editForm = $this->createEditForm($product);
        $deleteForm = $this->createDeleteForm($id);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('v1m_store_show', array('id' => $id)));
        }

        return $this->redirect($this->generateUrl('v1m_store_edit', array('id' => $id)));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('v1mStoreBundle:Product')->find($id);

        if(!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $em->remove($product);
        $em->flush();

        // return new Response('Product with id '.$id.' is deleted');
        return $this->redirect($this->generateUrl('v1m_store_index'));
    }
    private function createEditForm(Product $product)
    {
        $form = $this->createForm(new ProductType(), $product, array(
            'action' => $this->generateUrl('v1m_store_update', array('id' => $product->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('v1m_store_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Удалить'))
            ->getForm()
        ;
    }
}
