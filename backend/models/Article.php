<?php

namespace backend\models;

use frontend\models\Category;
use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $article_category_id
 * @property integer $sort
 * @property integer $status
 * @property integer $create_time
 */
class Article extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    //用一个静态属性来保存状态
    public static $status_all=[
        0=>'隐藏',
        1=>'显示'
    ];
    //建立文章和文章分类一对一关系
    public function getArticleCategory(){
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
    //建立文章和内容的一对一关系
    public function getArticleDetail(){
        return $this->hasOne(AricleDetail::className(),['article_id'=>'id']);
    }
    //定义一个静态方法获取文章分类列表
    public static function getCategoryAll(){
        return ArrayHelper::map(ArticleCategory::find()->all(),'id','name');
    }
    public static function tableName()
    {
        return 'article';
    }
    //附加行为
    public function behaviors()
    {
        return [
            'time'=>[
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT => 'create_time',
//                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','intro','article_category_id', 'sort'],'required','message'=>'{attribute}必填'],
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'status'], 'integer'],
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
            'article_category_id' => '文章分类',
            'sort' => '排序',
            'status' => '状态',
        ];
    }
}
