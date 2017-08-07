<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Admin;
use backend\models\LoginForm;
use backend\models\Userupdate;
use yii\captcha\CaptchaAction;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AdminController extends \yii\web\Controller
{
    //用户列表
    public function actionIndex()
    {
        //分页 总条数 每页条数 当前页码
        $query=Admin::find();
        //总条数
        $total=$query->where(['!=','status','0'])->count();
        //每页显示条数
        $pageSize=10;
        //当前页码
        $pager=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$pageSize
        ]);
        $models=$query->limit($pager->limit)->offset($pager->offset)->select(['id','username','email','last_login_time','last_login_ip'])->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    //新添加一个管理员
    public function actionAdd(){
        $model = new Admin();
        $model->scenario=Admin::SCENARIO_ADD;//指定场景
        if($model->load(\Yii::$app->request->post()) && $model->validate() ){
            //验证数据
            $model->save(false);//默认情况下 保存是会调用validate方法  有验证码是，需要关闭验证
            $authManager=\Yii::$app->authManager;

            if(is_array($model->role)){
                foreach ($model->role as $roleName){
                    $role=$authManager->getRole($roleName);
                    if($role){
                        //var_dump($model->id);exit;
                        $authManager->assign($role,$model->id);
                    }

                }
            }
            //添加成功保存提示信息到session中并跳转首页
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['admin/index']);
        }
        return $this->render('add', ['model' => $model]);
    }
    //修改一条管理员信息
    public function actionEdit($id){
        $model =Admin::findOne(['id'=>$id]);
        $authManager=\Yii::$app->authManager;
        if($model->load(\Yii::$app->request->post()) && $model->validate() ){
            //验证数据
            $model->save(false);//默认情况下 保存是会调用validate方法  有验证码是，需要关闭验证
            //全部取消关联
            $authManager->revokeAll($id);
            if(is_array($model->role)){
                foreach ($model->role as $roleName){
                    $role=$authManager->getRole($roleName);
                    if($role){
                        //var_dump($model->id);exit;
                        $authManager->assign($role,$model->id);
                    }

                }
            }
            //添加成功保存提示信息到session中并跳转首页
            \Yii::$app->session->setFlash('info','修改成功');
            return $this->redirect(['admin/index']);
        }
        //获取角色
        $roles = $authManager->getAssignments($id);
        //var_dump($roles);exit;
        $model->role = ArrayHelper::map($roles,'roleName','roleName');
        return $this->render('add', ['model' => $model]);
    }
    //禁用一位用户
    public function actionDelete($id ){
        //根据id查询出一条信息  存在就修改状态为禁用 不存在则抛出一个错误提示
        $model=Admin::findOne($id);
        if($model==null){
            throw new NotFoundHttpException('该用户不存在');
        }
        $model->status=0;
        $model->save(false);
        //禁用成功后将提示信息保存到session中
        \Yii::$app->session->setFlash('danger','禁用成功');
        return $this->redirect(['admin/index']);
    }
    //登录
    public function actionLogin()
    {
        //1 认证(检查用户的账号和密码是否正确)
        $model = new LoginForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate() && $model->login()){
            //登录成功并把提示信息保存到session中并跳转首页
            \Yii::$app-> session->setFlash('success','登录成功');
            return $this->redirect(['admin/index']);
        }
        //展示登录页面
        return $this->render('login',['model'=>$model]);
    }
    //用户修改个人密码
    public function actionUserupdate(){

        $model=new Userupdate();


        if($model->load(\Yii::$app->request->post()) && $model->validate() && $model->update()){
            //修改密码后退出登录并跳转登录页面 提示信息保存到session中并跳转首页
            \Yii::$app->user->logout();
            \Yii::$app->session->setFlash('info','密码修改成功请重新登录');
            return $this->redirect(['admin/login']);
        }
        return $this->render('userupdate',['model'=>$model]);
    }
    //注销
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','退出成功');
        return $this->redirect(['admin/login']);
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
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','add','edit','delete'],
            ]
        ];
    }
}
