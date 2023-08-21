<?php

namespace App\MessageHandler;

use App\Message\UpdateCustomerMessage;
use App\Service\ErpConnectorService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateCustomerMessageHandler
{
    public function __construct(
        private ErpConnectorService $erp
    ) {}
    
    public function __invoke(UpdateCustomerMessage $message)
    {

        $erpCustomer = $this->erp->getCustomer($message->getCustomerNumber());
        $this->erp->updateCustomer($erpCustomer);

    }
}
