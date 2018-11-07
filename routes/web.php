<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 测试
Route::get('/test','TestController@index')->name('test');
Route::post('/a1','TestController@test')->name('a');

// 登录
Route::get('/login','LoginController@login')->name('login');
Route::post('/login','LoginController@dologin')->name('dologin');

Route::middleware(['login'])->group(function(){

    Route::get('/','IndexController@index')->name('index');

    Route::get('/admin/home',function(){
        return view('home');
    });

    // 个人信息
    Route::get('/info',function(){
        return view('info');
    });

    // 网站设置
    Route::get('/systems',function(){
        return view('systems');
    });

    Route::post('/seller/doadd','SellerController@doadd')->name('ShopdoAdd'); // 商品添加
     
    // 产品管理
    Route::get('/product/list','ProductController@list')->name('ProductList'); // 产品列表
    Route::get('/product/picture_add','ProductController@picture_add')->name('ProductAdd'); // 产品添加

    Route::get('/product/manage','ProductController@manage')->name('ProductManage'); // 品牌管理
    Route::get('/product/manage_add','ProductController@manage_add')->name('ProductManageAdd'); // 品牌添加
    Route::post('/product/manage_add','ProductController@domanage_add')->name('ProductDoManageAdd'); // 品牌添加

    Route::get('/product/category','ProductController@category')->name('ProductCategory'); // 分类管理
    Route::get('/product/category_add','ProductController@category_add')->name('ProductCategory_add'); // 分类添加

    // 广告管理
    Route::get('/adv/adv','AdvController@adv')->name('adv'); // 广告管理
    Route::get('/adv/sort_ads','AdvController@sort_ads')->name('sort_ads'); // 分类管理

    // 交易管理
    Route::get('/trade/payInfo','TradeController@payInfo')->name('PayInfo'); // 支付信息
    Route::get('/trade/order_chart','TradeController@order_chart')->name('order_chart'); // 交易订单（图）
    Route::get('/trade/orderform','TradeController@orderform')->name('orderform'); // 订单管理
    Route::get('/trade/amounts','TradeController@amounts')->name('amounts'); // 交易金额
    Route::get('/trade/order_handling','TradeController@order_handling')->name('order_handling'); // 订单处理
    Route::get('/trade/refund','TradeController@refund')->name('refund'); // 退款管理

    // 支付管理
    Route::get('/pay/account','PayController@account')->name('PayAccount'); // 账户管理
    Route::get('/pay/method','PayController@method')->name('PayMethod'); // 支付方式
    Route::get('/pay/configure','PayController@configure')->name('PayConfigure'); // 支付配置

    // 会员管理
    Route::get('/member/list','MemberController@list')->name('MemberList'); // 会员列表
    Route::get('/member/grading','MemberController@grading')->name('MemberGrading'); // 等级管理
    Route::get('/member/record','MemberController@record')->name('MemberRecord'); // 等级管理

    // 店铺管理
    Route::get('/shop/list','ShopController@list')->name('ShopList'); // 店铺列表
    Route::get('/shop/audit','ShopController@audit')->name('ShopAudit'); // 店铺审核
    Route::get('/shop/detailed/{id}','ShopController@detailed')->name('ShopDetailed'); // 店铺审核详情页
    Route::get('/shop/mail','ShopController@pass')->name('ShopSend'); // 审核结果

    // 消息管理
    Route::get('/info/list','InfoController@guestbook')->name('InfoGuestbook'); // 店铺列表
    Route::get('/info/feedback','InfoController@feedback')->name('InfoFeedback'); // 反馈列表

    // 文章管理
    Route::get('/article/list','ArticleController@list')->name('ArticleList'); // 文章列表
    Route::get('/article/sort','ArticleController@sort')->name('ArticleSort'); // 分类列表

    // 系统管理
    Route::get('/systems/set','SystemsController@set')->name('SystemsSet'); // 系统设置
    Route::get('/systems/column','SystemsController@column')->name('SystemsColumn'); // 系统栏目管理
    Route::get('/systems/log','SystemsController@log')->name('SystemsLog'); // 系统日志


    // 管理员管理 
    Route::get('/admin/changePwd','AdminController@changePwd')->name('AdminchangePwd'); // 修改密码
    Route::get('/admin/competence','AdminController@competence')->name('AdminCompetence'); // 权限管理
    Route::get('/admin/cpAdd','AdminController@cpAdd')->name('AdmincpAdd'); // 添加权限
    Route::post('/admin/cpAdd','AdminController@doCpAdd')->name('AdmindoCpAdd'); // 添加权限
    
    Route::get('/admin/cpEdit/{id}','AdminController@cpEdit')->name('AdmincpEdit'); // 修改权限
    Route::post('/admin/cpEdit/{id}','AdminController@doCpEdit')->name('AdmindoCpEdit'); // 修改权限

    Route::get('/admin/cpDel','AdminController@cpDel')->name('AdmincpDel'); // 删除权限

    Route::get('/admin/list','AdminController@list')->name('AdminList'); // 管理员列表

    Route::get('/admin/stop','AdminController@stop')->name('AdminStop'); // 禁用管理员
    Route::get('/admin/start','AdminController@start')->name('AdminStart'); // 开启管理员
    Route::get('/admin/del','AdminController@del')->name('AdminDel'); // 删除管理员
    Route::post('/admin/add','AdminController@adminAdd')->name('AdminAdd'); // 添加管理员

    Route::get('/admin/info','AdminController@info')->name('AdminInfo'); // 个人信息



    // 前台
    Route::get('/home','Home\IndexController@index')->name("HomeIndex");    //主页
    Route::get('/home/search/{cate_id}','Home\IndexController@search')->name("HomeSearch");    //搜索页


});