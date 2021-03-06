<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'email');
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'role',['inline'=>1])->checkboxList(\yii\helpers\ArrayHelper::map(Yii::$app->authManager->getRoles(),'name','name'));
//验证码
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),
    ['captchaAction'=>'admin/captcha',
        'template'=>'<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'])->label('验证码');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-sm btn-success']);
\yii\bootstrap\ActiveForm::end();