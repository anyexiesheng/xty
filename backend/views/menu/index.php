<h1>菜单列表</h1>
<?=\yii\bootstrap\Html::a('添加',['menu/add'],['class'=>'btn btn-sm btn-success'])?>
<style>
    th{font: 22px sold;text-align: center;color: #960a0b}
</style>
<table class="table table-responsive table-bordered" style="text-align: center">
    <tr>
        <th>菜单名称</th>
        <th>菜单路由</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->url?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['menu/delete','id'=>$model->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php foreach($model->children as $child):?>
    <tr>
        <td>&emsp;&emsp;&emsp;&emsp;<?=$child->name?></td>
        <td><?=$child->url?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['menu/edit','id'=>$child->id],['class'=>'btn btn-sm btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['menu/delete','id'=>$child->id],['class'=>'btn btn-sm btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
    <?php endforeach;?>
</table>
