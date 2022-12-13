<?php
declare(strict_types=1);


namespace app\controllers\vo;

class Price implements \JsonSerializable
{
    public function __construct(
        private int   $idRegion,
        private float $price_purchase,
        private float $price_selling,
        private float $price_discount,
    )
    {
    }

    /**
     * @return int
     */
    public function getIdRegion(): int
    {
        return $this->idRegion;
    }

    /**
     * @return float
     */
    public function getPricePurchase(): float
    {
        return $this->price_purchase;
    }

    /**
     * @return float
     */
    public function getPriceSelling(): float
    {
        return $this->price_selling;
    }

    /**
     * @return float
     */
    public function getPriceDiscount(): float
    {
        return $this->price_discount;
    }

    public function jsonSerialize(): mixed
    {
        return [$this->getIdRegion() => [
            'price_purchase' => $this->getPricePurchase(),
            'price_selling' => $this->getPriceSelling(),
            'price_discount' => $this->getPriceDiscount()
        ]];
    }


}