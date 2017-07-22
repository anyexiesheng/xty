<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($article,'name');
//echo $from->field($article,'intro')->textarea();
echo $form->field($article,'intro')->textarea();
echo $form->field($article,'article_category_id')->dropDownList(\backend\models\Article::getCategoryAll());
echo $form->field($article,'sort');
echo $form->field($article,'status',['inline'=>1])->radioList(\backend\models\Article::$status_all);

//文本编辑器
echo $form->field($article_detail,'content')->widget('kucha\ueditor\UEditor',[
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //英文为en

    ]]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();