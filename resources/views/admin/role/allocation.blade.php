@extends('admin/common/layout')
@section('content')
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
        <input type="hidden" name="r_id" value="{{$role->r_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->r_name}}" readonly="readonly">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">权限名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@foreach($permission_i as $v)
                <dl class="permission-list">
					<dt>
						<label>
							<input type="checkbox" value="{{$v->p_id}}" name="p[]"  @if(in_array($v->p_id,$permissionIdArr)) checked @endif  >
							{{$v->p_name}}</label>
					</dt>
					<dd>
                        @foreach($permission_ii as $vv)
                        @if($vv->pid == $v->p_id)
						<dl class="cl permission-list2">
							<dt>
								<label class="">
									<input type="checkbox" value="{{$vv->p_id}}" name="p[]"  @if(in_array($vv->p_id,$permissionIdArr)) checked @endif>
									{{$vv->p_name}}</label>
							</dt>
							<dd>
                                @foreach($permission_iii as $vvv)
								@if($vvv->pid == $vv->p_id)
								<label class="">
									<input type="checkbox" value="{{$vvv->p_id}}" name="p[]"  @if(in_array($vvv->p_id,$permissionIdArr)) checked @endif>
									{{$vvv->p_name}}</label>
								@endif
								@endforeach
							</dd>
						</dl>
                        @endif
                        @endforeach
					</dd>
				</dl>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>
@endsection
@section('my-js')
<script>
$(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
	
});

$('form').on('submit',function(evt){
    evt.preventDefault();
    var data = $(this).serialize();
    var r_id = $('input[name="r_id"]').val();
    $.ajax({
        url:'/admin/role/permission/'+r_id,
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