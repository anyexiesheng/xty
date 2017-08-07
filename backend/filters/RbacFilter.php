<?php
namespace backend\filters;

use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class RbacFilter extends ActionFilter{
    public function beforeAction($action)
    {
        //没有登录直接跳转登录
        if(\Yii::$app->user->isGuest){
            return $action->controller->redirect(\Yii::$app->user->loginUrl)->send();
        }
        // 路由
        if(!\Yii::$app->user->can($action->uniqueId)){
            throw new ForbiddenHttpException('对不起，您没有该执行权限');
        }
        //允许
        return parent::beforeAction($action);
    }
}