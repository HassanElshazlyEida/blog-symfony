<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoListController extends AbstractController
{
    /**
     * @Route("/to/do/list", name="to_do_list")
     */
    public function index(): Response
    {
        return $this->render('to_do_list/index.html.twig', [
            'controller_name' => 'ToDoListController',
        ]);
    }

    /**
     * @Route("/create", name="create_task", methods={"POST"})
     */
    public function create(): Response
    {   
        dd(1);
        return $this->render('to_do_list/index.html.twig', [
            'controller_name' => 'ToDoListController',
        ]);
    }

     /**
     * @Route("/switch-status/{id}", name="switch-status")
     */
    public function switchStatus($id): Response
    {   
        dd(1);
      
    }

     /**
     * @Route("/delete/{id}", name="delete_task")
     */
    public function delete($id): Response
    {   
        dd(1);
      
    }
}
