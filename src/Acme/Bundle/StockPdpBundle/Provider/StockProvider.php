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

    /**
     * Returns total quantity across all inventory levels for the product.
    */
    public function getStockInfo(Product $product): array
    {
        $repo = $this->doctrine->getRepository(InventoryLevel::class);

        $levels = $repo->findBy(['product' => $product]);

        $quantity = 0;
    
        foreach ($levels as $level) {
            $quantity += $level->quantity;
        }

        return ['quantity' => $quantity];
    }
}
