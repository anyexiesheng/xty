<?php
namespace frontend\models;



use backend\models\Brand;
use yii\db\ActiveRecord;

class Goods extends ActiveRecord{


    public function getGallery(){
        return $this->hasMany(\backend\models\GoodsGallery::className(),['goods_id'=>'id']);
    }
    public function getContents(){
        return $this->hasOne(\backend\models\GoodsIntro::className(),['goods_id'=>'id']);
    }
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }

}