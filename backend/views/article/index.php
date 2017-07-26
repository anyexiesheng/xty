<form action="" method="get">
    <div class="input-group col-lg-5 col-md-6 col-md-offset-3" >
        <input type="text" class="form-control" placeholder="搜索文章名" aria-describedby="basic-addon2" name="sou">
        <span class="input-group-btn">
<!--                <button class="btn btn-success" type="button">搜索</button>-->
            <input type="submit" class="btn btn-success" value="搜索">
        </span>
    </div>
</form>


<?=\yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('回收站',['article/back'],['class'=>'btn btn-sm btn-info'])?>
<table class="table table-bordered"style="text-align: center">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>简介</th>
        <th>文章分类</th>
        <th>排序</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
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
