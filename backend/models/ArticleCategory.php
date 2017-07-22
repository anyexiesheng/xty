<?php
namespace backend\models;

use yii\db\ActiveRecord;

class ArticleCategory extends ActiveRecord{
    /**
     * @inheritdoc
     */
    public static $status_all=[
        0=>'隐藏',
        1=>'显示',
    ];
    public static function tableName()
    {
        return 'article_category';
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
        ];
    }
}