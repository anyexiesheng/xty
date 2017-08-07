<?php
namespace backend\models;

use yii\base\Model;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permission=[];
    const SCENARIO_ADD='add';

    public function rules(){
        return [
          [['name','description'],'required','message'=>'{attribute}必填'],
            ['permission','safe'],
            ['name','validateName','on'=>self::SCENARIO_ADD]
        ];
    }
    public function attributeLabels(){
        return [
          'name'=>'角色名称',
            'description'=>'角色描述',
            'permission'=>'最大权限'
        ];
    }
    public function validateName(){
        if(\Yii::$app->authManager->getRole($this->name)){
           return $this->addError('name','角色名称不能相同');
        }
    }
}