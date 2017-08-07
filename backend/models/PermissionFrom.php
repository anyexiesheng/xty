<?php
namespace backend\models;

use yii\base\Model;

class PermissionFrom extends Model{
    public $name;//权限名称
    public $description;//权限简介
    const SCENARIO_ADD='add';

    public function rules(){
        return[
            [['name','description'],'required','message'=>'{attribute}必填'],
            ['name','validateName','on'=>self::SCENARIO_ADD],
        ];
    }
    public function attributeLabels(){
        return [
            'name'=>'权限名称（路由）',
            'description'=>'权限描述',
            ];
    }
    //验证权限名称是否重名
    public function validateName(){
        if(\Yii::$app->authManager->getPermission($this->name)){
            return $this->addError('name','该权限已存在');
        }
    }

}