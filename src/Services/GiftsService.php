<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class GiftsService {

    public $gifts = ['First Place','Second Place','Third Place','Fourth Place'];

    public function __construct(LoggerInterface $logger)
    {
        $logger->info("Gift were Randomized !");
        shuffle($this->gifts);
    }
}