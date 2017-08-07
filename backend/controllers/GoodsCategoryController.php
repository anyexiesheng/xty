<?php

namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\GoodsCategory;
use yii\db\Exception;
use yii\web\HttpException;
use yii\web\Request;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
class GoodsCategoryController extends \yii\web\Controller
{
    //添加商品分类（ztree选择上级分类id）
    public function actionAdd()
    {
        $model = new GoodsCategory(['parent_id'=>0]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $models=GoodsCategory::find()->where(['parent_id'=>$model->parent_id])->andWhere(['name'=>$model->name])->all();
            if($models){
                \Yii::$app->session->setFlash('danger','同层级不能添加同名分类');
                return $this->redirect(['goods-category/add']);
            }
            //判断是否是添加一级分类
            if($model->parent_id){
                //非一级分类
                $category = GoodsCategory::findOne(['id'=>$model->parent_id]);
                if($category){
                    $model->prependTo($category);
                }else{
                    throw new HttpException(404,'上级分类不存在');
                }
            }else{
                //一级分类
                $model->makeRoot();
            }
            \Yii::$app->session->setFlash('success','分类添加成功');
            return $this->redirect(['goods-category/index']);

        }
        //获取所以分类数据
        $categories = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }
    //修改商品分类
    public function actionEdit($id)
    {
        $model = GoodsCategory::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('分类不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $models=GoodsCategory::find()->where(['depth'=>$model->depth])->andWhere(['name'=>$model->name])->andWhere(['!=','id',$model->id])->all();
            if($models){
                \Yii::$app->session->setFlash('danger','同层级不能修改同名分类');
                return $this->redirect(['edit','id'=>$id]);
            }
            try{
                //判断是否是添加一级分类
                if($model->parent_id){
                    //非一级分类
                    $category = GoodsCategory::findOne(['id'=>$model->parent_id]);
                    if($category){
                        $model->prependTo($category);
                    }else{
                        throw new HttpException(404,'上级分类不存在');
                    }

                }else{
                    //一级分类
                    if($model->oldAttributes['parent_id']==0){
                        $model->save();
                    }else{
                        $model->makeRoot();
                    }
                }
                \Yii::$app->session->setFlash('info','分类修改成功');
                return $this->redirect(['index']);
            }catch (Exception $e){
                $model->addError('parent_id',GoodsCategory::exceptionInfo($e->getMessage()));
            }


        }

        //获取所以分类数据
        $categories = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        return $this->render('edit',['model'=>$model,'categories'=>$categories]);
    }
    //删除
    public function actionDelete($id){
        $model=GoodsCategory::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('分类不存在');
        }
        if(GoodsCategory::findOne(['parent_id'=>$id])){
            \Yii::$app->session->setFlash('danger','文章分类下有子节点不能删除');
            return $this->redirect(['goods-category/index']);
        }
        $model->deleteWithChildren();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['goods-category/index']);
    }
    public function actionIndex()
    {
        $request=new Request();

        //分页  总条数  每页显示条数 当前页
        $query=GoodsCategory::find();
        //总条数
        if($request->isPost){
            //搜索功能
            $keyword=$request->post('sou');
            $total=$query->Where(['like','name',$keyword])->orderBy('tree ASC,lft ASC')->count();
        }else{
            $total=$query->orderBy('tree ASC,lft ASC')->count();
        }

        //每页显示条数
        $pageSize=8;
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
