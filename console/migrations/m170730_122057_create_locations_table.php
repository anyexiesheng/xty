<?php

use yii\db\Migration;

/**
 * Handles the creation of table `locations`.
 */
class m170730_122057_create_locations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('locations', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30),
            'parent_id'=>$this->integer(10),
            'level'=>$this->integer(10),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('locations');
    }
}
