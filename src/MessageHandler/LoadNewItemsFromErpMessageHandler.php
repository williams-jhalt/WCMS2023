<?php

namespace App\MessageHandler;

use App\Message\LoadNewItemsFromErpMessage;
use App\Service\ErpConnectorService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class LoadNewItemsFromErpMessageHandler implements MessageHandlerInterface
{

    public function __construct(
        private ErpConnectorService $erp
    ) {}
    
    public function __invoke(LoadNewItemsFromErpMessage $message)
    {
        $this->erp->loadNewCustomers();
        $this->erp->loadNewProducts();        
    }
}
