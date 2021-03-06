<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>登录商城</title>
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
	<div class="login w990 bc mt10">
		<div class="login_hd">
			<h2>用户登录</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl">
<!--				<form action="" method="post">-->
                <?php $form=\yii\widgets\ActiveForm::begin(
                    ['fieldConfig'=>[


                        'errorOptions'=>[
                            'tag'=>'p',
                            'style'=>'padding-left:65px;color:red',
                        ]
                    ]]
                )?>
					<ul>
						<li>
<!--							<label for="">用户名：</label>-->
<!--							<input type="text" class="txt" name="username" />-->
                                <?=$form->field($model,'username')->textInput(['class'=>'txt'])?>
						</li>
						<li>
<!--							<label for="">密码：</label>-->
<!--							<input type="password" class="txt" name="password" />-->
							<?=$form->field($model,'password')->passwordInput(['class'=>'txt'])?>
<!--                            <a href="">忘记密码?</a>-->
						</li>
<!--						<li class="checkcode">-->
<!--							<label for="">验证码：</label>-->
<!--							<input type="text"  name="checkcode" />-->
<!--							<img src="/images/checkcode1.jpg" alt="" />-->
<!--							<span>看不清？<a href="">换一张</a></span>-->
<!--						</li>-->
                        <li class="checkcode" id="li_code">
                            <?=$form->field($model,'code')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'member/captcha',
                                'template'=>'<span class="row"><span class="col-lg-1">{input}</span><span class="col-lg-1"></span>{image}</span>'])?>
                        </li>
						<li>
							<label for="">&nbsp;&emsp;&emsp;</label>
<!--							<input type="checkbox" class="chb"  /> 保存登录信息-->
						    <?=$form->field($model,'rember')->checkbox(['class'=>'chb'])?>
                        </li>
                        <li>

                        </li>
						<li>
                            <p>
                                <label for="">&nbsp;</label>
                                <input type="submit" value="" class="login_btn" />
                            </p>

						</li>
					</ul>
                <?php \yii\widgets\ActiveForm::end()?>
<!--				</form>-->

				<div class="coagent mt15">
					<dl>
						<dt>使用合作网站登录商城：</dt>
						<dd class="qq"><a href=""><span></span>QQ</a></dd>
						<dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
						<dd class="yi"><a href=""><span></span>网易</a></dd>
						<dd class="renren"><a href=""><span></span>人人</a></dd>
						<dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
						<dd class=""><a href=""><span></span>百度</a></dd>
						<dd class="douban"><a href=""><span></span>豆瓣</a></dd>
					</dl>
				</div>
			</div>
			
			<div class="guide fl">
				<h3>还不是商城用户</h3>
				<p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

				<a href="/member/register" class="reg_btn">免费注册 >></a>
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

</body>
</html>