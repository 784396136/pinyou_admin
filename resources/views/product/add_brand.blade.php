<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加品牌</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <link href="/Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <!--[if IE 7]>
		  <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
    <!--[if lte IE 8]>
		  <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
		<![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.queue.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.speed.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/handlers.js"></script>
</head>

<body>
    <div class="margin clearfix">
        <div class="stystems_style">
            <div class="tabbable"> 
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <form action="{{Route('ProductDoManageAdd')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>选择分类：
                                </label>
                                <div class="col-sm-9">
                                        <select name="cate_id" id="cate_id">
                                            @foreach ($category as $v)
                                                <option value="{{$v->id}}"><?=str_repeat('-',8*$v['level'])?>{{$v->cat_name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>品牌名称：
                                </label>
                                <div class="col-sm-9"><input type="text" name="brand_name" id="cat_name" value="" class="col-xs-3 "></div>
                            </div>
                            <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>品牌logo：
                                </label>
                                <div class="col-sm-9"><input type="file" name="logo" /></div>
                            </div>
                            <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>品牌地址：
                                </label>
                                <div class="col-sm-9">
                                    <input type="radio" name="domestic" value="1"> 国内品牌
                                    <input type="radio" name="domestic" value="0"> 国外品牌
                                </div>
                            </div>
                            <div class="Button_operation">
                                <button class="btn btn-primary radius" type="submit"><i class="fa fa-save "></i>&nbsp;保存</button>

                                <button class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
<script type="text/javascript">
if("{{session('error')}}")
    layer.open({
        icon: 2,
        title: '提示框',
        content: "{{session('error')}}",
    });

</script>