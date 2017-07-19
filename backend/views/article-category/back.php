<table class="table table-bordered">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>排序</td>
        <td>状态</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->sort?></td>
            <td><?='已删除'?></td>
            <td><?=$model->intro?></td>
            <td>
                <?=\yii\bootstrap\Html::a('恢复',['article-category/recover','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
                <?=\yii\bootstrap\Html::a('清除',['article-category/clean','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
