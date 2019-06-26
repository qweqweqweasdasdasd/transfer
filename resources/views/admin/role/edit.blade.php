@extends('admin/common/layout')
@section('content')
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
    <input type="hidden" name="r_id" value="{{$role->r_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->r_name}}" placeholder="请输入角色名称"  name="r_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->desc}}" placeholder="写点备注吧"  name="desc">
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius" ><i class="icon-ok"></i> 确定</button>
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
    var r_id = $('input[name="r_id"]').val();
    $.ajax({
        url:'/admin/role/'+r_id,
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