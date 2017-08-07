<h1>角色列表</h1>
<?=\yii\bootstrap\Html::a('添加',['role-add'],['class'=>'btn btn-sm btn-success'])?>
<style>
    th{font: 22px sold;text-align: center;color: #960a0b}
</style>
<table class="table table-bordered" style="text-align: center">
    <tr>
        <th>角色名称</th>
        <th>角色描述</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['role-edit','name'=>$model->name],['class'=>'btn btn-sm btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['role-delete','name'=>$model->name],['class'=>'btn btn-sm btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>