<?php

namespace App\MessageHandler;

use App\Message\UpdateCustomerFromErpMessage;
use App\Service\ErpConnectorService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UpdateCustomerFromErpMessageHandler implements MessageHandlerInterface
{

    public function __construct(
        private ErpConnectorService $erp
    ) {}

    public function __invoke(UpdateCustomerFromErpMessage $message)
    {

        $this->erp->updateCustomer($message->getCustomer());

    }
}
