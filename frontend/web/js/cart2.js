/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/
$(function(){
	// //收货人修改
	// $("#address_modify").click(function(){
	// 	$(this).hide();
	// 	$(".address_info").hide();
	// 	$(".address_select").show();
	// });
    //
	// $(".new_address").click(function(){
	// 	$("form[name=address_form]").show();
	// 	$(this).parent().addClass("cur").siblings().removeClass("cur");
    //
	// }).parent().siblings().find("input").click(function(){
	// 	$("form[name=address_form]").hide();
	// 	$(this).parent().addClass("cur").siblings().removeClass("cur");
	// });
    //
	// //送货方式修改
	// $("#delivery_modify").click(function(){
	// 	$(this).hide();
	// 	$(".delivery_info").hide();
	// 	$(".delivery_select").show();
	// })
    //
	// $("input[name=delivery]").click(function(){
	// 	$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	// });
    //
	// //支付方式修改
	// $("#pay_modify").click(function(){
	// 	$(this).hide();
	// 	$(".pay_info").hide();
	// 	$(".pay_select").show();
	// })
    //
	// $("input[name=pay]").click(function(){
	// 	$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	// });
    //
	// //发票信息修改
	// $("#receipt_modify").click(function(){
	// 	$(this).hide();
	// 	$(".receipt_info").hide();
	// 	$(".receipt_select").show();
	// })
    //
	// $(".company").click(function(){
	// 	$(".company_input").removeAttr("disabled");
	// });
    //
	// $(".personal").click(function(){
	// 	$(".company_input").attr("disabled","disabled");
	// });
	//计算商品总数量
    var total = 0;
    $(".price").each(function(){
        total += parseFloat($(this).text());
    });

    $(".num").text(total.toFixed());
    //计算商品总金额
	var num=0;
    $(".col5 span").each(function(){
        num += parseFloat($(this).text());
    });
    $(".sum").text(num.toFixed(2));
    //计算加上运费的的总金额
    var yf= $('.cur1').find('input:checked').attr('intro');
    yf=yf-0;
    var sum=num+yf;
	console.log(sum);
    $(".sum_all").text(sum.toFixed(2));
    $(".sum_all1").text(sum.toFixed(2));
    $(".yf").text(yf.toFixed(2));
    //点击修改运费总金额
	$('.cur1 input').click(function(){
        //计算加上运费的的总金额
        var yf= $('.cur1').find('input:checked').attr('intro');
        yf=yf-0;
        var sum=num+yf;
        //console.log(sum);
        var yf1=yf-0;
        $(".sum_all").text(sum.toFixed(2));
        $(".sum_all1").text(sum.toFixed(2));
        $(".yf").text(yf1.toFixed(2));
    })
    if(total!=0){
        //点击提交发送ajax提交数据
        $('.btn').click(function(){
            var address=$('.address_info').find('input:checked').val();
            var delivery_id= $('.cur1').find('input:checked').val();
            var payment_id=$('.cur').find('input:checked').val();
            var amounts=$('.sum_all1').text();
            var argus={
                address:address,
                delivery_id:delivery_id,
                payment_id:payment_id,
                amounts:amounts
            };
            $.post('/order/order',argus,function(data){
                //console.log(data);
            })
        })
	}

});