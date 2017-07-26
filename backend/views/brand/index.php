<?=\yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('回收站',['brand/back'],['class'=>'btn btn-sm btn-info'])?>
<table class="table table-bordered"style="text-align: center">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>排序</th>
        <th>状态</th>
        <th>简介</th>
        <th>图片</th>
        <th>操作</th>
    </tr>
    <?php foreach ($brands as $brand):?>
    <tr>
        <td><?=$brand->id?></td>
        <td><?=$brand->name?></td>
        <td><?=$brand->sort?></td>
        <td><?=\backend\models\Brand::$status_all[$brand->status]?></td>
        <td><?=$brand->intro?></td>
        <td><?=$brand->logo?\yii\bootstrap\Html::img($brand->logo,['height'=>50]):''?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$brand->id],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$brand->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
