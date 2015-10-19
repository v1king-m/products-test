<?php

namespace v1m\HelloBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
class DefaultController extends Controller
{
/**
 * Hell controller.
 *
 * @Route("/hell/{name}")
 */
    public function indexAction(Request $request, $name)
    {
        // Если установлена сессионная переменная _locale выставляем локаль
        if ($locale = $request->getSession()->get('_locale')) {
            $request->setLocale($locale);
        } 
        else {
            // иначе устанавливаем сессионную переменную _locale
            $request->getSession()->set('_locale', 'ru');
        }

    	// $session = $request->getSession();
    	$locale = $request->getlocale();
    	// $locale = $request->attributes->get('_locale');

    	if ($name === "er") {
    		throw $this->createNotFoundException('Таких тут нет!');
    		// return $this->render('v1mHelloBundle:Default:index.html.twig', array('name' => $name));
    	}
        return $this->render('v1mHelloBundle:Default:index.html.twig', array('name' => $name, 'locale' => $locale));
    }
}
