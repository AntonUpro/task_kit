<?php
declare(strict_types=1);


namespace app\controllers\vo;

use yii\base\Theme;

class Prices implements \JsonSerializable
{
    private array $prices;

    public function __construct(...$prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return array
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    public function jsonSerialize(): mixed
    {
        return $this->getPrices();
    }


}