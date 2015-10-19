<?php

namespace v1m\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use v1m\StoreBundle\Entity\Product;
use v1m\StoreBundle\Entity\Category;

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

    public function createAction($name, $price, $description, $category_name)
    {
        $category = new Category();
        $category->setName($category_name);

    	$product = new Product();
    	$product->setName($name);
    	$product->setPrice($price);
    	$product->setDescription($description);
        $product->setCategory($category);

    	$em = $this->getDoctrine()->getEntityManager();
        $em->persist($category);
    	$em->persist($product);
    	$em->flush();

    	return new Response('Created product id '.$product->getId().' and category id '.$category->getId());
    }

    public function showAction($id)
    {
    	$product = $this->getDoctrine()->getRepository('v1mStoreBundle:Product')->find($id);
        $categoryName = $product->getCategory()->getName();

    	// if(!$product) {
    	// 	throw $this->createNotFoundException('No product found for id '.$id);
    	// }

        return $this->render('v1mStoreBundle:Store:show.html.twig', array('product' => $product));
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

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('v1mStoreBundle:Product')->find($id);

        if(!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $product->setName('product2');
        // Заметьте, что в вызове $em->persist($product) нет необходимости. Вспомните, что этот метод 
        // лишь сообщает Doctrine что нужно управлять или “наблюдать” за объектом $product. 
        // В данной же ситуации, т. к. объект $product получен из Doctrine, он уже является управляемым.
        $em->flush();

        return $this->redirect($this->generateUrl('v1m_store_show', array('id' => $id)));
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

        return new Response('Product with id '.$id.' is deleted');
    }
}
