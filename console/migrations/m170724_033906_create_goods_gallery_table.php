<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_gallery`.
 */
class m170724_033906_create_goods_gallery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_gallery', [
            'id' => $this->primaryKey(),
            //            id	primaryKey
//            goods_id	int	商品id
            'goods_id'=>$this->integer(10)->comment('商品id'),
//            path	varchar(255)	图片地址
            'path'=>$this->string(255)->comment('图片地址')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_gallery');
    }
}
