<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>收货地址</title>
	<link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/home.css" type="text/css">
	<link rel="stylesheet" href="/style/address.css" type="text/css">
	<link rel="stylesheet" href="/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">

	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/js/header.js"></script>
	<script type="text/javascript" src="/js/home.js"></script>
</head>
<body>
		<!-- 顶部导航 start -->
        <?php require './public/header.html'?>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 头部 start -->
	<div class="header w1210 bc mt15">
		<!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
		<div class="logo w1210">
			<h1 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h1>
			<!-- 头部搜索 start -->
			<div class="search fl">
				<div class="search_form">
					<div class="form_left fl"></div>
					<form action="" name="serarch" method="get" class="fl">
						<input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
					</form>
					<div class="form_right fl"></div>
				</div>
				
				<div style="clear:both;"></div>

				<div class="hot_search">
					<strong>热门搜索:</strong>
					<a href="">D-Link无线路由</a>
					<a href="">休闲男鞋</a>
					<a href="">TCL空调</a>
					<a href="">耐克篮球鞋</a>
				</div>
			</div>
			<!-- 头部搜索 end -->

			<!-- 用户中心 start-->
			<div class="user fl">
				<dl>
					<dt>
						<em></em>
						<a href="">用户中心</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							您好，请<a href="">登录</a>
						</div>
						<div class="uclist mt10">
							<ul class="list1 fl">
								<li><a href="">用户信息></a></li>
								<li><a href="">我的订单></a></li>
								<li><a href="">收货地址></a></li>
								<li><a href="">我的收藏></a></li>
							</ul>

							<ul class="fl">
								<li><a href="">我的留言></a></li>
								<li><a href="">我的红包></a></li>
								<li><a href="">我的评论></a></li>
								<li><a href="">资金管理></a></li>
							</ul>

						</div>
						<div style="clear:both;"></div>
						<div class="viewlist mt10">
							<h3>最近浏览的商品：</h3>
							<ul>
								<li><a href=""><img src="/images/view_list1.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/view_list2.jpg" alt="" /></a></li>
								<li><a href=""><img src="/images/view_list3.jpg" alt="" /></a></li>
							</ul>
						</div>
					</dd>
				</dl>
			</div>
			<!-- 用户中心 end-->

			<!-- 购物车 start -->
			<div class="cart fl">
				<dl>
					<dt>
						<a href="">去购物车结算</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							购物车中还没有商品，赶紧选购吧！
						</div>
					</dd>
				</dl>
			</div>
			<!-- 购物车 end -->
		</div>
		<!-- 头部上半部分 end -->
		
		<div style="clear:both;"></div>

		<!-- 导航条部分 start -->
		<div class="nav w1210 bc mt10">
			<!--  商品分类部分 start-->
			<div class="category fl cat1"> <!-- 非首页，需要添加cat1类 -->
				<div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
					<h2>全部商品分类</h2>
					<em></em>
				</div>
				
				<div class="cat_bd none">
					
					<div class="cat item1">
						<h3><a href="">图像、音像、数字商品</a> <b></b></h3>
						<div class="cat_detail">
							<dl class="dl_1st">
								<dt><a href="">电子书</a></dt>
								<dd>
									<a href="">免费</a>
									<a href="">小说</a>
									<a href="">励志与成功</a>
									<a href="">婚恋/两性</a>
									<a href="">文学</a>
									<a href="">经管</a>
									<a href="">畅读VIP</a>						
								</dd>
							</dl>

							<dl>
								<dt><a href="">数字音乐</a></dt>
								<dd>
									<a href="">通俗流行</a>
									<a href="">古典音乐</a>
									<a href="">摇滚说唱</a>
									<a href="">爵士蓝调</a>
									<a href="">乡村民谣</a>
									<a href="">有声读物</a>
								</dd>
							</dl>

							<dl>
								<dt><a href="">音像</a></dt>
								<dd>
									<a href="">音乐</a>
									<a href="">影视</a>
									<a href="">教育音像</a>
									<a href="">游戏</a>
								</dd>
							</dl>

							<dl>
								<dt><a href="">文艺</a></dt>
								<dd>
									<a href="">小说</a>
									<a href="">文学</a>
									<a href="">青春文学</a>
									<a href="">传纪</a>
									<a href="">艺术</a>
									<a href="">经管</a>
									<a href="">畅读VIP</a>						
								</dd>
							</dl>

							<dl>
								<dt><a href="">人文社科</a></dt>
								<dd>
									<a href="">历史</a>
									<a href="">心理学</a>
									<a href="">政治/军事</a>
									<a href="">国学/古籍</a>
									<a href="">哲学/宗教</a>
									<a href="">社会科学</a>
								</dd>
							</dl>

							<dl>
								<dt><a href="">经管励志</a></dt>
								<dd>
									<a href="">经济</a>
									<a href="">金融与投资</a>
									<a href="">管理</a>
									<a href="">励志与成功</a>
								</dd>
							</dl>

							<dl>
								<dt><a href="">人文社科</a></dt>
								<dd>
									<a href="">历史</a>
									<a href="">心理学</a>
									<a href="">政治/军事</a>
									<a href="">国学/古籍</a>
									<a href="">哲学/宗教</a>
									<a href="">社会科学</a>
								</dd>
							</dl>

							<dl>
								<dt><a href="">生活</a></dt>
								<dd>
									<a href="">烹饪/美食</a>
									<a href="">时尚/美妆</a>
									<a href="">家居</a>
									<a href="">娱乐/休闲</a>
									<a href="">动漫/幽默</a>
									<a href="">体育/运动</a>
								</dd>
							</dl>

							<dl>
								<dt><a href="">科技</a></dt>
								<dd>
									<a href="">科普</a>
									<a href="">建筑</a>
									<a href="">IT</a>
									<a href="">医学</a>
									<a href="">工业技术</a>
									<a href="">电子/通信</a>
									<a href="">农林</a>
									<a href="">科学与自然</a>
								</dd>
							</dl>

						</div>
					</div>

					<div class="cat">
						<h3><a href="">家用电器</a><b></b></h3>
						<div class="cat_detail">
							<dl class="dl_1st">
								<dt><a href="">大家电</a></dt>
								<dd>
									<a href="">平板电视</a>
									<a href="">空调</a>
									<a href="">冰箱</a>
									<a href="">洗衣机</a>
									<a href="">热水器</a>
									<a href="">DVD</a>
									<a href="">烟机/灶具</a>						
								</dd>
							</dl>

							<dl>
								<dt><a href="">生活电器</a></dt>
								<dd>
									<a href="">取暖器</a>
									<a href="">加湿器</a>
									<a href="">净化器</a>
									<a href="">饮水机</a>
									<a href="">净水设备</a>
									<a href="">吸尘器</a>
									<a href="">电风扇</a>						
								</dd>
							</dl>

							<dl>
								<dt><a href="">厨房电器</a></dt>
								<dd>
									<a href="">电饭煲</a>
									<a href="">豆浆机</a>
									<a href="">面包机</a>
									<a href="">咖啡机</a>
									<a href="">微波炉</a>
									<a href="">电磁炉</a>
									<a href="">电水壶</a>						
								</dd>
							</dl>

							<dl>
								<dt><a href="">个护健康</a></dt>
								<dd>
									<a href="">剃须刀</a>
									<a href="">电吹风</a>
									<a href="">按摩器</a>
									<a href="">足浴盆</a>
									<a href="">血压计</a>
									<a href="">体温计</a>
									<a href="">血糖仪</a>						
								</dd>
							</dl>

							<dl>
								<dt><a href="">五金家装</a></dt>
								<dd>
									<a href="">灯具</a>
									<a href="">LED灯</a>
									<a href="">水槽</a>
									<a href="">龙头</a>
									<a href="">门铃</a>
									<a href="">电器开关</a>
									<a href="">插座</a>						
								</dd>
							</dl>
						</div>
					</div>

					<div class="cat">
						<h3><a href="">手机、数码</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>

					<div class="cat">
						<h3><a href="">电脑、办公</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>
					
					<div class="cat">
						<h3><a href="">家局、家具、家装、厨具</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>
					
					<div class="cat">
						<h3><a href="">服饰鞋帽</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>
					
					<div class="cat">
						<h3><a href="">个护化妆</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>
					
					<div class="cat">
						<h3><a href="">礼品箱包、钟表、珠宝</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>

					<div class="cat">
						<h3><a href="">运动健康</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>

					<div class="cat">
						<h3><a href="">汽车用品</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>
					
					<div class="cat">
						<h3><a href="">母婴、玩具乐器</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>

					<div class="cat">
						<h3><a href="">食品饮料、保健食品</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>

					<div class="cat">
						<h3><a href="">彩票、旅行、充值、票务</a><b></b></h3>
						<div class="cat_detail none">
							
						</div>
					</div>

				</div>

			</div>
			<!--  商品分类部分 end--> 

			<div class="navitems fl">
				<ul class="fl">
					<li class="current"><a href="">首页</a></li>
					<li><a href="">电脑频道</a></li>
					<li><a href="">家用电器</a></li>
					<li><a href="">品牌大全</a></li>
					<li><a href="">团购</a></li>
					<li><a href="">积分商城</a></li>
					<li><a href="">夺宝奇兵</a></li>
				</ul>
				<div class="right_corner fl"></div>
			</div>
		</div>
		<!-- 导航条部分 end -->
	</div>
	<!-- 头部 end-->
	
	<div style="clear:both;"></div>

	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的XX </strong><span>> 我的订单</span></h2>
		</div>
		
		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">我的订单</a></dd>
					<dd><b>.</b><a href="">我的关注</a></dd>
					<dd><b>.</b><a href="">浏览历史</a></dd>
					<dd><b>.</b><a href="">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="">账户信息</a></dd>
					<dd><b>.</b><a href="">账户余额</a></dd>
					<dd><b>.</b><a href="">消费记录</a></dd>
					<dd><b>.</b><a href="">我的积分</a></dd>
					<dd><b>.</b><a href="">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">返修/退换货</a></dd>
					<dd><b>.</b><a href="">取消订单记录</a></dd>
					<dd><b>.</b><a href="">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->

		<!-- 右侧内容区域 start -->
		<div class="content">
			<div class="address_hd">
				<h3>收货地址薄</h3>
				<?php foreach ($models as $address):?>
				<dl class="last"> <!-- 最后一个dl 加类last -->
					<dt><?=$address->consignee?>&emsp;<?=$address->province?>&emsp;<?=$address->city?>&emsp;<?=$address->area?>&emsp;<?=$address->detailed_address?>&emsp;<?=$address->tel?></dt>
					<dd>
						<a href="/member/address-del?id=<?=$address->id?>">删除</a>
						<a href="/member/address-edit">设为默认地址</a>
					</dd>
				</dl>
                <?php endforeach;?>
			</div>

			<div class="address_bd mt10">
				<h4>新增收货地址</h4>
