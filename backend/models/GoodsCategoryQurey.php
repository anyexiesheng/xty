<?php
namespace backend\models;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class GoodsCategoryQurey extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}