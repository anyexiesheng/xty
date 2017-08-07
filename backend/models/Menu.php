<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $prent_id
 * @property string $url
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name','required','message'=>'{attribute}必填'],
            [['sort'], 'integer','message'=>'{attribute}必须时整数'],
            [['name', 'url','prent_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名称',
            'prent_id' => '选择菜单分类',
            'url' => '菜单路由',
            'sort' => '排序',
        ];
    }
    //获取所有路由信息
    public static function getPermission(){
        return ArrayHelper::merge([' '=>'请选择路由'],ArrayHelper::map(Yii::$app->authManager->getPermissions(),'name','name'));
    }
    //查询出prent_id=0的顶级分类
    public static function getMenus(){
        return ArrayHelper::merge([' '=>'请选择分类'],['0'=>'顶级分类'],ArrayHelper::map(Menu::findAll(['prent_id'=>0]),'id','name') );
    }
    //上级菜单和下级菜单建立一对多关系
    public function getChildren(){
        return $this->hasMany(Menu::className(),['prent_id'=>'id']);
    }
}
