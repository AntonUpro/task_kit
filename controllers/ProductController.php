<?php
declare(strict_types=1);


namespace app\controllers;

use app\controllers\mappers\ProductMapper;
use yii\rest\Controller;
use yii\web\Request;

class ProductController extends Controller
{
    public function __construct($id, $module, private ProductMapper $mapper, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionCreate(Request $request)
    {
        try {
            $requestMap = $this->mapper->loadDataFromRequest($request);




            return $requestMap;
        } catch (\Exception|\Error $error) {
             return $error->getMessage();
        }
    }
}