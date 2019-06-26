@extends('admin/common/layout')
@section('content')
<article class="page-container">
	<form class="form form-horizontal">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">选取管理名称：</label>
		<div class="formControls col-xs-8 col-sm-9"> 
            <span class="select-box" >
			<select class="select" name="mg_id" size="1">
				@foreach($WorkManagers as $k=>$v)
                <option value="{{$k}}">&nbsp;{{$v}}</option>
				@endforeach
			</select>
			</span> </div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">输入密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  placeholder="重置密码" name="password">
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
    $.ajax({
        url:'/admin/password',
        data:data,
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
                layer.alert(res.msg,function(){
					parent.self.location = parent.self.location;
				})
            }
        }
    })
});
</script>
@endsection
