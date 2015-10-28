<?php

namespace v1m\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use v1m\TaskBundle\Entity\Task;
use v1m\TaskBundle\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function newAction(Request $request)
    {
        // создаём задачу и присваиваем ей некоторые начальные данные для примера
        $task = new Task();
        $form = $this->createForm(new TaskType(), $task);
        // $task->setTask('Write a blog post');
        // $task->setEmail('nikogo@doma.net');
        // $task->setDueDate(new \DateTime('tomorrow'));

        // $form = $this->createFormBuilder($task)
        //     ->add('task', 'text')
        //     ->add('email', 'email')
        //     ->add('dueDate', 'date', array('widget' => 'single_text'))
        //     ->getForm();

	    if ($request->getMethod() == 'POST') {
	        $form->bind($request);

	        if ($form->isValid()) {
	            // выполняем прочие действие, например, сохраняем задачу в базе данных
	            $em = $this->getDoctrine()->getManager();
	            $em->persist($task);
	            $em->flush();

	            return $this->redirect($this->generateUrl('task_show', array('id' => $task->getId())));
	        }
	    }
        return $this->render('v1mTaskBundle:Default:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function showAction($id)
    {
    	$task = $this->getDoctrine()->getRepository('v1mTaskBundle:Task')->find($id);

    	// if(!$product) {
    	// 	throw $this->createNotFoundException('No product found for id '.$id);
    	// }

        return $this->render('v1mTaskBundle:Default:show.html.twig', array('task' => $task));
    }
}
