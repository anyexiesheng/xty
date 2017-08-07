<?php
namespace frontend\controllers;

use frontend\models\Goods;
use backend\models\GoodsCategory;
use frontend\models\GoodsGallery;
use yii\data\Pagination;
use yii\web\Controller;

class GoodsController extends Controller
{

    public $layout=false;
    //获取商品分类
    public function actionGoodsCategory(){
        $models=GoodsCategory::find()->where(['parent_id'=>0])->all();
//        return $this->render('index',['models'=>$models]);
        $contents=$this->render('index',['models'=>$models]);
        file_put_contents('index.html',$contents);


    }
    //获取商品详情
    public function actionContent($id){
        $model=Goods::findOne(['id'=>$id]);
        return $this->render('goods',['model'=>$model]);
    }
    //获取商品列表
    public function actionIndex($category_id){
        //判断是几级分类
        $cate = GoodsCategory::findOne(['id'=>$category_id]);
        //分页  总条数  每页显示条数 当前页码
        if($cate->depth == 2){
            $query=Goods::find();
            //总条数
            $total=$query->where(['goods_category_id'=>$category_id])->count();
            //每页显示条数
            $pageSize=8;
            //当前页码
            $pager=new Pagination([
                'totalCount'=>$total,
                'defaultPageSize'=>$pageSize
            ]);
            $models=$query->limit($pager->limit)->offset($pager->offset)->all();
            //$models=Goods::find()->where(['goods_category_id'=>$category_id])->all();
        }else{

            $ids = $cate->leaves()->asArray()->column();
            //var_dump($ids);exit;
            $query=Goods::find();
            //总条数
            $total=$query->where(['in','goods_category_id',$ids])->count();
            //每页显示条数
            $pageSize=8;
            //当前页码
            $pager=new Pagination([
                'totalCount'=>$total,
                'defaultPageSize'=>$pageSize
            ]);
            $models=$query->limit($pager->limit)->offset($pager->offset)->all();
            //$models = Goods::find()->where(['in','goods_category_id',$ids])->all();
        }
        return $this->render('list',['models'=>$models,'pager'=>$pager]);
    }
}