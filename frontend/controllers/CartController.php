<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\Goods;
use frontend\models\Order;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class CartController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
    //添加到购物车成功页面
    public function actionAddToCart($goods_id,$amount)
    {
        //未登录
        if(\Yii::$app->user->isGuest){
            //商品id  商品数量
            //如果没有登录就存放在cookie中
            $cookies = \Yii::$app->request->cookies;
            //获取cookie中的购物车数据
            $cart = $cookies->get('cart');
            if($cart==null){
                $carts = [$goods_id=>$amount];
            }else{
                $carts = unserialize($cart->value);//[1=>99，2=》1]
                if(isset($carts[$goods_id])){
                    //购物车中已经有该商品，数量累加
                    $carts[$goods_id] += $amount;
                }else{
                    //购物车中没有该商品
                    $carts[$goods_id] = $amount;
                }
            }

            //将商品id和商品数量写入cookie
            $cookies = \Yii::$app->response->cookies;
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>serialize($carts),
                'expire'=>7*24*3600+time()
            ]);
            $cookies->add($cookie);
        }else{
            //用户已登录，操作购物车数据表
            $model=Cart::findOne(['member_id'=>\Yii::$app->user->identity['id'],'goods_id'=>$goods_id]);
            if($model){
                $model->amount=$amount+$model->amount;
            }else{
                $model=new Cart();
                $model->member_id=\Yii::$app->user->identity['id'];
                $model->goods_id=$goods_id;
                $model->amount=$amount;
            }
            $model->save();
        }

        return $this->redirect(['cart']);
    }

    //购物车页面
    public function actionCart()
    {
        $this->layout = false;
        //1 用户未登录，购物车数据从cookie取出
        if(\Yii::$app->user->isGuest){
            $cookies = \Yii::$app->request->cookies;
            //var_dump(unserialize($cookies->getValue('cart')));
            $cart = $cookies->get('cart');
            if($cart==null){
                $carts = [];
            }else{
                $carts = unserialize($cart->value);
            }
            //$carts=[1=>99,2=>1]   []    =>array_keys($carts)  => [1,2]
            //获取商品数据
            $models = Goods::find()->where(['in','id',array_keys($carts)])->asArray()->all();
            //var_dump(array_keys($carts));exit;
        }else{
            //2 用户已登录，购物车数据从数据表取
            $carts=Order::getCart()['carts'];
            $models=Order::getCart()['models'];
        }

        return $this->render('cart',['models'=>$models,'carts'=>$carts]);
    }

    //修改购物车数据
    public function actionAjaxCart()
    {
        $goods_id = \Yii::$app->request->post('goods_id');
        $amount = \Yii::$app->request->post('amount');
        //数据验证

        if(\Yii::$app->user->isGuest){
            $cookies = \Yii::$app->request->cookies;
            //获取cookie中的购物车数据
            $cart = $cookies->get('cart');
            if($cart==null){
                $carts = [$goods_id=>$amount];
            }else{
                $carts = unserialize($cart->value);//[1=>99，2=》1]
                if(isset($carts[$goods_id])){
                    //购物车中已经有该商品，更新数量
                    $carts[$goods_id] = $amount;
                }else{
                    //购物车中没有该商品
                    $carts[$goods_id] = $amount;
                }
            }
            //将商品id和商品数量写入cookie
            $cookies = \Yii::$app->response->cookies;
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>serialize($carts),
                'expire'=>7*24*3600+time()
            ]);
            $cookies->add($cookie);
            return 'success';
        }else{
            //登录状态
            $cart_one=Cart::findOne(['member_id'=>\Yii::$app->user->identity['id'],'goods_id'=>$goods_id]);
            if($cart_one){
                $cart_one->amount=$amount;
                $cart_one->save();
            }
        }
    }
    //删除
    public function actionDelete($goods_id){
        //$goods_id=\Yii::$app->request->post('goods_id');
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies->get('cart');
            //$carts=[$goods_id=>$amount];//[1=>2,2=>5]
            $cart=unserialize($cookies->value);
            unset($cart[$goods_id]);
//            //var_dump($carts);ex
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>serialize($cart),
                'expire'=>7*24*3600+time()
            ]);
            $cookiess=\Yii::$app->response->cookies;
            $cookiess->add($cookie);

        }else{

            $model=Cart::findOne(['member_id'=>\Yii::$app->user->identity['id'],'goods_id'=>$goods_id]);
            if(!$model){
                throw new NotFoundHttpException('Sorry!您要删除的商品不存在');
            }
            $model->delete();
        }
        return json_encode(['status'=>'success','msg'=>'成功']);

    }

}
