<?php

namespace App\MessageHandler;

use App\Message\ReloadFromErpMessage;
use App\Service\ErpConnectorService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ReloadFromErpMessageHandler
{

    public function __construct(
        private ErpConnectorService $erp
    ){}

    public function __invoke(ReloadFromErpMessage $message)
    {
    }
}
