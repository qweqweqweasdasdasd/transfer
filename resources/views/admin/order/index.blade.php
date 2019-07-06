@extends('admin/common/layout')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> {{$pathInfo['model']}} <span class="c-gray en">&gt;</span> {{$pathInfo['controller']}} <span class="c-gray en">&gt;</span> {{$pathInfo['method']}} <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form>
	<div class="text-c">
	    <span class="select-box inline">
		<select name="type" class="select" style="width:130px;">
			<option value="0">全部支付方式</option>
			<option value="wechat" @if($whereData['type'] == 'wechat') selected @endif>wechat</option>
			<option value="alipay" @if($whereData['type'] == 'alipay') selected @endif>alipay</option>
		</select>
		</span> 
        <span class="select-box inline">
		<select name="status" class="select" style="width:130px;">
			<option value="" >全部状态</option>
			<option value="1" @if($whereData['status'] == '1') selected @endif>支付成功</option>
			<option value="2" @if($whereData['status'] == '2') selected @endif>账号无效</option>
            <option value="3" @if($whereData['status'] == '3') selected @endif>请求上分接口</option>
            <option value="4" @if($whereData['status'] == '4') selected @endif>上分成功</option>
            <option value="5" @if($whereData['status'] == '5') selected @endif>补单成功</option>
            <option value="6" @if($whereData['status'] == '6') selected @endif>不明原因失败</option>
		</select>
		</span>
        <span class="select-box inline">
		<select name="limit" class="select" style="width:130px;">
			<option value="">显示数量</option>
			<option value="50" @if($whereData['limit'] == '50') selected @endif>50</option>
			<option value="300" @if($whereData['limit'] == '300') selected @endif>300</option>
            <option value="500" @if($whereData['limit'] == '500') selected @endif>500</option>
            <option value="1000" @if($whereData['limit'] == '1000') selected @endif>1000</option>
		</select>
		</span>
        <!-- 日期范围：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate" style="width:180px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:180px;"> -->
		<input type="text" name="keyword" value="{{$whereData['keyword']}}" placeholder=" 请输入订单或会员账号或商户号" style="width:300px" class="input-text">
		<button class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 确认</button>
	</div>
    </form>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class='l'></span>
    <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
			<thead>
				<tr class="text-c">
					<th width="50">ID</th>
					<th width="100">会员账号</th>
					<th width="80">支付类型</th>
					<th width="250">订单号</th>
					<th width="80">支付金额</th>
					<th width="100">mch_id</th>
                    <!-- <th width="60">shopId</th> -->
                    <!-- <th width="60">account</th> -->
                    <th>描述</th>
					<th width="130">支付时间</th>
                    <th width="80">状态</th>
				</tr>
			</thead>
			<tbody>
                @foreach($orders as $v)
				<tr class="text-c">
					<td>{{$v->order_id}}</td>
					<td>{{$v->mark}}</td>
					<td>{{$v->type}}</td>
					<td>{{$v->order_no}}</td>
					<td>{{$v->money}}</td>
					<td>{{$v->mch_id}}</td>
                    <!-- <td>{{$v->shopId}}</td> -->
                    <!-- <td>{{$v->account}}</td> -->
                    <td>{{$v->desc}}</td>
					<td>{{$v->dt}}</td>
                    <td>{!! CommonDepositStatus($v->status) !!}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
        {{ $orders->appends(['limit' => $whereData['limit'],'type' => $whereData['type'],'status' =>$whereData['status'],'keyword' =>$whereData['keyword'] ])->links() }}
	</div>
</div>
@endsection
@section('my-js')

@endsection