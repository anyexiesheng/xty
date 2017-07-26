<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170724_034153_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
//            username	varchar	255
        'username'=>$this->string(255),
//            auth_key	varchar	32
        'auth_key'=>$this->string(32),
//            password_hash	varchar
        'password_hash'=>$this->string(255),
//            password_reset_token	varchar	255
        'password_reset_token'=>$this->string(255),
//            email	varchar	255
        'email'=>$this->string(255),
//            status	smallint
        'status'=>$this->smallInteger(2),
//            created_at	int	11
        'created_at'=>$this->integer(11),
//            updated_at	int	11
        'update_at'=>$this->integer(11),
//             last_login_time,
        'last_login_time'=>$this->integer(11)->comment('最后登录时间'),
//              last_login_ip
        'last_login_ip'=>$this->string(50)

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
