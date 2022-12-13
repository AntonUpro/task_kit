<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property int $id_region
 * @property int $id_product
 * @property float $price_purchase
 * @property float $price_selling
 * @property float $price_discount
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Product $product
 * @property Region $region
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_region', 'id_product', 'price_purchase', 'price_selling', 'price_discount'], 'required'],
            [['id_region', 'id_product'], 'default', 'value' => null],
            [['id_region', 'id_product'], 'integer'],
            [['price_purchase', 'price_selling', 'price_discount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['id_product' => 'id']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['id_region' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_region' => 'Id Region',
            'id_product' => 'Id Product',
            'price_purchase' => 'Price Purchase',
            'price_selling' => 'Price Selling',
            'price_discount' => 'Price Discount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'id_product']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery|RegionQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'id_region']);
    }

    /**
     * {@inheritdoc}
     * @return PriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PriceQuery(get_called_class());
    }
}
