<?php

namespace App\MessageHandler;

use App\Message\UpdateProductFromWholesaleMessage;
use App\Service\WholesaleService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateProductFromWholesaleMessageHandler
{

    public function __construct(
        private WholesaleService $wholesaleService
    ) {}

    public function __invoke(UpdateProductFromWholesaleMessage $message)
    {
        $this->wholesaleService->updateProduct($message->getProduct());
    }
}
