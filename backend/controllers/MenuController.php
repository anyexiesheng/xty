<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Menu;
use yii\web\NotFoundHttpException;

class MenuController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Menu::find()->where(['=','prent_id',0])->all();
        return $this->render('index',['models'=>$models]);
    }
    //添加一个菜单
    public function actionAdd(){
        $model=new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            //添加成功保存提示信息到session中并跳转首页
            \Yii::$app->session->setFlash('success','菜单添加成功');
            return $this->redirect(['menu/index']);
        }
        //展示添加页面
        return $this->render('add',['model'=>$model]);
    }
    //修改一个菜单
    public function actionEdit($id){
        //根据菜单id查出一条数据
        $model=Menu::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('菜单不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //预防修改到自己菜单下
            if($model->prent_id==$id){
                $model->addError('prent_id','不能将自己修改到自己菜单下');
            //预防出现三层菜单
            }elseif($model->prent_id && !empty($model->children)){
                $model->addError('prent_id','只能为顶级菜单');
            }else{
                $model->save();
                //修改成功后将提示信息保存到session中并跳转首页
                \Yii::$app->session->setFlash('info','菜单修改成功');

                  return $this->redirect(['menu/index']);
            }
        }
        //将数据分布到页面并展示
        return $this->render('edit',['model'=>$model]);
    }
    public function actionDelete($id){
        $model=Menu::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('菜单不存在');
        }
        $models=Menu::findOne(['prent_id'=>$model->id]);
        if($models){
            \Yii::$app->session->setFlash('danger','该菜单下有子菜单不能删除');
            return $this->redirect(['menu/index']);
        }
        $model->delete();
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['menu/index']);
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
