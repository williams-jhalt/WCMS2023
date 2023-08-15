<?php

namespace App\MessageHandler;

use App\Message\UpdateCustomerFromErpMessage;
use App\Service\ErpConnectorService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateCustomerFromErpMessageHandler
{
    
    public function __construct(
        private ErpConnectorService $erp
    ){}

    public function __invoke(UpdateCustomerFromErpMessage $message)
    {
    }
}
