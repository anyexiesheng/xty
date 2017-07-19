<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($brand,'name');
echo $form->field($brand,'sort');
echo $form->field($brand,'intro')->textarea();
echo $form->field($brand,'status',['inline'=>1])->radioList(\backend\models\Brand::$status_all);
echo $form->field($brand,'filelogo')->fileInput();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();