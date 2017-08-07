<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_REGISTER = 'register';

    public $code;//图像验证码
    public $smsCode;//短信验证码
    public $password;//密码
    public $rePassword;//确认密码
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','tel','email'], 'required','message'=>'{attribute}必填'],
            [['code','password','rePassword','smsCode'], 'required','on'=>self::SCENARIO_REGISTER,'message'=>'{attribute}必填'],

            //验证码验证规则
            ['code', 'captcha', 'captchaAction' => 'member/captcha','message'=>'验证码错误'],
            [['last_login_time', 'last_login_ip', 'status', 'create_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
            ['email','email','on'=>self::SCENARIO_REGISTER,'message'=>'邮箱格式不正确'],
            [['password_hash', 'email'], 'string', 'max' => 100],
            [['username','tel','email'], 'unique','on'=>self::SCENARIO_REGISTER,'message'=>'{attribute}已被使用,请重新输入'],
            [['tel'], 'number', 'numberPattern' =>'/^1[3578]\d{9}$/','message'=>'手机号码格式不正确'],
            ['rePassword','compare','compareAttribute'=>'password','on'=>self::SCENARIO_REGISTER,'message'=>'密码必须和确认密码一致'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'email' => '邮箱',
            'tel' => '手机号',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录ip',
            'status' => 'status',
            'create_at' => '添加时间',
            'updated_at' => '修改时间',
            'code'=>'验证码',
            'rePassword'=>'确认密码',
            'password'=>'密码',
            'smsCode'=>'短信验证'
        ];
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->create_at = time();
            $this->status = 1;
        }else{
            $this->updated_at = time();
        }
        if($this->password){
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->auth_key==$authKey;
    }
}
