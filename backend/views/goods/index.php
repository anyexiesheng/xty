<h1 style="color: #0000cc">商品列表</h1>
<?=\yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('回收站',['goods/back'],['class'=>'btn btn-sm btn-info'])?>
    <table class="table table-bordered"style="text-align: center">
        <tr>
            <td>ID</td>
            <td>商品名称</td>
            <td>是否在售</td>
            <td>品牌分类</td>
            <td>商品分类</td>
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
                <td><?=$model->stock?></td>
                <td><?=\yii\bootstrap\Html::img($model->logo,['height'=>50])?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
                    <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
