<?php
declare(strict_types=1);


namespace app\controllers\vo;

class Data implements \JsonSerializable
{
    private array $products;
    public function __construct(Product ...$products)
    {
        $this->products = $products;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function jsonSerialize(): mixed
    {
        return $this->getProducts();
    }


}