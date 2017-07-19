<?php
$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($article,'name');
echo $from->field($article,'intro')->textarea();
echo $from->field($article,'article_category_id')->dropDownList(\backend\models\Article::getCategoryAll());
echo $from->field($article,'sort');
echo $from->field($article,'status',['inline'=>1])->radioList(\backend\models\Article::$status_all);
echo $from->field($article_detail,'content')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();