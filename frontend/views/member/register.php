<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>用户注册</title>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/login.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">
</head>
<body>
<!-- 顶部导航 start -->
<?php require './public/header.html'?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
    </div>
</div>
<!-- 页面头部 end -->

<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <!--<form action="" method="post" id="login_form">-->
            <?php $form = \yii\widgets\ActiveForm::begin(
            ['fieldConfig'=>[
                'errorOptions'=>[
                    'tag'=>'p',
                    'style'=>'color:red'
                ]
            ]]
            )?>
            <ul>
                <li id="li_username">
<!--                    <label for="">用户名：</label>-->
<!--                    <input type="text" class="txt" name="Member[username]" />-->
                    <?=$form->field($model,'username')->textInput(['class'=>'txt'])?>
                    <p></p>
                </li>
                <li id="li_password">
<!--                    <label for="">密码：</label>-->
<!--                    <input type="password" class="txt" name="Member[password]" />-->
                    <?=$form->field($model,'password')->passwordInput(['class'=>'txt'])?>
                    <p></p>
                </li>
                <li id="li_rePassword">
<!--                    <label for="">确认密码：</label>-->
<!--                    <input type="password" class="txt" name="Member[rePassword]" />-->
                    <?=$form->field($model,'rePassword')->passwordInput(['class'=>'txt'])?>
                    <p> </p>
                </li>
                <li id="li_email">
<!--                    <label for="">邮箱：</label>-->
<!--                    <input type="text" class="txt" name="Member[email]" />-->
                    <?=$form->field($model,'email')->textInput(['class'=>'txt'])?>
                    <p></p>
                </li>
                <li id="li_tel">
<!--                    <label for="">手机号码：</label>-->
<!--                    <input type="text" class="txt" value="" name="Member[tel]" id="tel" placeholder=""/>-->
                    <?=$form->field($model,'tel')->textInput(['class'=>'txt'])?>
                    <p></p>
                </li>
                <li id="li_smsCode">
<!--                    <label for="">短信验证</label>-->
<!--                    <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="Member[smsCode]" disabled="disabled" id="captcha"/>-->
                    <?=$form->field($model,'smsCode')->textInput(['class'=>'txt','placeholder'=>'请输入短信验证码','disabled'=>"disabled",'id'=>"captcha"])?><input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px;"/>
                    <p></p>
                </li>
                <li class="checkcode" id="li_code">
                    <?=$form->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'member/captcha',
                        'template'=>'<span class="row"><span class="col-lg-1">{input}</span><span class="col-lg-1"></span>{image}</span>'])?>
                    <p></p>
                </li>

                <li>
                    <label for="">&nbsp;</label>
                    <input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
                    <p></p>
                </li>
                <li>
                    <label for="">&nbsp;</label>
<!--                    <input type="submit" value="" class="login_btn" />-->
<!--                    <input type="button" value="" class="login_btn" />-->
                    <?=\yii\bootstrap\Html::submitButton('',['class'=>"login_btn"]);?>
                </li>
            </ul>
            <!--</form>-->
            <?php \yii\widgets\ActiveForm::end()?>


        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/images/xin.png" alt="" /></a>
        <a href=""><img src="/images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/images/police.jpg" alt="" /></a>
        <a href=""><img src="/images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    function bindPhoneNum(){



        var myreg=/^1[3578]\d{9}$/;

        var time=60;
        var url = '/member/test-sms';
        var num=$('#li_tel').find('.txt').val();

        if(myreg.test(num)){
            //启用输入框
            $('#captcha').prop('disabled',false);
            var args = 'tel='+num;
            console.debug(args);
            var interval = setInterval(function(){

                time--;
                if(time<=0){
                    clearInterval(interval);
                    var html = '获取验证码';
                    $('#get_captcha').prop('disabled',false);
                    $.getJSON(url,args,function(){
                    });
                } else{
                    var html = time + ' 秒后再次获取';
                    $('#get_captcha').prop('disabled',true);
                }

                $('#get_captcha').val(html);
            },1000);
        }else {
            alert('请输入有效的手机号码');

            return false;
        }

    }
</script>
</body>
</html>