<!--				<form action="" name="address_form">-->
                <?php $form=\yii\bootstrap\ActiveForm::begin()?>
						<ul>
							<li>
<!--								<label for=""><span>*</span>收 货 人：</label>-->
<!--								<input type="text" name="" class="txt" />-->
							<?=$form->field($model,'consignee')->textInput(['class'=>'txt'])?>
                            </li>
							<li id='content'>
								<label for=""><span>*</span>所在地区：</label>
								<select name="province" id="province">
									<option value="">请选择省份</option>
								</select>

								<select name="city" id="city">
									<option value="">请选择城市</option>
								</select>

								<select name="area" id="area">
									<option value="">请选择区县</option>
								</select>
							</li>
							<li>
<!--								<label for=""><span>*</span>详细地址：</label>-->
<!--								<input type="text" name="" class="txt address"  />-->
							        <?=$form->field($model,'detailed_address')->textInput(['class'=>'txt'])?>
                            </li>
							<li>
<!--								<label for=""><span>*</span>手机号码：</label>-->
<!--								<input type="text" name="" class="txt" />-->
                                    <?=$form->field($model,'tel')->textInput(['class'=>'txt'])?>
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="checkbox" name="status" class="check" />设为默认地址

                            </li>
							<li>
								<label for="">&nbsp;</label>
								<input type="submit" name="" class="btn" value="保存" />
							</li>
						</ul>
