<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'url')->dropDownList(\backend\models\Menu::getPermission());
echo $form->field($model,'prent_id')->dropDownList(\backend\models\Menu::getMenus());
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('立即添加',['class'=>'btn btn-sm btn-success']);
\yii\bootstrap\ActiveForm::end();