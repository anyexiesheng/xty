<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\PermissionFrom;
use backend\models\RoleForm;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class RbacController extends \yii\web\Controller
{
    //权限列表
    public function actionPermissionIndex()
    {
        //获取所有权限
        $models=\Yii::$app->authManager->getPermissions();
        //将数据分布到页面并展示
        return $this->render('permission-index',['models'=>$models]);
    }
    //添加权限
    public function actionPermissionAdd(){
        $model=new PermissionFrom(['scenario'=>PermissionFrom::SCENARIO_ADD]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager=\Yii::$app->authManager;
            $permission=$authManager->createPermission($model->name);//创建权限
            $permission->description=$model->description;
            $authManager->add($permission);//保存数据到数据库
            //添加成功保存提示信息到session并跳转到首页
            \Yii::$app->session->setFlash('success','权限添加成功');
            return $this->redirect(['permission-index']);
        }

        //展示添加页面
        return $this->render('permission-add',['model'=>$model]);
    }

    //修改权限
    public function actionPermissionEdit($name){
        //根据名称获取一条权限
        $authManage=\Yii::$app->authManager;
        $permission=$authManage->getPermission($name);
        if($permission==null){
            throw new NotFoundHttpException('该权限不存在');
        }
        //创建一个对象来保存数据
        $model=new PermissionFrom();
        if(\Yii::$app->request->isPost){
            if($model->load(\Yii::$app->request->post()) && $model->validate()){
                $permission->name=$model->name;
                $permission->description=$model->description;
                $authManage->update($name,$permission);
                \Yii::$app->session->setFlash('info','修改成功');
                return $this->redirect(['permission-index']);
            }
        }else{
            $model->name=$permission->name;
            $model->description=$permission->description;
        }

        //分配数据到修改页面并展示
        return $this->render('permission-add',['model'=>$model]);
    }
    //删除一个权限
    public function actionPermissionDelete($name){
        $authManage=\Yii::$app->authManager;
        $permission=$authManage->getPermission($name);
        if($permission==null){
            throw new NotFoundHttpException('该权限不存在');
        }
        $authManage->remove($permission);
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['permission-index']);
    }
//########################角色的的增删改查########################
    public function actionRoleAdd(){
        $model=new RoleForm(['scenario'=>RoleForm::SCENARIO_ADD]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager=\Yii::$app->authManager;
            $role=$authManager->createRole($model->name);
            $role->description=$model->description;
            $authManager->add($role);
            if(is_array($model->permission)){
                foreach ($model->permission as $permissionName){
                    $permission=$authManager->getPermission($permissionName);
                    if($permission){
                        $authManager->addChild($role,$permission);
                    }

                }
            }
            //添加成功保存提示信息到session中并跳转首页
            \Yii::$app->session->setFlash('success','角色添加成功');
            return $this->redirect(['role-index']);
        }
        return $this->render('role-add',['model'=>$model]);
    }
    public function actionRoleIndex(){
        //获取所有角色
        $models=\Yii::$app->authManager->getRoles();
        //将数据分布到页面并展示
        return $this->render('role-index',['models'=>$models]);
    }
    //角色的修改
    public function actionRoleEdit($name){
        $model = new RoleForm();
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        //再依次关联
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $role->description=$model->description;
            $authManager->update($name,$role);
            //全部取消关联
            $authManager->removeChildren($role);
            if(is_array($model->permission)){
                foreach ($model->permission as $permissionName){
                    $permission=$authManager->getPermission($permissionName);
                    if($authManager){
                        $authManager->addChild($role,$permission);
                    }

                }
            }
            //添加成功保存提示信息到session中并跳转首页
            \Yii::$app->session->setFlash('info','角色修改成功');
            return $this->redirect(['role-index']);
        }
        //获取角色的权限
        $permissions = $authManager->getPermissionsByRole($name);
        $model->name = $role->name;
        $model->description = $role->description;
        $model->permission = ArrayHelper::map($permissions,'name','name');

        return $this->render('role-add',['model'=>$model]);
    }
    //删除一个角色
    public function actionRoleDelete($name){
        $authManage=\Yii::$app->authManager;
        $role=$authManage->getRole($name);
        if($role==null){
            throw new NotFoundHttpException('该角色不存在');
        }
        $authManage->remove($role);
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['role-index']);
    }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['permission-index','permission-add','permission-edit','permission-delete','role-index','role-add','role-edit','role-delete'],
            ]
        ];
    }
}