<!--					</form>-->
                        <?php \yii\bootstrap\ActiveForm::end()?>
			</div>	

		</div>

		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->

	<div style="clear:both;"></div>

	<!-- 底部导航 start -->
	<div class="bottomnav w1210 bc mt10">
		<div class="bnav1">
			<h3><b></b> <em>购物指南</em></h3>
			<ul>
				<li><a href="">购物流程</a></li>
				<li><a href="">会员介绍</a></li>
				<li><a href="">团购/机票/充值/点卡</a></li>
				<li><a href="">常见问题</a></li>
				<li><a href="">大家电</a></li>
				<li><a href="">联系客服</a></li>
			</ul>
		</div>
		
		<div class="bnav2">
			<h3><b></b> <em>配送方式</em></h3>
			<ul>
				<li><a href="">上门自提</a></li>
				<li><a href="">快速运输</a></li>
				<li><a href="">特快专递（EMS）</a></li>
				<li><a href="">如何送礼</a></li>
				<li><a href="">海外购物</a></li>
			</ul>
		</div>

		
		<div class="bnav3">
			<h3><b></b> <em>支付方式</em></h3>
			<ul>
				<li><a href="">货到付款</a></li>
				<li><a href="">在线支付</a></li>
				<li><a href="">分期付款</a></li>
				<li><a href="">邮局汇款</a></li>
				<li><a href="">公司转账</a></li>
			</ul>
		</div>

		<div class="bnav4">
			<h3><b></b> <em>售后服务</em></h3>
			<ul>
				<li><a href="">退换货政策</a></li>
				<li><a href="">退换货流程</a></li>
				<li><a href="">价格保护</a></li>
				<li><a href="">退款说明</a></li>
				<li><a href="">返修/退换货</a></li>
				<li><a href="">退款申请</a></li>
			</ul>
		</div>

		<div class="bnav5">
			<h3><b></b> <em>特色服务</em></h3>
			<ul>
				<li><a href="">夺宝岛</a></li>
				<li><a href="">DIY装机</a></li>
				<li><a href="">延保服务</a></li>
				<li><a href="">家电下乡</a></li>
				<li><a href="">京东礼品卡</a></li>
				<li><a href="">能效补贴</a></li>
			</ul>
		</div>
	</div>
	<!-- 底部导航 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt10">
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
        <script type="text/javascript">
            $(function(){
                //页面加载完毕就获取省份列表
                var url = '/member/locations';
                var args = 'pid=0';
                $.getJSON(url,args,function(data){
                    //将省级数据放入province中
                    $(data).each(function(i,v){
                        var html = '<option value="'+v.id+'">'+v.name+'</option>';
                        $(html).appendTo($('#province'));
                    });
                });


                //当省份切换的时候就获取市级列表
                //1.事件绑定在#province
                //2.绑定的是onchange
                $('#province').change(function(){
                    //方法4.
                    $('#city').get(0).length=1;
                    $('#area').get(0).length=1;
                    if(!$(this).val()){
                        return false;
                    }
                    //获取市级列表,就是ajax请求
                    var args = 'pid=' + $(this).val();
                    $.getJSON(url,args,function(data){
                        //要将原有的市级列表给清除
                        //方法1.
                        //$('#city').empty();
                        //$('<option>请选择城市</option>').appendTo($('#city'));
                        //方法2.
                        //$('#city').html('<option>请选择城市</option>');
                        //方法3.
                        //$('#city option:gt(0)').remove();
                        $(data).each(function(i,v){
                            //获取到的数据展示在#city中
                            var html = '<option value="'+v.id+'">'+v.name+'</option>'
                            $(html).appendTo($('#city'));
                        });
                    });
                });

                //切换市级,获取区县列表
                $('#city').change(function(){
                    $('#area').get(0).length=1;
                    if(!$(this).val()){
                        return false;
                    }
                    //ajax
                    var args = 'pid=' + $(this).val();
                    $.getJSON(url,args,function(data){
                        //清空区县列表
                        //$('#area option:gt(0)').remove();
                        //遍历获取
                        $(data).each(function(i,v){
                            var html = '<option value="'+v.id+'">'+v.name+'</option>'
                            $(html).appendTo($('#area'));
                        });
                    });
                });
            });
        </script>
</body>
</html>