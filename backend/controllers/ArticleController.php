<?php

namespace backend\controllers;

use backend\models\AricleDetail;
use backend\models\Article;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\data\Pagination;
class ArticleController extends \yii\web\Controller
{
    //public $enableCsrfValidation = false;
    //文章详情列表
    public function actionIndex()
    {
        $request=new Request();

        //分页  总条数  每页显示条数 当前页
        $query=Article::find()->where(['!=','status','-1']);
        //总条数
        if($request->get('sou')){
            $query->andWhere(['like','name',$request->get('sou')]);
        }
        $total=$query->orderBy('sort desc')->count();
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
        return $this->render('index', ['models' => $models,'pager'=>$pager]);

    }
    //获取文章内容
    public function actionContent($id){
        $model=AricleDetail::findOne($id);
        return $this->render('content',['model'=>$model]);
    }
    //文章详情添加
    public function actionAdd()
    {
        //实例化一个文章对象
        $article = new Article();
        //实例化一个文章内容对象
        $article_detail = new AricleDetail();
        //实例化一个请求方式对象
        $request = new Request();
        if ($request->isPost) {
            //加载文章
            $article->load($request->post());
            //加载内容
            $article_detail->load($request->post());
            //验证数据
            if ($article->validate() && $article_detail->validate()) {
                //保存文章
                $article->save();
                //取出文章id赋值给内容id
                $article_detail->article_id = $article->id;
                //保存内容并跳转首页
                $article_detail->save();
                //添加成功保存提示信息到session中然后跳转首页
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            } else {
                //验证失败 打印错误信息
                $errors=$article->getErrors()?$article->getErrors():$article_detail->getErrors();
                var_dump($errors);
                exit;
            }
        }
        //传入数据到页面并展示
        return $this->render('add', ['article' => $article, 'article_detail' => $article_detail]);
    }
    //文章详情修改
    public function actionEdit($id){
        //实例化一个文章对象
        $article =Article::findOne(['id'=>$id]);
        if($article==null){
            throw new NotFoundHttpException('该文章不存在');
        }
        //实例化一个文章内容对象
        $article_detail =AricleDetail::findOne(['article_id'=>$id]);
        //实例化一个请求方式对象
        $request = new Request();
        if ($request->isPost) {
            //加载文章
            $article->load($request->post());
            //加载内容
            $article_detail->load($request->post());
            //验证数据
            if ($article->validate() && $article_detail->validate()) {
                //保存文章
                $article->save();
                //取出文章id赋值给内容id
                $article_detail->article_id = $article->id;
                //保存内容并跳转首页
                $article_detail->save();
                //修改成功保存提示信息到session中然后跳转首页
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article/index']);
            } else {
                //验证失败 打印错误信息
                $errors=$article->getErrors()?$article->getErrors():$article_detail->getErrors();
                var_dump($errors);
                exit;
            }
        }
        //传入数据到页面并展示
        return $this->render('edit', ['article' => $article, 'article_detail' => $article_detail]);
    }
    //逻辑删除
    public function actionDelete($id){
        //根据id从文章数据表中获取一条数据
        $model =Article::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('该文章不存在');
        }
        //修改状态为删除
        $model->status=-1;
        //保存
        $model->save();
        //删除成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['article/index']);
    }
//回收站#############################################################
    public function actionBack(){
        //分页  总条数  每页显示条数 当前页
        $query=Article::find();
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
        $model =Article::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('该文章不存在');
        }
        $model->delete();
        //删除成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('success','清除成功');
        return $this->redirect(['article/back']);
    }
    public function actionRecover($id){
        //根据id从回收恢复一条数据
        $model =Article::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('该文章不存在');
        }
        //将状态修改为显示
        $model->status=1;
        //保存状态到数据库
        $model->save();
        //恢复成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('success','恢复成功');
        return $this->redirect(['article/back']);
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