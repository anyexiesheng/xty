<h1 style="color: #960a0b" class="text-center">用户列表</h1>
<?=\yii\bootstrap\Html::a('添加新用户',['admin/add'],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('已禁用用户列表',['admin/add'],['class'=>'btn btn-sm btn-danger'])?>
<table class="table table-bordered">
    <tr>
        <td>ID</td>
        <td>用户名</td>
        <td>邮箱</td>
        <td>最后登陆时间</td>
        <td>最后登录IP</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->username?></td>
        <td><?=$model->email?></td>
        <td><?=$model->last_login_time?date('Y-m-d H:i:s',$model->last_login_time):''?></td>
        <td><?=$model->last_login_ip?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['admin/edit','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('禁用',['admin/delete','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,'lastPageLabel'=>'末页','nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','firstPageLabel'=>'首页']);
