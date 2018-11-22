<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>我的购物车</title>

	<link rel="stylesheet" type="text/css" href="/css/webbase.css" />
	<link rel="stylesheet" type="text/css" href="/css/pages-cart.css" />
	<style>
		.b-sub{
			border:none;
			display: block;
			position: relative;
			width: 96px;
			height: 52px;
			line-height: 52px;
			color: #fff;
			text-align: center;
			font-size: 18px;
			font-family: "Microsoft YaHei";
			background: #e54346;
			overflow: hidden;
		}
	</style>
</head>

<body>
	<!--head-->
	<div class="top">
		<div class="py-container">
			<div class="shortcut">
				<ul class="fl">
					<li class="f-item">品优购欢迎您！</li>
					<li class="f-item">请登录　<span><a href="#">免费注册</a></span></li>
				</ul>
				<ul class="fr">
					<li class="f-item">我的订单</li>
					<li class="f-item space"></li>
					<li class="f-item">我的品优购</li>
					<li class="f-item space"></li>
					<li class="f-item">品优购会员</li>
					<li class="f-item space"></li>
					<li class="f-item">企业采购</li>
					<li class="f-item space"></li>
					<li class="f-item">关注品优购</li>
					<li class="f-item space"></li>
					<li class="f-item">客户服务</li>
					<li class="f-item space"></li>
					<li class="f-item">网站导航</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="cart py-container">
		<!--logoArea-->
		<div class="logoArea">
			<div class="fl logo"><span class="title">购物车</span></div>
			<div class="fr search">
				<form class="sui-form form-inline">
					<div class="input-append">
						<input type="text" type="text" class="input-error input-xxlarge" placeholder="品优购自营" />
						<button class="sui-btn btn-xlarge btn-danger" type="button">搜索</button>
					</div>
				</form>
			</div>
		</div>
		<!--All goods-->
		<div class="allgoods">
			<h4>全部商品 <span>共{{$data['count']}}件商品</span></h4>
			<div class="cart-main">
				<div class="yui3-g cart-th">
					<div class="yui3-u-1-4"><input onclick="checkAll()" type="checkbox" name="" id="" value="" /> 全部</div>
					<div class="yui3-u-1-4">商品</div>
					<div class="yui3-u-1-8">单价（元）</div>
					<div class="yui3-u-1-8">数量</div>
					<div class="yui3-u-1-8">小计（元）</div>
					<div class="yui3-u-1-8">操作</div>
				</div>
		<form action="{{Route('GoodsCart')}}" method="POST">
			@csrf
				<div class="cart-item-list">
					<div class="cart-body">
						@foreach ($data['data'] as $k=>$v)
							<div class="cart-list">
								<ul class="goods-list yui3-g">
									<li class="yui3-u-1-24">
										<input type="checkbox" name="goods[]" value="{{$v->id}}" onclick="getgoods(this)" />
									</li>
									<li class="yui3-u-11-24">
										<div class="good-item">
											<div class="item-img"><img src="{{$v->sm_path}}" /></div>
											<div class="item-msg">
												{{$v->sku_name}}
											</div>
										</div>
									</li>

									<li class="yui3-u-1-8"><span class="price">{{$v->price}}</span></li>
									<li class="yui3-u-1-8">
										<a href="javascript:minus('{{$k}}')" class="increment mins">-</a>
										<input autocomplete="off" type="text" value="{{$v->stock}}" minnum="1" class="itxt" />
										<a href="javascript:add('{{$k}}')" class="increment plus">+</a>
									</li>
									<li class="yui3-u-1-8"><span class="sum">{{$v->price*$v->stock}}</span></li>
									<li class="yui3-u-1-8">
										<a href="#none">删除</a><br />
										<a href="#none">移到我的关注</a>
									</li>
								</ul>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="cart-tool">
				<div class="select-all">
					<input onclick="checkAll()" type="checkbox" name="" id="" value="" />
					<span>全选</span>
				</div>
				<div class="option">
					<a href="#none">删除选中的商品</a>
					<a href="#none">移到我的关注</a>
					<a href="#none">清除下柜商品</a>
				</div>
				<div class="toolbar">
					<div class="chosed">已选择<span>0</span>件商品</div>
					<div class="sumprice">
						<span><em>总价（不含运费） ：</em><i class="summoney">¥</i></span>
					</div>
					<div class="sumbtn">
						<button class="b-sub">结算</button>
					</div>
				</div>
			</div>
		</form>
			<div class="clearfix"></div>
			<div class="liked">
				<ul class="sui-nav nav-tabs">
					<li class="active">
						<a href="#index" data-toggle="tab">猜你喜欢</a>
					</li>
					<li>
						<a href="#profile" data-toggle="tab">特惠换购</a>
					</li>
				</ul>
				<div class="clearfix"></div>
				<div class="tab-content">
					<div id="index" class="tab-pane active">
						<div id="myCarousel" data-ride="carousel" data-interval="4000" class="sui-carousel slide">
							<div class="carousel-inner">
								<div class="active item">
									<ul>
										<li>
											<img src="/img/like1.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/img/like2.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/img/like3.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/img/like4.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
									</ul>
								</div>
								<div class="item">
									<ul>
										<li>
											<img src="/img/like1.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/img/like2.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/img/like3.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/img/like4.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<a href="#myCarousel" data-slide="prev" class="carousel-control left">‹</a>
							<a href="#myCarousel" data-slide="next" class="carousel-control right">›</a>
						</div>
					</div>
					<div id="profile" class="tab-pane">
						<p>特惠选购</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 底部栏位 -->
	<!--页面底部-->
	<div class="clearfix footer">
		<div class="py-container">
			<div class="footlink">
				<div class="Mod-service">
					<ul class="Mod-Service-list">
						<li class="grid-service-item intro  intro1">

							<i class="serivce-item fl"></i>
							<div class="service-text">
								<h4>正品保障</h4>
								<p>正品保障，提供发票</p>
							</div>

						</li>
						<li class="grid-service-item  intro intro2">

							<i class="serivce-item fl"></i>
							<div class="service-text">
								<h4>正品保障</h4>
								<p>正品保障，提供发票</p>
							</div>

						</li>
						<li class="grid-service-item intro  intro3">

							<i class="serivce-item fl"></i>
							<div class="service-text">
								<h4>正品保障</h4>
								<p>正品保障，提供发票</p>
							</div>

						</li>
						<li class="grid-service-item  intro intro4">

							<i class="serivce-item fl"></i>
							<div class="service-text">
								<h4>正品保障</h4>
								<p>正品保障，提供发票</p>
							</div>

						</li>
						<li class="grid-service-item intro intro5">

							<i class="serivce-item fl"></i>
							<div class="service-text">
								<h4>正品保障</h4>
								<p>正品保障，提供发票</p>
							</div>

						</li>
					</ul>
				</div>
				<div class="clearfix Mod-list">
					<div class="yui3-g">
						<div class="yui3-u-1-6">
							<h4>购物指南</h4>
							<ul class="unstyled">
								<li>购物流程</li>
								<li>会员介绍</li>
								<li>生活旅行/团购</li>
								<li>常见问题</li>
								<li>购物指南</li>
							</ul>

						</div>
						<div class="yui3-u-1-6">
							<h4>配送方式</h4>
							<ul class="unstyled">
								<li>上门自提</li>
								<li>211限时达</li>
								<li>配送服务查询</li>
								<li>配送费收取标准</li>
								<li>海外配送</li>
							</ul>
						</div>
						<div class="yui3-u-1-6">
							<h4>支付方式</h4>
							<ul class="unstyled">
								<li>货到付款</li>
								<li>在线支付</li>
								<li>分期付款</li>
								<li>邮局汇款</li>
								<li>公司转账</li>
							</ul>
						</div>
						<div class="yui3-u-1-6">
							<h4>售后服务</h4>
							<ul class="unstyled">
								<li>售后政策</li>
								<li>价格保护</li>
								<li>退款说明</li>
								<li>返修/退换货</li>
								<li>取消订单</li>
							</ul>
						</div>
						<div class="yui3-u-1-6">
							<h4>特色服务</h4>
							<ul class="unstyled">
								<li>夺宝岛</li>
								<li>DIY装机</li>
								<li>延保服务</li>
								<li>品优购E卡</li>
								<li>品优购通信</li>
							</ul>
						</div>
						<div class="yui3-u-1-6">
							<h4>帮助中心</h4>
							<img src="/img/wx_cz.jpg">
						</div>
					</div>
				</div>
				<div class="Mod-copyright">
					<ul class="helpLink">
						<li>关于我们<span class="space"></span></li>
						<li>联系我们<span class="space"></span></li>
						<li>关于我们<span class="space"></span></li>
						<li>商家入驻<span class="space"></span></li>
						<li>营销中心<span class="space"></span></li>
						<li>友情链接<span class="space"></span></li>
						<li>关于我们<span class="space"></span></li>
						<li>营销中心<span class="space"></span></li>
						<li>友情链接<span class="space"></span></li>
						<li>关于我们</li>
					</ul>
					<p>地址：北京市昌平区建材城西路金燕龙办公楼一层 邮编：100096 电话：400-618-4000 传真：010-82935100</p>
					<p>京ICP备08001421号京公网安备110108007702</p>
				</div>
			</div>
		</div>
	</div>
	<!--页面底部END-->

	<script type="text/javascript" src="/js/plugins/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.easing/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/js/plugins/sui/sui.min.js"></script>
	<script type="text/javascript" src="/js/widget/nav.js"></script>
