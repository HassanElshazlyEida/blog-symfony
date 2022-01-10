<?php
namespace App\Listeners;


class VideoCreatedListener {

    public function OnVideoCreatedEvent($event){
        dump($event->video->title.' From Listener ');
    }
}