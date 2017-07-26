<?php
namespace backend\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $code;
    public $username;
    public $password;
    public $rember;
    public function rules()
    {
        return [
            [['username','password'],'required','message'=>'{attribute}不能为空'],
            [['rember'],'boolean'],
            ['code','captcha','captchaAction'=>'admin/captcha','message'=>'验证码错误']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码'
        ];
    }
    public function login()
    {
        //1.1 通过用户名查找用户
        $admin = Admin::findOne(['username'=>$this->username,'status'=>1]);
        if($admin){
            //用户存在
            //1.2 对比用户密码
            //没有加密 $admin->password == $model->password ,可能会被开除
            //md5 加密 $admin->password == md5($model->password)
            //yii2框架密码加密
            //密码加密
            //$password_hash = \Yii::$app->security->generatePasswordHash('明文密码');
            //验证密码
            //$result = \Yii::$app->security->validatePassword('明文密码','密文');
            if(\Yii::$app->security->validatePassword($this->password,$admin->password_hash)){
                //密码正确.可以登录
                //2 登录(保存用户信息到session)
                \Yii::$app->user->login($admin,$this->rember?3600*24:0);
                //将登录时间和IP保存到数据库
                $admin->last_login_ip=\Yii::$app->request->getUserIP();
                $admin->last_login_time=time();
                $admin->save(false);
                return true;
            }else{
                //密码错误.提示错误信息
                $this->addError('password','密码错误');
            }

        }else{
            //用户不存在,提示 用户不存在 错误信息
            $this->addError('username','用户名不存在或已被禁用');
        }
        return false;
    }

}