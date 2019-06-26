@extends('admin/common/layout')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> {{$pathInfo['model']}} <span class="c-gray en">&gt;</span> {{$pathInfo['controller']}} <span class="c-gray en">&gt;</span> {{$pathInfo['method']}} <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="">
		<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> 
    <span class="l">
        <a href="javascript:;" onclick="pwd('重置密码','/admin/password','800','500')" class="btn btn-success  radius"><i class="Hui-iconfont">&#xe63f;</i> 重置密码</a> 
        <a href="javascript:;" onclick="add('添加管理员','/admin/manager/create','800','500')" class="btn btn-success  radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>
    </span> 
    <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg ">
		<thead>
			<tr>
				<th scope="col" colspan="9">管理员列表</th>
			</tr>

			<tr class="text-c">
				<th width="40">ID</th>
				<th width="150">管理员名称</th>
				<th width="120">IP</th>
				<th width="150">登陆次数</th>
				<th>角色列表</th>
				<th width="130">最后登录时间</th>
				<th width="100">状态</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
            @foreach($getManagers as $v)
			<tr class="text-c">
				<td>{{$v->mg_id}}</td>
				<td>{{$v->mg_name}}</td>
				<td>{{$v->ip}}</td>
				<td>{{$v->login_counts}}</td>
				<td>
					@foreach($v->roles as $vv)
						{{$vv->r_name}}
					@endforeach
				</td>
				<td>{{$v->last_login_time}}</td>
				<td class="td-status">{!! CommonResetStatus($v->mg_id,$v->status) !!}</td>
				<td class="td-manage">
                    <a title="分配" href="javascript:;" onclick="allocation('角色分配','/admin/allocation/{{$v->mg_id}}','{{$v->mg_id}}','800','500')" href="javascript:;" style="text-decoration:none"><i class="Hui-iconfont">&#xe667;</i></a>
                    <a title="编辑" href="javascript:;" onclick="edit('管理员编辑','/admin/manager/{{$v->mg_id}}/edit','{{$v->mg_id}}','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                    <a title="删除" href="javascript:;" onclick="del(this,'{{$v->mg_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                </td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('my-js')
<script>
/*管理员-分配*/
function allocation(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-增加*/
function add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-重置密码*/
function pwd(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-编辑*/
function edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/admin/manager/'+id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
			},
			success: function(res){
				if(res.code == 1){
					$(obj).parents("tr").remove();
					layer.msg(res.msg,{icon:1,time:1000});
				}
			}
		});		
	});
}
/*管理员-状态*/
$('.reset').on('click',function(evt){
    evt.preventDefault();
    var s = $(this).attr('data-status');
    var mg_id = $(this).attr('data-id');
    
    //ajax
    $.ajax({
        url:'/admin/reset',
        data:{s:s,mg_id:mg_id},
        dataType:'json',
        type:'post',
        headers:{
            'X-CSRF-TOKEN':"{{csrf_token()}}"
        },
        success:function(res){
            if(res.code == 422){
                layer.msg(res.msg)
            }
            if(res.code == 0){
                layer.msg(res.msg)
            }
            if(res.code == 1){
                window.location.href = window.location.href
            }
        }
    })
});
</script>
@endsection