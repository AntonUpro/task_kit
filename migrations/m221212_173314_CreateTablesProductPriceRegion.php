<?php

use yii\db\Migration;

/**
 * Class m221212_173314_CreateTablesProductPriceRegion
 */
class m221212_173314_CreateTablesProductPriceRegion extends Migration
{
    const TABLE_REGION = 'region';
    const TABLE_PRODUCT = 'product';
    const TABLE_PRICE = 'price';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_REGION, [
            'id' => $this->primaryKey(),
            'region' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->defaultValue('NOW()'),
            'updated_at' => $this->dateTime()->defaultValue('NOW()')
        ]);

        $this->createTable(self::TABLE_PRODUCT, [
            'id' => $this->primaryKey(),
            'product' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->defaultValue('NOW()'),
            'updated_at' => $this->dateTime()->defaultValue('NOW()')
        ]);

        $this->createIndex('idx_table_product_id', self::TABLE_PRODUCT, 'id');

        $this->createTable(self::TABLE_PRICE, [
            'id' => $this->primaryKey(),
            'id_region' => $this->integer()->notNull(),
            'id_product' => $this->integer()->notNull(),
            'price_purchase' => $this->float(2)->notNull(),
            'price_selling' => $this->float(2)->notNull(),
            'price_discount' => $this->float(2)->notNull(),
            'created_at' => $this->dateTime()->defaultValue('NOW()'),
            'updated_at' => $this->dateTime()->defaultValue('NOW()')
        ]);

        $this->createIndex('idx_table_price_id_product', self::TABLE_PRICE, 'id_product');

        $this->addForeignKey(
            'FK_price_region',
            self::TABLE_PRICE,
            'id_region',
            self::TABLE_REGION,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'FK_price_product',
            self::TABLE_PRICE,
            'id_product',
            self::TABLE_PRODUCT,
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_price_product', self::TABLE_PRICE);
        $this->dropForeignKey('FK_price_region', self::TABLE_PRICE);
        $this->dropIndex('idx_table_price_id_product', self::TABLE_PRICE);
        $this->dropTable(self::TABLE_PRICE);
        $this->dropIndex('idx_table_product_id', self::TABLE_PRODUCT);
        $this->dropTable(self::TABLE_PRODUCT);
        $this->dropTable(self::TABLE_REGION);
    }
}
