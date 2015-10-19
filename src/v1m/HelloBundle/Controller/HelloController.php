<?php

namespace v1m\HelloBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HelloController extends Controller
{
/**
 * Hello controller.
 *
 * @Route("/hello/{name}")
 */
	
	public function indexAction(Request $request, $name)
	{
		return $this->render('v1mHelloBundle:Hello:show.html.twig', array('path' => 'hz', 'name' => $name));
	}

	public function showAction(Request $request, $name, $path)
	{
		// Если установлена сессионная переменная _locale выставляем локаль
        if ($locale = $request->getSession()->get('_locale')) {
        	$request->setLocale($locale);
        } else {
        	// иначе устанавливаем сессионную переменную _locale и выставляем локаль
        	$request->getSession()->set('_locale', 'ru');
        	$request->setLocale($request->getSession()->get('_locale'));
        }
        $locale = $request->getlocale();

        if ($name === "er") {
        	throw $this->createNotFoundException('Таких тут нет!');
        }
        // Проверяем каким путем пришли
        switch ($path) {
        	case 'hell':
	        	return $this->render('v1mHelloBundle:Hello:show.html.twig', array('path' => $path, 'name' => $name, 'locale' => $locale));
	        	break;

        	case 'hello':
        		$request->getSession()->getFlashBag()->add('notice', 'From hell with love!');
        		$url = $this->get('router')->generate('v1m_hello', array('path' => $path,'name' => 'mimimi'), true);
        		return $this->render('v1mHelloBundle:Hello:show.html.twig', array('path' => $path, 'name' => $name, 'locale' => $locale, 'url' => $url));
        		break;

        	default:
        		return $this->render('v1mHelloBundle:Hello:show.html.twig', array('path' => 'hz', 'name' => $name));
        		break;
        }
	}
}