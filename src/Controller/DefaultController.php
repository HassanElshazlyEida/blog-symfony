<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function __construct($logger)
    {
        // $logger->info("Binding Logger to controller");
    }
    /**
     * @Route("/default", name="default")
     */
    public function index(GiftsService $gifts,Request $request): Response
    {

        $users=$this->getDoctrine()->getRepository(User::class)->findAll();

        $this->addFlash("Welcome","Welcome to Blog Page");

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users'=>$users,
            "gifts"=>$gifts->gifts
        ]);

    }


    /**
     * @Route("/download")  
     */
    public function download()
    {
        $path=$this->getParameter('download_dir');

        return $this->file($path.'text.txt');
    }
    
    /**
     * @Route("forward-to-controller")
     */
    public function forwardingToController()    
    {
        $response= $this->forward(
            'App\Controller\DefaultController::methodToForward',
            ['param'=>1]
        );
        return $response;
    }

    /**
     * @Route("metho-to-forward")
     */
    public function methodToForward($param)
    {
       exit(" This forward method ". $param);
    }

    public function PopularPost($number=3){

        $posts=["post 1","post 2","post 3","post 4"];
        
        return $this->render("default/popularPost.html.twig",[
            "posts"=>$posts
        ]);
    }
}
