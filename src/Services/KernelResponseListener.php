<?php

namespace App\Services;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Httpkernel\Event\FilterResponseEvent;

class KernelResponseListener {

    public function onKernelResponse(FilterResponseEvent $event){
        $resonse=new Response("dupa");
        $event->setResponse($resonse);
    }
}