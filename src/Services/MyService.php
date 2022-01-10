<?php

namespace App\Services;

use App\Services\MySecondService;
use Doctrine\ORM\Event\PostFlushEventArgs;

class MyService implements ServiceInterface {
    
    use OptionalServiceTrait;

    public $logger;
    public $my;

    public function __construct($param,MySecondService $second_param)
    {
        dump ($param);
    }
    public function postFlush(PostFlushEventArgs $args){
        dump ('hello postflush!');
        dump ( $args);
    }
    public function clear(){
        dump("clear...");
    }
 


}
