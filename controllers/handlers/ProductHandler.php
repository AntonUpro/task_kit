<?php
declare(strict_types=1);


namespace app\controllers\handlers;

use app\controllers\vo\DataRequest;
use app\controllers\vo\ProductResponse;
use app\models\Key;
use app\models\Price;
use app\models\Product;
use app\models\Region;

class ProductHandler
{
    public function handle(DataRequest $request): ProductResponse
    {
        $updateLines = 0;
        $addLines = 0;
        try {
            // валидация полученного пароля
            if (!$this->validate($request->getKey())) {
                throw new \Exception("no valid `key`");
            }
            // маппинг пришедшего объекта
            $transaction = \Yii::$app->getDb()->beginTransaction();

            foreach ($request->getData()->getProducts() as $product) {
                // проверка на наличие id в таблице product
                $idProduct = $product->getProductId();
                if (!Product::find()->andWhere(['id' => $idProduct])->one()) {
                    throw new \Exception("not found id_product `$idProduct` in table `product`");
                }
                foreach ($product->getPrices()->getPrices() as $price) {
                    // проверка на наличие id в таблице region
                    $idRegion = $price->getIdRegion();
                    if (!Region::find()->andWhere(['id' => $idRegion])->one()) {
                        throw new \Exception("not found id_region `$idRegion` in table `region`");
                    }
                    $productsQuery = Price::find()->andWhere([
                        'id_region' => $idRegion,
                        'id_product' => $idProduct
                    ]);

                    // проверяем количество полученных строк, не должно быть больше одной
                    if ($productsQuery->count() > 1) {
                        throw new \Exception("found more than one line in id_product `$idProduct` and id_region `$idRegion`");
                    }
                    $productsQuery = $productsQuery->one();

                    // если найдена строка с таким регионом и продуктом, то обновляем данные строки
                    if (isset($productsQuery)) {
                        $productsQuery->price_purchase = $price->getPricePurchase();
                        $productsQuery->price_selling = $price->getPricePurchase();
                        $productsQuery->price_discount = $price->getPriceDiscount();
                        $productsQuery->updated_at = (new \DateTime())->format('Y-m-d H:m:s');
                        $updateLines++;
                    } else {
                        // иначе добавляем новую строку
                        $productsQuery = new Price([
                            'id_product' => $product->getProductId(),
                            'id_region' => $price->getIdRegion(),
                            'price_purchase' => $price->getPricePurchase(),
                            'price_selling' => $price->getPriceSelling(),
                            'price_discount' => $price->getPriceDiscount()
                        ]);
                        $addLines++;
                    }
                    // сохраняем или обновляем строки
                    if (!$productsQuery->save()) {
                        throw new \Exception("error save in id_product `$idProduct` and id_region `$idRegion`");
                    }
                }
            }
            // коммитим все изменения в базе данных
            $transaction->commit();
            return new ProductResponse(true, "updated $updateLines lines, added $addLines lines");
        } catch (\Exception|\Error $error) {
            // откатываем все изменения в базе данных
            $transaction->rollBack();
            throw new \Exception($error->getMessage());
        }
    }

    private function validate(string $key): bool
    {
        $passwords = Key::find()->all();
        foreach ($passwords as $password) {
            if (\Yii::$app->getSecurity()->validatePassword($key, $password->hash_key)) {
                return true;
            }
        }
        return false;
    }
}