<?php

namespace backend\controllers;
use yii\data\Pagination;
use yii\web\UploadedFile;
use backend\models\Brand;
use yii\web\Request;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;
class BrandController extends \yii\web\Controller
{
    //项目需求http://note.youdao.com/share/?id=b92b75620dc24b08afc527a1612c84c7&type=note#/
    //品牌列表
    public function actionIndex()
    {
        //分页  总条数  每页显示条数 当前页
        $query=Brand::find();
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
        $brands=$query->limit($pager->limit)->offset($pager->offset)->all();
        //将数据传入页面并显示页面
        return $this->render('index',['brands'=>$brands,'pager'=>$pager]);
    }
    //添加新品牌
    public function actionAdd(){
        //实例化一个对象用来保存数据
        $brand=new Brand();
        $request=new Request();
        if ($request->isPost) {
            $brand->load($request->post());

            if ($brand->validate()) {
                $brand->save();//默认情况下 保存是会调用validate方法  有验证码是，需要关闭验证
                //添加成功保存提示信息到session中然后跳转首页
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/index']);
            } else {
                //验证失败 打印错误信息
                var_dump($brand->getErrors());
                exit;
            }

        }
        return $this->render('add',['brand'=>$brand]);
    }
//修改一条品牌信息
    public function actionEdit($id){
        //实例化一个对象用来保存数据
        $brand=Brand::findOne(['id'=>$id]);
        $request=new Request();
        if ($request->isPost) {
            $brand->load($request->post());
            if ($brand->validate()) {
                $brand->save();//默认情况下 保存是会调用validate方法  有验证码是，需要关闭验证
                //修改成功保存提示信息到session中然后跳转首页
                \Yii::$app->session->setFlash('info','修改成功');
                return $this->redirect(['brand/index']);
            } else {
                //验证失败 打印错误信息
                var_dump($brand->getErrors());
                exit;
            }

        }
        return $this->render('edit',['brand'=>$brand]);
    }
    //删除一条品牌信息
    public function actionDelete($id)
    {
        //根据id从数据库删除一条数据
        $model=Brand::findOne(['id'=>$id]);
        if($model){
            $model->status= -1;
            $model->save();
            //删除成功保存提示信息到session中然后跳转首页
            \Yii::$app->session->setFlash('success','删除成功');
        }
        return $this->redirect(['brand/index']);
    }
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,//如果文件已存在，是否覆盖
                /* 'format' => function (UploadAction $action) {
                     $fileext = $action->uploadfile->getExtension();
                     $filename = sha1_file($action->uploadfile->tempName);
                     return "{$filename}.{$fileext}";
                 },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },//文件的保存方式
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //$action->output['fileUrl'] = $action->getWebUrl();//输出文件的相对路径
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //将图片上传到七牛云
                    $qiniu = new Qiniu(\Yii::$app->params['qiniu']);
                    $qiniu->uploadFile(
                        $action->getSavePath(), $action->getWebUrl()
                    );
                    $url = $qiniu->getLink($action->getWebUrl());
                    $action->output['fileUrl']  = $url;
                },
            ],
            //文本编辑器
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
//                'config' => [
//                    "imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
//                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
//                "imageRoot" => Yii::getAlias("@webroot"),
//            ],
        ]
        ];

    }

//回收站#############################################################
    public function actionBack(){
        //分页  总条数  每页显示条数 当前页
        $query=Brand::find();
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
        Brand::deleteAll(['id'=>$id]);
        //添加成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('danger','清除成功');
        return $this->redirect(['brand/back']);
    }
    public function actionRecover($id){
        //根据id从回收恢复一条数据
        $model=Brand::findOne(['id'=>$id]);
        //将状态修改为显示
        $model->status=1;
        //保存状态到数据库
        $model->save();
        //添加成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('success','恢复成功');
        return $this->redirect(['brand/back']);
    }
//回收站#############################################################

}
