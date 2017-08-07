<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170728_035404_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('菜单名称'),
            'prent_id'=>$this->integer(10)->comment('上级菜单'),
            'url'=>$this->string(50)->comment('菜单路由'),
            'sort'=>$this->integer(10)->comment('排序'),
            'deep'=>$this->integer(10)->comment('深度')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
