<?php
namespace backend\models;

use yii\base\Model;

class Userupdate extends Model
{
    public $newpassword;
    public $surepassword;
    public $oldpassword;
    public function rules()
    {
        return [
            [['newpassword','surepassword','oldpassword'],'required','message'=>'{attribute}不能为空'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'newpassword'=>'新密码',
            'surepassword'=>'确认密码',
            'oldpassword'=>'旧密码'
        ];
    }
    public function update()
    {
//根据id找到一条用户信息
        $admin=Admin::findOne(['id'=>\Yii::$app->user->identity['id']]);
        //先判断确认密码手否正确
        if($this->newpassword==$this->surepassword){
            //新密码和旧密码不能一致
            if($this->oldpassword!=$this->newpassword){
                //再判断旧密码是否正确
                if(\Yii::$app->security->validatePassword($this->oldpassword,$admin->password_hash)){
                    //都正确则保存新密码到数据库
                    $admin->password_hash=\Yii::$app->security->generatePasswordHash($this->newpassword);
                    $admin->save(false);
                    return true;
                }else{
                    //密码错误.提示错误信息
                    $this->addError('oldpassword','旧密码错误');
                }
            }else{
                //密码错误.提示错误信息
                $this->addError('new。
                password','新密码与旧密码不能相同');
            }

        }else{
            //密码错误.提示错误信息
            $this->addError('surepassword','新密码与确认密码不一致');
        }

        return false;
    }

}