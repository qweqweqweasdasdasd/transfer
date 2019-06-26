<?php

namespace App\Http\Controllers\Admin;

use app\Libs\ResponseJson;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Repositories\RoleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;

class RoleController extends Controller
{
    //仓库
    protected $roleRepository;
    protected $permissionRepository;

    //构造函数
    public function __construct(RoleRepository $roleRepository,PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepository->GetRoles();
        $count = $this->roleRepository->GetCount();
        $pathInfo = $this->roleRepository->getCurrentPathInfo();
        //dump($pathInfo);
        return view('admin.role.index',compact('roles','count','pathInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        if($this->roleRepository->CommonSave($request->all())){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.3000')); 
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.3001'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->CommonFirst($id);
        //dump($role);
        return view('admin.role.edit',compact('role'));
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
        $d = [
            'r_name' => $request->get('r_name'),
            'desc' => $request->get('desc')
        ];
        if($this->roleRepository->CommonUpdate($id,$d)){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.3002')); 
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.3003'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->roleRepository->RoleDelete($id)){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.3004')); 
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.3005'));
    }

    //分配权限
    public function allocation(Request $request,$id)
    {
        if($request->isMethod('post')){
            if( empty($request->get('r_id')) || !count($request->get('p')) ){
                return ResponseJson::JsonData(config('code.success'),config('code.msg.3006'));
            }

            //数据同步到中间表 
            if($this->roleRepository->rolePermissionSync($id,$request->get('p'))){
                return ResponseJson::JsonData(config('code.success'),config('code.msg.3008')); 
            };
            return ResponseJson::JsonData(config('code.error'),config('code.msg.3007'));
        }
        //获取到权限列表
        $permission_i   = $this->permissionRepository->byPermissionWithLevel(1);
        $permission_ii  = $this->permissionRepository->byPermissionWithLevel(2);
        $permission_iii = $this->permissionRepository->byPermissionWithLevel(3);
        $role = $this->roleRepository->roleFind($id);
        $permissionIdArr = $role->permission()->pluck('permissions.p_id')->toArray();
        //dump($permissionIdArr);
        return view('admin.role.allocation',compact(
                'permission_i',
                'permission_ii',
                'permission_iii',
                'role',
                'permissionIdArr'
            ));
    }
}
