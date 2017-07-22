<?php

namespace backend\controllers;
use yii\data\Pagination;
use backend\models\ArticleCategory;
use yii\web\Request;
class ArticleCategoryController extends \yii\web\Controller
{
    //项目需求http://note.youdao.com/share/?id=b92b75620dc24b08afc527a1612c84c7&type=note#/
    //文章分类列表
    public function actionIndex()
    {
        //分页  总条数  每页显示条数 当前页
        $query=ArticleCategory::find();
        //总条数
        $total=$query->where(['!=','status','-1'])->orderBy('sort desc')->count();
        //每页显示条数
        $pageSize=3;
        //分页工具类
        $pager=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$pageSize
        ]);
        //取出数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //将数据传入页面并显示页面
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    //添加新文章分类
    public function actionAdd(){
        //实例化一个对象用来保存数据
        $model=new ArticleCategory();
        $request=new Request();
        if ($request->isPost) {
            $model->load($request->post());
            //验证数据
            if ($model->validate()) {

                $model->save(false);//默认情况下 保存是会调用validate方法  有验证码是，需要关闭验证
                //添加成功保存提示信息到session中然后跳转首页
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article-category/index']);
            } else {
                //验证失败 打印错误信息
                var_dump($model->getErrors());
                exit;
            }

        }
        return $this->render('add',['model'=>$model]);
    }
//修改一条文章分类信息
    public function actionEdit($id){
        //实例化一个对象用来保存数据
        $model=ArticleCategory::findOne(['id'=>$id]);
        $request=new Request();
        if ($request->isPost) {
            $model->load($request->post());
            //验证数据
            if ($model->validate()) {
                $model->save(false);//默认情况下 保存是会调用validate方法  有验证码是，需要关闭验证
                //修改成功保存提示信息到session中然后跳转首页
                \Yii::$app->session->setFlash('info','修改成功');
                return $this->redirect(['article-category/index']);
            } else {
                //验证失败 打印错误信息
                var_dump($model->getErrors());
                exit;
            }

        }
        return $this->render('edit',['model'=>$model]);
    }
    //删除一条文章分类信息
    public function actionDelete($id)
    {
        //根据id从数据库删除一条数据
        $model=ArticleCategory::findOne(['id'=>$id]);
        //将状态修改为删除
        $model->status=-1;
        //保存状态到数据库
        $model->save();
        //删除成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['article-category/index']);
    }
//回收站#############################################################
    public function actionBack(){
        //分页  总条数  每页显示条数 当前页
        $query=ArticleCategory::find();
        //总条数
        $total=$query->where(['=','status','-1'])->count();
        //每页显示条数
        $pageSize=15;
        //分页工具类
        $pager=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$pageSize
        ]);
        //取出数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //传输数据并展示回收站页面
        return $this->render('back',['models'=>$models,'pager'=>$pager]);
    }
    public function actionClean($id){
    //根据id从数据库清除一条数据
        ArticleCategory::deleteAll(['id'=>$id]);
        //清除成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('success','清除成功');
        return $this->redirect(['article-category/back']);
    }
    public function actionRecover($id){
    //根据id从回收恢复一条数据
        $model=ArticleCategory::findOne(['id'=>$id]);
        //将状态修改为显示
        $model->status=1;
        //保存状态到数据库
        $model->save();
        //清除成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('info','恢复成功');
        return $this->redirect(['article-category/back']);
    }
//回收站#############################################################
//文本编辑器
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
//                'config' => [
//                    "imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
//                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" ,//上传保存路径
//                "imageRoot" => Yii::getAlias("@webroot"),
//            ],
            ]
        ];
    }
}
