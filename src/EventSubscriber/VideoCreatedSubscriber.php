<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Httpkernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VideoCreatedSubscriber implements EventSubscriberInterface
{
    public function onVideoCreatedEvent($event)
    {
        dump($event->video->title.' From Subscriber ');
    }
    public function onVideoCreatedEvent2($event)
    {
        dump($event->video->title.' From Subscriber 2');
    }
    public function OnKernelResponse(FilterResponseEvent $event){
        $resonse=new Response("dupa");
        $event->setResponse($resonse);
    }

    public static function getSubscribedEvents()
    {
        return [
            'video.created.event' => [
                ['onVideoCreatedEvent',2], // highest priority
                ['onVideoCreatedEvent2',1],
            ],
            // KernelEvents::RESPONSE => "OnKernelResponse"
        ];
    }
}
