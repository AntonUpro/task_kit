<?php
declare(strict_types=1);


namespace app\controllers;

use app\controllers\handlers\ProductHandler;
use app\controllers\mappers\ProductMapper;
use app\controllers\vo\ProductResponse;
use yii\rest\Controller;
use yii\web\Request;

class ProductController extends Controller
{
    public function __construct($id, $module, private ProductMapper $mapper, private ProductHandler $handler, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionCreate(Request $request)
    {
        try {
            // получаем объект из запроса
            $requestMap = $this->mapper->loadDataFromRequest($request);
            // обновляем/сохраняем данные в таблице price
            $response = $this->handler->handle($requestMap);
            return $response;
        } catch (\Exception|\Error $error) {

             return new ProductResponse(false, $error->getMessage());
        }
    }
}