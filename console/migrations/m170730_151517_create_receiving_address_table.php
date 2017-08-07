<?php

use yii\db\Migration;

/**
 * Handles the creation of table `receiving_address`.
 */
class m170730_151517_create_receiving_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('receiving_address', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(10)->comment('用户id'),
            'consignee'=>$this->string(20)->comment('收货人'),
            'province'=>$this->string(20)->comment('省份'),
            'city'=>$this->string(20)->comment('城市'),
            'area'=>$this->string(20)->comment('地区'),
            'detailed_address'=>$this->string(50)->comment('详细地址'),
            'tel'=>$this->string(11)->comment('手机号码'),
            'status'=>$this->integer(2)->comment('状态')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('receiving_address');
    }
}
