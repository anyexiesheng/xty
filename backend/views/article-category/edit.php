<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'sort');
//echo $form->field($model,'intro')->textarea();
//文本编辑器
echo $form->field($model,'intro')->widget('kucha\ueditor\UEditor',[
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //英文为en

    ]]);
echo $form->field($model,'status',['inline'=>1])->radioList(\backend\models\ArticleCategory::$status_all);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();