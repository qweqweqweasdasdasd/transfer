<?php

namespace App\Http\Controllers\Admin;

use app\Libs\ResponseJson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;

class PermissionController extends Controller
{
    //仓库
    protected $permissionRepository;

    //构造函数
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pathInfo = $this->permissionRepository->getCurrentPathInfo();
        $tree = generateTree($this->permissionRepository->getPermission());
        $count = $this->permissionRepository->getCount();
        //dump($tree);
        return view('admin.permission.index',compact('pathInfo','tree','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tree = generateTree($this->permissionRepository->getPermission());
        //dump($tree);
        return view('admin.permission.create',compact('tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        //添加层级数据
        $data = $this->permissionRepository->dataAddLevel($request->all());

        //创建数据
        if($this->permissionRepository->CommonSave($data)){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.5000')); 
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.5001'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tree = generateTree($this->permissionRepository->getPermission());
        $permission = $this->permissionRepository->CommonFirst($id);
        //dump($permission);
        return view('admin.permission.edit',compact('tree','permission'));
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
        //添加层级数据
        $data = $this->permissionRepository->dataAddLevel($request->all());
        //创建数据
        if($this->permissionRepository->CommonUpdate($id,$data)){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.5005')); 
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.5006'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //判断删除的该权限是否有子权限
        if($this->permissionRepository->existNotSon($id)){
            //执行删除
            if($this->permissionRepository->CommonDelete($id)){
                return ResponseJson::JsonData(config('code.success'),config('code.msg.5002')); 
            };
            return ResponseJson::JsonData(config('code.error'),config('code.msg.5004'));
        }
        return ResponseJson::JsonData(config('code.error'),config('code.msg.5003'));
    }
}
