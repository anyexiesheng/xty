<form action="" method="post">
    <div class="input-group col-lg-5 col-md-6 col-md-offset-3" >
        <input type="text" class="form-control" placeholder="搜索文章名" aria-describedby="basic-addon2" name="sou">
        <span class="input-group-btn">
            <input type="submit" class="btn btn-success" value="搜索">
            <input name="_csrf-backend" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken?>">
        </span>
    </div>
</form>
<?=\yii\bootstrap\Html::a('添加',['goods-category/add'],['class'=>'btn btn-sm btn-success'])?>
<table class="table table-bordered">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>上级分类id</td>
        <td>内容</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=str_repeat('--',$model->depth).$model->name?></td>
            <td><?=$model->parent_id?></td>
            <td><?=$model->intro?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/delete','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
