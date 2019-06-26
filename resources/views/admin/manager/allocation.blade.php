@extends('admin/common/layout')
@section('content')
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" >
    <input type="hidden" name="mg_id" value="{{$manager->mg_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">所属角色：</label>
			<div class="formControls col-xs-8 col-sm-9">
                @foreach($role as $v)
				<dl class="permission-list">
					<dt>
						<label>
							<input type="checkbox" value="{{$v->r_id}}" name="r_id[]" @if(in_array($v->r_id,$r_ids_arr)) checked @endif>
							{{$v->r_name}}</label>
                             : {{$v->desc}}
					</dt>
				</dl>
                @endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius"><i class="icon-ok"></i> 确定</button>
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
        url:'/admin/allocation/'+mg_id,
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