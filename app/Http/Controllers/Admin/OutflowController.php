<?php

namespace App\Http\Controllers\Admin;

use app\Libs\ResponseJson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OutflowRepository;

class OutflowController extends Controller
{
    //仓库
    protected $outflowRepository;

    //构造函数
    public function __construct(OutflowRepository $outflowRepository)
    {
        $this->outflowRepository = $outflowRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'status' => !empty($request->get('status'))? trim($request->get('status')) :'',
            'account_type' => !empty($request->get('account_type'))? trim($request->get('account_type')) :'',
            'account' => !empty($request->get('account'))? trim($request->get('account')) :'',
            'order_no' => !empty($request->get('order_no'))? trim($request->get('order_no')) :'',
        ];
            
        $pathInfo = $this->outflowRepository->getCurrentPathInfo();
        $outflow = $this->outflowRepository->getOutflow($data);
        $count = $this->outflowRepository->getCount($data);
        
        return view('admin.outflow.index',compact('outflow','pathInfo','count','data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
