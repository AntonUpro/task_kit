<?php
declare(strict_types=1);


namespace app\controllers\mappers;

use app\controllers\vo\Data;
use app\controllers\vo\DataRequest;
use app\controllers\vo\Price;
use app\controllers\vo\Prices;
use app\controllers\vo\Product;
use yii\web\Request;

class ProductMapper
{
    private const VARIABLE_DATA_REQUEST = ['data', 'key'];

    private const VARIABLE_PRODUCT = ['product_id', 'prices'];

    private const VARIABLE_PRICES = ['price_purchase', 'price_selling', 'price_discount'];

    public function loadDataFromRequest(Request $request): DataRequest
    {
        foreach (self::VARIABLE_DATA_REQUEST as $item) {
            if (!$request->post($item)) {
                throw new \Exception("not found variable `$item`");
            }
        }
        return new DataRequest(
            $this->getData($request->post('data')),
            $request->post('key'),
        );
    }

    private function getData(array $data): Data
    {
        $dataResponse = [];
        foreach ($data as $product) {
            foreach (self::VARIABLE_PRODUCT as $item) {
                if (!isset($product[$item])) {
                    throw new \Exception("not found variable `$item` in product `$product`");
                }
            }
            $dataResponse[] = new Product(
                $product['product_id'],
                $this->getPrices($product['prices']),
            );
        }
        return new Data(...$dataResponse);
    }

    private function getPrices(array $prices): Prices
    {
        $pricesResponse = [];
        foreach ($prices as $region => $price) {
            // проверка существования переменных
            foreach (self::VARIABLE_PRICES as $item) {
                if (!isset($price[$item])) {
                    throw new \Exception("not found variable `$item` in region `$region");
                }
            }
            $pricesResponse[] = new Price(
                $region,
                $price['price_purchase'],
                $price['price_selling'],
                $price['price_discount'],
            );
        }
        return new Prices(...$pricesResponse);
    }

}