@extends('admin/common/layout')
@section('content')
<article class="page-container">
	<form class="form form-horizontal">
	<input type="hidden" name="mg_id" value="{{$manager->mg_id}}">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">管理员名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  placeholder="输入管理员名称"  name="mg_name" value="{{$manager->mg_name}}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">状态：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="status" type="radio" id="status-1" value="1" @if($manager->status == 1) checked @endif>
				<label for="status-1">开启</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="status-2" name="status" value="2" @if($manager->status == 2) checked @endif>
				<label for="status-2">关闭</label>
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
	var mg_id = $('input[name="mg_id"]').val();
    $.ajax({
        url:'/admin/manager/' + mg_id,
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
