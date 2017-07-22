<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_detail".
 *
 * @property integer $article_id
 * @property string $content
 */
class AricleDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    //建立文章和内容的一对一关系
    public function getArticle(){
        return $this->hasOne(Article::className(),['id'=>'article_id']);
    }
    public static function tableName()
    {
        return 'article_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'],'required','message'=>'{attribute}必填'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content' => '文章内容',
        ];
    }
}
