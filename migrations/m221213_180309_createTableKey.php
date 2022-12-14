<?php

use yii\db\Migration;

/**
 * Class m221213_180309_createTableKey
 */
class m221213_180309_createTableKey extends Migration
{
    private const TABLE_KEY = 'key';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_KEY, [
            'id' => $this->primaryKey(),
            'hash_key' => $this->string()->notNull()->unique()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_KEY);
    }


}
