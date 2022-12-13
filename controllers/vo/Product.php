<?php
declare(strict_types=1);


namespace app\controllers\vo;

class Product implements \JsonSerializable
{
    public function __construct(
        private int    $product_id,
        private Prices $prices
    )
    {
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return Prices
     */
    public function getPrices(): Prices
    {
        return $this->prices;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }


}