<?php

namespace App\MessageHandler;

use App\Message\UpdateProductFromErpMessage;
use App\Service\ErpConnectorService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UpdateProductFromErpMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private ErpConnectorService $erp
    ) {}

    public function __invoke(UpdateProductFromErpMessage $message)
    {
        $this->erp->updateProduct($message->getProduct());
    }
}
