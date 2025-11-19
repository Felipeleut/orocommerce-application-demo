<?php

namespace Acme\Bundle\StockPdpBundle\Provider;

use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\ProductBundle\Model\ProductView;
use Oro\Bundle\InventoryBundle\Entity\InventoryLevel;

class StockProvider
{
    public function __construct(
        private ManagerRegistry $doctrine
    ) {
    }

    public function getStockInfo(Product $product): array
    {

    }
}
