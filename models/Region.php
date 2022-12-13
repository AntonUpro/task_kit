<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string $region
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Price[] $prices
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['region'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region' => 'Region',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Prices]].
     *
     * @return \yii\db\ActiveQuery|PriceQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::class, ['id_region' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegionQuery(get_called_class());
    }
}
