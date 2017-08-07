<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\ReceivingAddress;
use frontend\models\Locations;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\captcha\CaptchaAction;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class MemberController extends \yii\web\Controller
{
    //public $layout = false;
    //关闭csrf验证
    public $enableCsrfValidation = false;
    //用户注册
    public function actionRegister()
    {
        $model = new Member();
        $model->scenario = Member::SCENARIO_REGISTER;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $code=\Yii::$app->session->get('code_'.$model->tel);
            if($code && $code==$model->smsCode){
                $model->save(false);
                \Yii::$app->session->offsetUnset('code_'.$model->tel);
                return $this->redirect(['member/index']);
            }else{
                $model->addError('smsCode','手机验证码错误');
            }

        }
        return $this->render('register',['model'=>$model]);
    }
    //登录
    public function actionLogin()
    {
        //1 认证(检查用户的账号和密码是否正确)
        $model = new LoginForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate() && $model->login()){
            //1.获取cookie中的购物车数据，
            $cookie=\Yii::$app->request->cookies->get('cart');
            if($cookie!=null){
                $carts=unserialize($cookie->value);
                //2.循环遍历购物车数据
                foreach($carts as $goods_id=>$amount){
                    //3.(使用goods_id作为查询条件，member_id)
                    $cart = Cart::findOne(['goods_id'=>$goods_id,'member_id'=>\Yii::$app->user->id]);
                    if($cart){
                        //4.如果数据表已经有这个商品,就合并cookie中的数量
                        $cart->amount=$cart->amount+$amount;
                        $cart->save(false);
                    }else{
                        //5.如果数据表没有这个商品,就添加这个商品到购物车表
                        $model=new Cart();
                        $model->member_id=\Yii::$app->user->identity['id'];
                        $model->goods_id=$goods_id;
                        $model->amount=$amount;
                        $model->save(false);
                    }
                }

                //6.同步完后，清空cookie购物车
                \Yii::$app->response->cookies->remove('cart');
            }
            //登录成功并把提示信息保存到session中并跳转首页
            \Yii::$app-> session->setFlash('success','登录成功');
            return $this->redirect(['/index.html']);
        }
        //展示登录页面
        return $this->render('login',['model'=>$model]);

    }
    //添加用户收货地址
    public function actionAddress()
    {
        $model=new ReceivingAddress();
        $request=\Yii::$app->request;
        //根据用户的id获取用户的收货地址
        $user_id=\Yii::$app->user->identity['id'];
        $models=ReceivingAddress::find()->where(['user_id'=>$user_id])->all();
        //var_dump($models);exit;
        if($model->load($request->post()) && $model->validate()){
            $model->user_id=$user_id;
            if($request->post('province'))$model->province=Locations::findOne(['id'=>$request->post('province')])->name;
            if($request->post('city'))$model->city=Locations::findOne(['id'=>$request->post('city')])->name;
            if($request->post('area'))$model->area=Locations::findOne(['id'=>$request->post('area')])->name;
            $status=$request->post('status');
            $model->status=isset($status)?1:0;
            $model->save(false);
            //添加成功将提示信息保存到session中并跳转收货页面
            \Yii::$app->session->setFlash('success',['地址添加成功']);
            return $this->redirect(['address']);
        }

        return $this->renderPartial('address',['model'=>$model,'models'=>$models]);
    }
    //三级联动获取数据
    public function actionLocations(){
        $pid=\Yii::$app->request->get('pid');
        $rows=Locations::find()->where(['=','parent_id',isset($pid)?$pid:0])->asArray()->all();
        echo json_encode($rows);
        //var_dump($rows);
    }
    //删除已条用户收货地址
    public function actionAddressDel($id){
        $model=ReceivingAddress::findOne(['id'=>$id]);
        if(!$model){
            throw new NotFoundHttpException('您删除的收货地址不存在');
        }
        $model->delete();
        //删除成功将提示信息保存到session中跳转用户信息页面
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['address']);
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    //定义验证码操作
    public function actions()
    {
        return [
            'captcha' => [
//                'class'=>'yii\captcha\CaptchaAction',
                'class' => CaptchaAction::className(),
                //
                'minLength' => 3,
                'maxLength' => 3,
            ]
        ];
    }
    public function actionUser(){
        return $this->renderPartial('address');
        //var_dump(\Yii::$app->user->isGuest);
    }
    //测试发送短信功能
    public function actionTestSms()
    {
        //$sms->setPhoneNumbers()->setSignName()->setTemplateCode()->send();
        $code = rand(0000,9999);
        $tel = \Yii::$app->request->get('tel');
        \Yii::$app->sms->setPhoneNumbers($tel)->setTemplateParam(['code'=>$code])->send();
        //将短信验证码保存redis（session，mysql）
        \Yii::$app->session->set('code_'.$tel,$code);

    }
    //用户注销
    public function actionLogout(){
        \Yii::$app->user->logout();
        //注销后跳转首页
        return $this->redirect(['/index.html']);
    }
    public function actionCheck(){
        $model=\Yii::$app->user->identity['id'];
        var_dump(\Yii::$app->user->isGuest.$model);
    }
    public function actionChecks(){
        $isGuest=\Yii::$app->user->isGuest;
        return Json::encode(['isGust'=>$isGuest,'identity'=>\Yii::$app->user->identity]);
    }
}
