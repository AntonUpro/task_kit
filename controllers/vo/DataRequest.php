<?php
declare(strict_types=1);


namespace app\controllers\vo;

class DataRequest implements \JsonSerializable
{
    public function __construct(
        private Data   $data,
        private string $key
    )
    {
    }

    /**
     * @return Data
     */
    public function getData(): Data
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }


}