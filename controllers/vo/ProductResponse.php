<?php
declare(strict_types=1);


namespace app\controllers\vo;

class ProductResponse implements \JsonSerializable
{
public function __construct(private bool $success, private string $msg)
{
}

    /**
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }


}