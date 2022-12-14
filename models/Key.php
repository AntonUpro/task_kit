<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "key".
 *
 * @property int $id
 * @property string $hash_key
 */
class Key extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hash_key'], 'required'],
            [['hash_key'], 'string', 'max' => 255],
            [['hash_key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash_key' => 'Hash Key',
        ];
    }

    /**
     * {@inheritdoc}
     * @return KeyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KeyQuery(get_called_class());
    }
}
