@extends('admin/common/layout')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> {{$pathInfo['model']}} <span class="c-gray en">&gt;</span> {{$pathInfo['controller']}} <span class="c-gray en">&gt;</span> {{$pathInfo['method']}} <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> 
    <span class="l">
        <a href="javascript:;" onclick="admin_permission_add('添加权限节点','/admin/permission/create','','310')" class="btn btn-success radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限节点</a>
    </span> 
    <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="7">权限节点</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="200">权限名称</th>
                <th width="200">路由</th>
                <th >控制器和方法</th>
                <th width="120">是否需要验证</th>
                <th width="80">状态</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tree as $v)
			<tr class="text-c">
				<td>{{$v['p_id']}}</td>
				<td class="text-l">{{str_repeat('├─',($v['level']-1)).$v['p_name']}}</td>
                <td>{{$v['route']}}</td>
                <td>{{$v['rule']}}</td>
                <td>{!!CommonStatusShow($v['check'])!!}</td>
				<td>{!!CommonStatusShow($v['status'])!!}</td>
				<td>
                 <a title="编辑" href="javascript:;" onclick="admin_permission_edit('权限编辑','/admin/permission/{{$v['p_id']}}/edit','1','','310')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                 <a title="删除" href="javascript:;" onclick="admin_permission_del(this,'{{$v["p_id"]}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                </td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('my-js')
<script>
/*管理员-权限-添加*/
function admin_permission_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-权限-编辑*/
function admin_permission_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/admin/permission/'+id,
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
					layer.msg(res.msg,{icon:2,time:1000});
				}
			}
		});		
	});
}
</script>
@endsection
