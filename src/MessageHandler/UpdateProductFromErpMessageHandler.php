<?php

namespace App\MessageHandler;

use App\Message\UpdateProductFromErpMessage;
use App\Service\ErpConnectorService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateProductFromErpMessageHandler
{

    public function __construct(
        private ErpConnectorService $erp
    ){}
    
    public function __invoke(UpdateProductFromErpMessage $message)
    {
    }
}
