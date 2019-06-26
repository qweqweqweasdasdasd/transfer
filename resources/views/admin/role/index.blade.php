@extends('admin/common/layout')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> {{$pathInfo['model']}} <span class="c-gray en">&gt;</span> {{$pathInfo['controller']}} <span class="c-gray en">&gt;</span> {{$pathInfo['method']}} <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray"> 
    <span class="l"> 
        <a class="btn btn-success radius" href="javascript:;" onclick="admin_role_add('添加角色','/admin/role/create','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> 
    </span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-hover table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="6">角色管理</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="200">角色名</th>
				<th>用户列表</th>
				<th width="300">描述</th>
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($roles as $v)
			<tr class="text-c">
				<td>{{$v->r_id}}</td>
				<td>{{$v->r_name}}</td>
				<td>
				@foreach($v->manager as $vv)
					{{$vv->mg_name}}-@if($vv->status == 1) 启用 @elseif($vv->status == 2) 关闭 @endif
				@endforeach
				</td>
				<td>{{$v->desc}}</td>
				<td class="f-14">
					<a title="分配权限" href="javascript:;" onclick="role_permission_allocation('分配权限','/admin/role/permission/{{$v->r_id}}','1')" style="text-decoration:none"><i class="Hui-iconfont">&#xe667;</i></a>
					<a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','/admin/role/{{$v->r_id}}/edit ','1')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
					<a title="删除" href="javascript:;" onclick="admin_role_del(this,'{{$v->r_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('my-js')
<script>
/*角色-权限-分配*/
function role_permission_allocation(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-添加*/
function admin_role_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-编辑*/
function admin_role_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-删除*/
function admin_role_del(obj,id){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/admin/role/'+id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
			},
			success: function(res){
				if(res.code == 1){
					$(obj).parents("tr").remove();
					layer.msg(res.msg,{icon:1,time:1000});
				}
				if(res.code == 0){
					layer.msg(res.msg,{icon:1,time:1000});
				}
			}
		});		
	});
}
</script>
@endsection