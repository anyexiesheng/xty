<form action="" method="post">
    <div class="input-group col-lg-5 col-md-6 col-md-offset-3" >
        <input type="text" class="form-control" placeholder="搜索文章名" aria-describedby="basic-addon2" name="sou">
        <span class="input-group-btn">
<!--                <button class="btn btn-success" type="button">搜索</button>-->
            <input type="submit" class="btn btn-success" value="搜索">
            <input name="_csrf-backend" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken?>">
        </span>
    </div>
</form>


<?=\yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('回收站',['article/back'],['class'=>'btn btn-sm btn-info'])?>
<table class="table table-bordered"style="text-align: center">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>简介</td>
        <td>文章分类</td>
        <td>排序</td>
        <td>状态</td>
        <td>创建时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->intro?></td>
        <td><?=$model->articleCategory->name?></td>
        <td><?=$model->sort?></td>
        <td><?=\backend\models\Article::$status_all[$model->status]?></td>
        <td><?=$model->create_time?date('Y-m-d H:i:s',$model->create_time):''?></td>
        <td>
            <?=\yii\bootstrap\Html::a('查看详情',['article/content','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('修改',['article/edit','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['article/delete','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
