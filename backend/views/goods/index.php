<h1 style="color: #0000cc">商品列表</h1>
<form action="" method="get">
    <div class="input-group col-md-2 pull-right" >
        <input name="price2" type="text" class="form-control"placeholder="商品最高价格" / >
        <span class="input-group-btn">
           <button class="btn btn-info btn-search">查找</button>
        </span>
    </div>
    <div class="input-group  pull-right" ><strong> </strong></div>
    <div class="input-group col-md-2 pull-right" >
        <input name="price1" type="text" class="form-control"placeholder="商品起始价格" />
    </div>
    <div class="input-group col-md-2 pull-right" >
        <input name="sn" type="text" class="form-control"placeholder="商品货号" / >
    </div>
    <div class="input-group col-md-2 pull-right" >
        <input name="name" type="text" class="form-control"placeholder="商品名称" / >
    </div>
</form>

<?=\yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('回收站',['goods/back'],['class'=>'btn btn-sm btn-info'])?>

    <table class="table table-bordered" style="text-align: center">
        <tr>
            <td>ID</td>
            <td>商品名称</td>
            <td>是否在售</td>
            <td>所属品牌</td>
            <td>所属分类</td>
            <td>市场价格</td>
            <td>本店价格</td>
            <td>库存</td>
            <td>图片</td>
            <td>操作</td>
        </tr>
        <?php foreach ($models as $model):?>
            <tr>
                <td><?=$model->id?></td>
                <td><?=$model->name?></td>
                <td><?=\backend\models\Goods::$is_on_sale[$model->is_on_sale]?></td>
                <td><?=$model->brand->name?></td>
                <td><?=$model->goodsCategory->name?></td>
                <td><?=$model->market_price?></td>
                <td><?=$model->shop_price?></td>
                <td><?=$model->stock?></td>
                <td><?=$model->logo?\yii\bootstrap\Html::img($model->logo,['height'=>50]):''?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('相册',['goods/gallery','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
                    <?=\yii\bootstrap\Html::a('详情',['goods/content','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
                    <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
                    <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
