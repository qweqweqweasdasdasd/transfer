@extends('admin/common/layout')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
    <input type="hidden" name="p_id" value="{{$permission->p_id}}">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">权限名称：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$permission->p_name}}" placeholder="输入权限名称" name="p_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">路由：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  value="{{$permission->route}}" placeholder="输入路由地址(顶级权限不用填写)" name="route">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">控制器方法：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  value="{{$permission->rule}}" placeholder="输入控制器和方法(顶级权限不用填写)" name="rule">
		</div>
	</div>
    <div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">父级权限id: </label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" >
			<select class="select" name="pid" size="1">
				<option value="0">/</option>
				@foreach($tree as $v)
				<option value="{{$v['p_id']}}" @if($permission->pid == $v['p_id']) selected @endif>{{ str_repeat('├─',($v['level']-1)).$v['p_name']}}</option>
				@endforeach
			</select>
			</span> </div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">是否需要验证：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="check" type="radio" id="check-1" value="1" @if($permission->check == 1) checked @endif>
				<label for="check-1">是</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="check-2" name="check" value="2"  @if($permission->check == 2) checked @endif>
				<label for="check-2">否</label>
			</div>
		</div>
	</div>
    <div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">是否显示：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="status" type="radio" id="status-1" value="1"  @if($permission->status == 1) checked @endif>
				<label for="status-1">显示</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="status-2" name="status" value="2"  @if($permission->status == 2) checked @endif>
				<label for="status-2">隐藏</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('my-js')
<script>
$('form').on('submit',function(evt){
    evt.preventDefault();
    var data = $(this).serialize();
    var p_id = $('input[name="p_id"]').val();
    
    $.ajax({
        url:'/admin/permission/' + p_id,
        data:data,
        dataType:'json',
        type:'PATCH',
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
                layer.alert(res.msg,function(){
					parent.self.location = parent.self.location;
				})
            }
        }
    })
});
</script>
@endsection