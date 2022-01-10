<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;
use App\Services\MyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $em,$logger)
    {
        $this->em=$em;
        // $logger->info("Binding Logger to controller");
    }
    /**
     * @Route("/default", name="default")
     */
    public function index(GiftsService $gifts,Request $request,MyService $service): Response
    {
        // Raw sql
        $id=1;$max=4;
        $sql="
            SELECT * FROM user u
            WHERE u.id > $id
            LIMIT $max
        ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $users =  $stmt->executeQuery()->fetchAllAssociative();
        dump($users);
        // Doctrine repository 
    
        $users=$this->em->getRepository(User::class)->findBy([],[],4);

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
    /**
     * @Route("show/{id}", name="show")
     */
    // Annotations for Controllers
    public function show(User $user): Response
    {
        dd($user);
    }
    /**
     * @Route("store/{email}", name="store")
     */
    public function store($email): Response
    {
       $user= new User();
       $user->setName("Hassan");
       $user->setEmail($email);
      
       $this->em->persist($user);
       $this->em->flush();
       dd($user);
    }
}