</body>

</html>
<script>
	// 全选
	function checkAll()
	{
		console.log($("input[name='goods[]']"))
		$("input[name='goods[]']").trigger('click')
	}

	// 数量减
	function minus(num)
	{
		// 获取数量
		var stock = $($('.itxt')[num]).val()
		// 获取单价
		var price = $($('.price')[num]).text()
		// 获取小计
		var sum_price = $($('.sum')[num]).text()
		if(stock>1)
		{
			stock--
			// 重新计算小计
			sum_price = stock * price
		}
		// 把新数量放回框中
		$($('.itxt')[num]).val(stock)
		// 把新计算的小计放回框中
		$($('.sum')[num]).text(sum_price)
	}
	// 数量加
	function add(num)
	{
		// 获取数量
		var stock = $($('.itxt')[num]).val()
		// 获取单价
		var price = $($('.price')[num]).text()
		// 获取小计
		var sum_price = $($('.sum')[num]).text()
		stock++;
		// 重新计算小计
		sum_price = price * stock
		// 新数量放回框中
		$($('.itxt')[num]).val(stock)
		// 新小计放回框中
		$($('.sum')[num]).text(sum_price)
	}
	var goods = document.getElementsByName('goods')
	var sum_price = 0;
	$('.summoney').html('￥'+sum_price)
	function getgoods(obj)
	{
		if($(obj)[0].checked)
		{
			$(obj).parent().parent().children().children('.itxt').attr('name','stock[]')
			var price = ($(obj).parent().parent().children()[4].innerText*1)
			sum_price = price + sum_price
			$('.summoney').html('￥'+sum_price)
		}
		else
		{
			$(obj).parent().parent().children().children('.itxt').removeAttr('name')
			var price = ($(obj).parent().parent().children()[4].innerText*1)
			sum_price = sum_price - price
			$('.summoney').html('￥'+sum_price)
		}
		
	}
	
	
</script>