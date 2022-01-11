<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Form\VideoFormType;
use App\Services\MyService;
use App\Services\GiftsService;
use App\Events\VideoCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $em,$logger,EventDispatcherInterface $dispatcher)
    {
        $this->em=$em;
        $this->dispatcher=$dispatcher;
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
        // Form Section
        $video = new Video();
        $video->setCreatedAt(new \DateTime ('tomorrow'));
        $form=$this->createForm(VideoFormType::class, $video);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $file = $form->get('filename')->getData();
            
            $ext=$file->guessExtension();
            $fileName = sha1(random_bytes(14)).'.'.$ext;
            $file->move(
                $this->getParameter('videos_directory'),
                $fileName
            );
            $video->setFilename($fileName);
            $video->setFormat($ext);

            $this->em->persist($video);
            $this->em->flush();
            return $this->redirectToRoute("default");
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users'=>$users,
            "gifts"=>$gifts->gifts,
            "form"=> $form->createView()
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
    /**
     * @Route("cache", name="cache")
     */
    public function cache(): Response
    {
        $cache= new FilesystemAdapter();

        $posts=$cache->getItem("database.get_posts");

        if(!$posts->isHit()){
            $posts_db=['post 1', 'post 2', 'post 3'];
            dump("connected with db ...");
            $posts->set(serialize($posts_db));
            $posts->expiresAfter(5);
            $cache->save($posts);
        }
        // remove cache item
        // $cache->deleteItem('database.get_posts');
        // or all cache
        // $cache->clear();
        dd(unserialize($posts->get()));
    }
    /**
     * @Route("event", name="event")
     */
    public function event()
    {
        $video= new \stdClass();
        $video->title="movie";
        $video->category="drama";
        
        $event=new VideoCreatedEvent($video);
        //Event By Listeners (Services.yaml) And Subscribers
        $this->dispatcher->dispatch($event,"video.created.event");
        dd(1);
    }
    /**
     * @Route("mail", name="mail")
    */
    public function mail(\Swift_Mailer $mailer):Response{

        $message=(new \Swift_Message("Hello Email"))
        ->setFrom('test@example.com')
        ->setTo('recieve@example.com')
        ->setBody(
            $this->renderView(
                'emails/registration.html.twig',
                ['name' => "Hassan Elshazly"]
            ),
            'text/html'
        );
        $mailer->send($message);
        return new Response("Email has been sent");
    }

}
