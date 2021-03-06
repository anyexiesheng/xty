<?php
use kucha\ueditor\UEditor;
use yii\web\JsExpression;

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($good,'name');
echo $form->field($good,'sort');
echo $form->field($good,'stock');
echo $form->field($good,'market_price');
echo $form->field($good,'shop_price');
echo $form->field($good,'brand_id')->dropDownList(\backend\models\Goods::getBrands());
//echo $form->field($good,'goods_category_id');
echo $form->field($good,'goods_category_id')->hiddenInput();
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($good,'is_on_sale',['inline'=>1])->radioList(\backend\models\Goods::$is_on_sale);
echo \yii\bootstrap\Html::img($good->logo?$good->logo:false,['id'=>'img','height'=>50]);
echo $form->field($good,'logo')->hiddenInput();

//外部TAG
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['someKey' => 'someValue'],
        'width' => 80,
        'height' => 30,
        'onError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadComplete' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    //console.log(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //将图片的地址赋值给logo字段
        $("#goods-logo").val(data.fileUrl);
        //将上传成功的图片回显
        $("#img").attr('src',data.fileUrl);
    }
}
EOF
        ),
    ]
]);


//文本编辑器
echo $form->field($goods_intro,'content')->widget(UEditor::className(),[
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //英文为en

    ]]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
//调用视图的方法加载静态资源
//加载css文件
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
//加载js文件
$categories=\backend\models\Goods::getGoodsCategorys();
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$categories[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类','open'=>1];
$nodes = \yii\helpers\Json::encode($categories);
$nodeId = $good->goods_category_id;
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            },
            callback: {
		        onClick: function(event, treeId, treeNode){
		            //console.log(treeNode.id);
		            //将当期选中的分类的id，赋值给parent_id隐藏域
		            $("#goods-goods_category_id").val(treeNode.id);
		        }
	        }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$nodes};
  
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);//展开全部节点
        
        //获取节点
        var node = zTreeObj.getNodeByParam("id", "{$nodeId}", null);
        //选中节点
        zTreeObj.selectNode(node);
        //触发选中事件
        

JS

));