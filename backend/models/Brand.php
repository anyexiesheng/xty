<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */

class Brand extends \yii\db\ActiveRecord
{
//    public $filelogo;//用一个属性来保存上传文件
    public static $status_all=[
      0=>'隐藏',
        1=>'显示',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro','sort','name'],'required','message'=>'{attribute}必填'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
//            // skipOnEmpty 为空跳过该验证
//            ['filelogo','file','extensions'=>['jpg','png','gif']/*,'skipOnEmpty'=>false*/],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            'sort' => '排序',
            'status' => '状态',
            'logo'=>'上传图片'
        ];
    }
}
