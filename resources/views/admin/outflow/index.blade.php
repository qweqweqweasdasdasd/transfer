@extends('admin/common/layout')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> {{$pathInfo['model']}} <span class="c-gray en">&gt;</span> {{$pathInfo['controller']}} <span class="c-gray en">&gt;</span> {{$pathInfo['method']}} <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		<form >
			<span class="select-box inline">
				<select name="status" class="select" style="width:130px;">
					<option value="0" >全部状态</option>
					<option value="1" @if($data['status'] == 1) selected @endif>生成订单</option>
					<option value="2" @if($data['status'] == 2) selected @endif>请求失败</option>
					<option value="3" @if($data['status'] == 3) selected @endif>转账失败</option>
					<option value="4" @if($data['status'] == 4) selected @endif>转账成功</option>
				</select>
			</span>&nbsp; - &nbsp;
			<span class="select-box inline">
				<select name="account_type" class="select" style="width:130px;">
					<option value="0">全部出款方式</option>
					<option value="1" @if($data['account_type'] == 1) selected @endif>支付宝</option>
					<option value="2" @if($data['account_type'] == 2) selected @endif>网银银行</option>
				</select>
			</span>&nbsp; - &nbsp;
			<span class="select-box inline">
				<select name="account" class="select" style="width:150px;">
					<option value="0">出款使用账号</option>
					<option value="1">出款账号1</option>
					<option value="2">出款账号2</option>
				</select>
			</span>
		
        日期范围 ：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate" style="width:150px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:150px;">
		<input type="text" name="order_no" placeholder="根据订单&会员账号" style="width:250px" class="input-text" value="{{$data['order_no']}}">
		<button class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
		</form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> ajax 实时获取到数据 </span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
			<thead>
				<tr class="text-c">
					<th width="80">ID</th>
					<th width="120">会员账号</th>
					<th width="100">出款金额</th>
					<th width="100">出款方式</th>
					<th width="250">订单号</th>
					<th width="250">出款账号</th>
					<th width="250">用户账号</th>
					<th >备注</th>
					<th width="60">状态</th>
				</tr>
			</thead>
			<tbody>
				@foreach($outflow as $v)
				<tr class="text-c">
					<td>{{$v->out_id}}</td>
					<td>{{$v->username}}</td>
					<td>{{$v->money}}</td>
					<td>{!!OutflowWayStatus($v->account_type)!!}</td>
					<td>{{$v->order_no}}</td>
					<td>{{$v->account}}</td>
					<td>{{$v->to_account}}</td>
					<td>{{$v->desc}}</td>
					<td class="td-status">{!!OutflowStatusShow($v->status)!!}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<span class="r">{{ $outflow->appends(['status'=>$data['status'],'account_type'=>$data['account_type'],'account' => $data['account'],'order_no'=>$data['order_no']])->links() }}</span> 
	</div>
</div>
@endsection
@section('my-js')
<script>
	setInterval(function(){
		self.location.href = self.location.href
		console.log('ok');
	},8000)
</script>
@endsection