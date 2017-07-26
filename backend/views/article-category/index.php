<?=\yii\bootstrap\Html::a('添加',['article-category/add'],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('回收站',['article-category/back'],['class'=>'btn btn-sm btn-info'])?>
<table class="table table-bordered"style="text-align: center">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>排序</th>
        <th>状态</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->sort?></td>
        <td><?=\backend\models\ArticleCategory::$status_all[$model->status]?></td>
        <td><?=$model->intro?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['article-category/edit','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['article-category/delete','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
