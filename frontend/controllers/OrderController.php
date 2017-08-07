<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\Goods;
use frontend\models\Order;
use frontend\models\OrderGoods;
use frontend\models\ReceivingAddress;
use yii\db\Exception;
use yii\filters\AccessControl;

class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    //ACF权限设置
    public function behaviors()
    {
        return [
            'ACF'=>[
                'class'=>AccessControl::className(),
                'only'=>['index','order'],//哪些操作需要使用该过滤器
                'rules'=>[
                    [
                        'allow'=>true,//是否允许
                        'actions'=>['index','order'],//指定操作
                        'roles'=>['@'],//指定角色 ?表示未认证用户(未登录) @表示已认证用户(已登录)
                    ],
                    [
//                        'allow'=>true,
//                        'actions'=>['index'],
                        //'roles'=>['?','@']
//                        'matchCallback'=>function(){
//                            //return (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->username=='admin');
//                            return !(date('d')%2);
//                        }
                    ],
                    //其他均禁止访问
                ]
            ]
        ];
    }
    //获取订单列表
    public function actionOrder(){
        $request=\Yii::$app->request;
        //1.开启事务功能
        $transaction = \Yii::$app->db->beginTransaction();
        if($request->post()){
            try{
                //接收ajax参数 收货地址id 运送方式id 支付方式id 订单加上运费的总金额
                //根据地址id查询出一条地址
                $address_id=$request->post('address');
                $address=ReceivingAddress::findOne(['id'=>$address_id]);
                //根据运送方式id获取所选运送方式信息
                $deliver_id=$request->post('delivery_id');
                $deliver=Order::$deliveries[$deliver_id];
                //根据支付方式获取所选的支付信息
                $payment_id=$request->post('payment_id');
                $payment=Order::$pays[$payment_id];//var_dump($payment_id);exit;
                $amounts=$request->post('amounts');
                //将数据保存到订单表中
                $order=new Order();
                $order->member_id=$address->user_id;
                $order->name=$address->consignee;
                $order->province=$address->province;
                $order->city=$address->city;
                $order->area=$address->area;
                $order->address=$address->detailed_address;
                $order->tel=$address->tel;
                $order->delivery_id=$address_id;
                $order->delivery_name=$deliver['name'];
                $order->delivery_price=$deliver['price'];
                $order->payment_id=$payment_id;
                $order->payment_name=$payment['name'];
                $order->total=$amounts;
                $order->status=1;//订单状态（0已取消1待付款2待发货3待收货4完成）
                $order->create_time=time();
                $order->save();
                //遍历循环生成订单详情
                //获取购物车的商品数据
                $data=Order::getCart();
                foreach($data['models'] as $model){
                    $good=Goods::findOne(['id'=>$model['id']]);
                    //2.判断库存是否大于购买数 否则抛出错误信息
                    if($good->stock >= $data['carts'][$model['id']]){
                        $order_goods=new OrderGoods();
                        $order_goods->member_id=\Yii::$app->user->id;
                        $order_goods->order_id=$order->id;
                        $order_goods->goods_id=$model['id'];
                        $order_goods->goods_name=$model['name'];
                        $order_goods->logo=$model['logo'];
                        $order_goods->price=$model['shop_price'];
                        $order_goods->amount=$data['carts'][$model['id']];
                        $order_goods->total=$data['carts'][$model['id']]*$model['shop_price'];
                        $order_goods->save();
                        //3.更新商品数据表库存
                        $good->stock=$good->stock - $data['carts'][$model['id']];
                        $good->save();
                    }else{
                        throw new Exception('商品库存不足，无法继续下单，请修改购物车商品数量');
                    }
                }
                //4.订单保存成功后清除购物车
                Cart::deleteAll(['member_id'=>\Yii::$app->user->identity['id']]);
                //提交事务
                $transaction->commit();
                return $this->redirect('over');
            }catch (Exception $e){
                //回滚
                $transaction->rollBack();
            };
        }
        return $this->render('order');

    }
    //完成订单
    public function actionOver(){
        return $this->render('over');
    }
    //订单列表
    public function actionIndex(){
        $models=OrderGoods::find()->where(['member_id'=>\Yii::$app->user->identity['id']])->all();
        return $this->render('index',['models'=>$models]);
    }
    //删除一条订单
    public function actionDelete(){

    }
}
