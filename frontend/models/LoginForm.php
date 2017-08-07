<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class LoginForm extends ActiveRecord
{
    public $code;
    public $username;
    public $password;
    public $rember;
    public function rules()
    {
        return [
            [['username','password','code'],'required','message'=>'{attribute}不能为空'],
            [['rember'],'boolean'],
            ['code','captcha','captchaAction'=>'member/captcha','message'=>'验证码错误']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'code'=>'验证码',
            'rember'=>'记住我'
        ];
    }
    public function login()
    {
        //1.1 通过用户名查找用户
        $member = Member::findOne(['username'=>$this->username]);
        if($member){
            //$result = \Yii::$app->security->validatePassword('明文密码','密文');
            if(\Yii::$app->security->validatePassword($this->password,$member->password_hash)){
                //密码正确.可以登录
                //2 登录(保存用户信息到session)
                \Yii::$app->user->login($member,$this->rember?3600*24:0);
                //将登录时间和IP保存到数据库
                $member->last_login_ip=\Yii::$app->request->getUserIP();
                $member->last_login_time=time();
                $member->save(false);
                return true;
            }else{
                //密码错误.提示错误信息
                $this->addError('password','密码错误');
            }

        }else{
            //用户不存在,提示 用户不存在 错误信息
            $this->addError('username','用户名不存在');
        }
        return false;
    }

}