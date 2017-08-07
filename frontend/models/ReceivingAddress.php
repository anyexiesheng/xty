<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "receiving_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $consignee
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $detailed_address
 * @property string $tel
 * @property integer $status
 */
class ReceivingAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'receiving_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['consignee', 'province', 'city', 'area'], 'string', 'max' => 20],
            [['detailed_address'], 'string', 'max' => 50],
            [['tel'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'consignee' => '收货人',
            'province' => '省份',
            'city' => '城市',
            'area' => '地区',
            'detailed_address' => '详细地址',
            'tel' => '手机号码',
            'status' => '设为默认地址',
        ];
    }
}
