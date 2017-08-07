<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Goods;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\NotFoundHttpException;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $request=new Request();
        //分页  总条数  每页显示条数 当前页
        $query=Goods::find()->where(['!=','status','0']);
        //#############搜索条件########################

            if($request->get('sn')){
                $query->andWhere(['like','sn',$request->get('sn')]);
            }
            if($request->get('name')){
                $query->andWhere(['like','name',$request->get('name')]);
            }
            if($request->get('price1')){
                $query->andWhere(['>=','shop_price',$request->get('price1')]);
            }
            if($request->get('price2')){
                $query->andWhere(['<=','shop_price',$request->get('price2')]);
            }


        //#######################################################
        //总条数
        $total=$query->orderBy('sort desc')->count();
        //每页显示条数
        $pageSize=6;
        //分页工具类
        $pager=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$pageSize
        ]);
        //取出数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    //添加一条商品信息
    public function actionAdd(){
        $time=date('Ymd');
        $good=new Goods();
        $goods_intro=new GoodsIntro();
        $request=new Request();
        if($request->isPost){
            $good_day_count = GoodsDayCount::findOne(['day' => $time]);
            //判断并保存商品信息
            if($good->load($request->post()) && $good->validate()) {
                //生成货号
                //状态默认为正常
                $good->status = 1;
                //判断当日是否存在
                if (!$good_day_count) {
                    $good->sn = date('Ymd') . sprintf("%06d", 1);
                } else {
                    $good->sn = date('Ymd') . sprintf("%06d", ($good_day_count->count) + 1);
                }
                $good->save();
            }else{
                //验证失败 打印错误信息
                var_dump($good->getErrors());exit;
            }
            //商品添加数
            if(!$good_day_count){
                $good_day_count=new GoodsDayCount();
                $good_day_count->day=$time;
            }
            //更新每天的商品添加数
             $good_day_count->count=($good_day_count->count)+1;
             $good_day_count->save();
            //判断并保存商品详情
            if($goods_intro->load($request->post()) && $goods_intro->validate()){
                $goods_intro->goods_id=$good->id;
                $goods_intro->save();
            }else{
                //验证失败 打印错误信息
                var_dump($goods_intro->getErrors());exit;
            }
            //添加成功保存提示信息到session中然后跳转首页
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['goods/index']);
        }
        //展示添加页面
        return $this->render('add',['good'=>$good,'goods_intro'=>$goods_intro]);
    }

    //修改商品信息
    public function actionEdit($id){
        $good=Goods::findOne(['id'=>$id]);
        $goods_intro=GoodsIntro::findOne(['goods_id'=>$id]);
        if($good==null){
            throw new NotFoundHttpException('该商品不存在');
        }
        $request=new Request();
        if($request->isPost){
            //判断并保存商品信息
            if($good->load($request->post()) && $good->validate()) {
                //生成货号
                $good->save();
            }else{
                //验证失败 打印错误信息
                var_dump($good->getErrors());exit;
            }
            //判断并保存商品详情
            if($goods_intro->load($request->post()) && $goods_intro->validate()){
                $goods_intro->save();
            }else{
                //验证失败 打印错误信息
                var_dump($goods_intro->getErrors());exit;
            }
            //添加成功保存提示信息到session中然后跳转首页
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['goods/index']);
        }
        //展示添加页面
        return $this->render('edit',['good'=>$good,'goods_intro'=>$goods_intro]);
    }
    //逻辑删除一条商品记录
    public function actionDelete($id){
        $good=Goods::findOne(['id'=>$id]);
        if($good==null){
            throw new NotFoundHttpException('该商品不存在');
        }
        //将状态修改为回收并保存
        $good->status=0;
        $good->save();
        //删除成功将信息保存到session中并跳转首页
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['goods/index']);
    }
    //商品详情
    public function actionContent($id){
        $model=Goods::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('该商品不存在');
        }
        return $this->render('content',['model'=>$model]);
    }
    /*
     * 商品相册
     */
    public function actionGallery($id)
    {
        $goods = Goods::findOne(['id'=>$id]);
        if($goods == null){
            throw new NotFoundHttpException('商品不存在');
        }


        return $this->render('gallery',['goods'=>$goods]);

    }

    /*
     * AJAX删除图片
     */
    public function actionDelGallery(){
        $id = \Yii::$app->request->post('id');
        $model = GoodsGallery::findOne(['id'=>$id]);
        if($model && $model->delete()){
            return 'success';
        }else{
            return 'fail';
        }

    }

    //回收站#############################################################
    public function actionBack(){
        //分页  总条数  每页显示条数 当前页
        $query=Goods::find();
        //总条数
        $total=$query->where(['=','status','0'])->count();
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
        $model=Goods::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('该商品不存在');
        }
        $model->delete();
        //添加成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('danger','清除成功');
        return $this->redirect(['goods/back']);
    }
    public function actionRecover($id){
        //根据id从回收恢复一条数据
        $model=Goods::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('该商品不存在');
        }
        //将状态修改为显示
        $model->status=1;
        //保存状态到数据库
        $model->save();
        //添加成功保存提示信息到session中然后跳转首页
        \Yii::$app->session->setFlash('success','恢复成功');
        return $this->redirect(['goods/back']);
    }
//回收站#############################################################

    //上传图片到七牛云and文本编辑器
    public function actions() {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://admin.yii2shop.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/{yyyy}{mm}{dd}/{time}{rand:6}" ,//上传保存路径
                    "imageRoot" => \Yii::getAlias("@webroot"),
                ],
            ],
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
                    $goods_id = \Yii::$app->request->post('goods_id');
                    if($goods_id){
                        $model = new GoodsGallery();
                        $model->goods_id = $goods_id;
                        $model->path = $action->getWebUrl();
                        $model->save();
                        $action->output['fileUrl'] = $model->path;
                        $action->output['id'] = $model->id;
                    }else{
                        $action->output['fileUrl'] = $action->getWebUrl();//输出文件的相对路径
                    }



//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"

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
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','add','edit','delete','back','recover','clean','content','gallery','del-gallery'],
            ]
        ];
    }
}
