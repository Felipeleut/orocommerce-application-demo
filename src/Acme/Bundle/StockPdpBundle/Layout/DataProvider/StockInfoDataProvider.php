<?php

namespace Acme\Bundle\StockPdpBundle\Layout\DataProvider;

use Acme\Bundle\StockPdpBundle\Provider\StockProvider;
use Oro\Bundle\ProductBundle\Entity\Product;

class StockDataProvider
{
    public function __construct(
        private StockProvider $stockProvider
    ) {
    }

    public function getStockInfo(Product $product): array
    {
        return $this->stockProvider->getStockInfo($product);
    }
}
