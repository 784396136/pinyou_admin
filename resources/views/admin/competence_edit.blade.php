<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="/css/style.css" />
	<link href="/assets/css/codemirror.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/ace.min.css" />
	<link rel="stylesheet" href="/font/css/font-awesome.min.css" />
	<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
		<![endif]-->
	<script src="/js/jquery-1.9.1.min.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>
	<script src="/assets/js/typeahead-bs2.min.js"></script>
	<script src="/assets/js/jquery.dataTables.min.js"></script>
	<script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
	<script src="/assets/layer/layer.js" type="text/javascript"></script>
	<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
	<script src="/js/dragDivResize.js" type="text/javascript"></script>
	<title>添加权限</title>
</head>

<body>
	<div class="Competence_add_style clearfix">
		<form action="{{Route('AdmindoCpEdit',['id'=>$o_data->role_id])}}" method="POST">
			@csrf
		<div class="left_Competence_add">

		
			<div class="title_name">添加权限</div>
			<div class="Competence_add">
				<div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 权限名称 </label>
					<div class="col-sm-9"><input type="text" id="form-field-1" value="{{$o_data->role_name}}" name="role_name" class="col-xs-10 col-sm-5"></div>
				</div>
				
				<div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 用户选择 </label>
					<div class="col-sm-9">
						@foreach($info as $v)
							<label class="">
								<input 
								@foreach ($o_data->id_list as $d)
								@if ($v->id==$d)
									checked
								@endif
								@endforeach
								class="ace" name="admin[]" value="{{$v->id}}" type="checkbox" id="id-disable-check"><span class="lbl">{{$v->name}}（{{$v->role_name}}）</span>
							</label><br><br>
						@endforeach
					</div>
				</div>
				<!--按钮操作-->
				<div class="Button_operation">
						<button class="btn btn-primary radius" type="submit">提交</i>
					<button onclick="return_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;返回上一步&nbsp;&nbsp;</button>
				</div>
			</div>
		</div>
		<!--权限分配-->
		<div class="Assign_style">
			<div class="title_name">权限分配</div>
			<div class="Select_Competence">
					@foreach ($data as $v)
						<dl class="permission-list">
								<dt>
									<label class="middle"><input
										@foreach ($o_data->p_list as $p)
											@if ($v->id==$p)
												checked
											@endif
										@endforeach
										value="{{$v->id}}" name="pri_id[]" class="ace" type="checkbox" id="id-disable-check"><span class="lbl">{{$v->pri_name}}</span></label>
								</dt>
								<dd>
									@foreach ($v->child as $v2)
										<dl class="cl permission-list2">
											<dt>
												<label class="middle"><input 
													@foreach ($o_data->p_list as $p)
														@if ($v2->id==$p)
															checked
														@endif
													@endforeach
													type="checkbox" value="{{$v2->id}}" class="ace" name="pri_id[]" id="id-disable-check"><span class="lbl">{{$v2->pri_name}}</span></label>
											</dt>
											<dd>
												@foreach ($v2->child as $v3)
													<label class="middle">
														<input 
														@foreach ($o_data->p_list as $p)
															@if ($v3->id==$p)
																checked
															@endif
														@endforeach
														type="checkbox" value="{{$v3->id}}" class="ace" name="pri_id[]" id="user-Character-0-0-0"><span class="lbl">{{$v3->pri_name}}</span></label>
												@endforeach
											</dd>
										</dl>
									@endforeach
								</dd>
						</dl>
					@endforeach
					
			</div>

		</div>
		</form>
	</div>

</body>

</html>
<script type="text/javascript">
	// 返回上一步
	function return_close()
	{
		location.href="{{Route('AdminCompetence')}}";
	}

	//初始化宽度、高度  
	$(".left_Competence_add,.Competence_add_style").height($(window).height()).val();;
	$(".Assign_style").width($(window).width() - 500).height($(window).height()).val();
	$(".Select_Competence").width($(window).width() - 500).height($(window).height() - 40).val();
	//当文档窗口发生改变时 触发  
	$(window).resize(function () {

		$(".Assign_style").width($(window).width() - 500).height($(window).height()).val();
		$(".Select_Competence").width($(window).width() - 500).height($(window).height() - 40).val();
		$(".left_Competence_add,.Competence_add_style").height($(window).height()).val();;
	});
	/*按钮选择*/
	$(function () {
		$(".permission-list dt input:checkbox").click(function () {
			$(this).closest("dl").find("dd input:checkbox").prop("checked", $(this).prop("checked"));
		});
		$(".permission-list2 dd input:checkbox").click(function () {
			var l = $(this).parent().parent().find("input:checked").length;
			var l2 = $(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
			if ($(this).prop("checked")) {
				$(this).closest("dl").find("dt input:checkbox").prop("checked", true);
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked", true);
			}
			else {
				if (l == 0) {
					$(this).closest("dl").find("dt input:checkbox").prop("checked", false);
				}
				if (l2 == 0) {
					$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked", false);
				}
			}

		});
	});

</script>