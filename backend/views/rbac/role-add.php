<h1><?=$model->scenario==\backend\models\RoleForm::SCENARIO_ADD?'添加':'修改'?>角色</h1>
<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput(['readonly'=>$model->scenario!=\backend\models\RoleForm::SCENARIO_ADD]);
echo $form->field($model,'description');
echo $form->field($model,'permission',['inline'=>1])->checkboxList(\yii\helpers\ArrayHelper::map(Yii::$app->authManager->getPermissions(),'name','name'));
echo \yii\bootstrap\Html::submitButton('立即添加',['class'=>'btn btn-sm btn-success']);
\yii\bootstrap\ActiveForm::end();