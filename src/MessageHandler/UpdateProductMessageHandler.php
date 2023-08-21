<?php

namespace App\MessageHandler;

use App\Message\UpdateProductMessage;
use App\Service\ErpConnectorService;
use App\Service\WholesaleService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateProductMessageHandler
{
    public function __construct(
        private ErpConnectorService $erp,
        private WholesaleService $wholesale
    ) {}
    
    public function __invoke(UpdateProductMessage $message)
    {
        $erpProduct = $this->erp->getProduct($message->getItemNumber());
        $this->erp->updateProduct($erpProduct);

        $wholesaleProduct = $this->wholesale->getProduct($message->getItemNumber());
        $this->wholesale->updateProduct($wholesaleProduct);
    }
}
