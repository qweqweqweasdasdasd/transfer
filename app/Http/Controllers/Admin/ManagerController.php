<?php

namespace App\Http\Controllers\Admin;

use Auth;
use app\Libs\ResponseJson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Http\Requests\ManagerRequest;
use App\Repositories\ManagerRepository;

class ManagerController extends Controller
{
    //仓库
    protected $managerRepository;
    protected $roleRepository;

    //构造函数
    public function __construct(ManagerRepository $managerRepository,RoleRepository $roleRepository)
    {
        $this->managerRepository = $managerRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * 管理员列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pathInfo = $this->managerRepository->getCurrentPathInfo();
        $getManagers = $this->managerRepository->GetManagers();
        $count = $this->managerRepository->GetCount();
        //dump($getManagers);
        return view('admin.manager.index',compact('pathInfo','getManagers','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagerRequest $request)
    {
        if($this->managerRepository->ManagerSave($request->all())){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.2002')); 
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.2003'));
    }

    /**
     * 编辑管理员状态
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $d = [
            'status' => $request->get('s')
        ];
        if($this->managerRepository->CommonUpdate($request->get('mg_id'),$d)){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.2000')); 
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.2001'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manager = $this->managerRepository->CommonFirst($id);
        
        return view('admin.manager.edit',compact('manager'));
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
            'mg_name' => $request->get('mg_name'),
            'status' => $request->get('status')
        ];
        if($this->managerRepository->CommonUpdate($id,$d)){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.2007'));
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.2008'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->managerRepository->ManagerDelete($id)){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.2009'));
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.2010'));
    }

    //重置密码
    public function password()
    {
        $WorkManagers = $this->managerRepository->WorkManagers();
        
        return view('admin.manager.password',compact('WorkManagers'));
    }

    //重置密码的逻辑
    public function dopassword(Request $request)
    {
        if(empty($request->get('password'))){
            return ResponseJson::JsonData(config('code.error'),config('code.msg.2004'));
        }

        if($this->managerRepository->dopassword($request->all())){
            return ResponseJson::JsonData(config('code.success'),config('code.msg.2005'));
        };
        return ResponseJson::JsonData(config('code.error'),config('code.msg.2006'));
    }

    //管理员分配角色
    public function allocation(Request $request,$id)
    {
        if($request->isMethod('post')){
            $d = [
                'r_ids' => $request->get('r_id')
            ];
            
            if($this->managerRepository->ManagerAttach($id,$d)){
                return ResponseJson::JsonData(config('code.success'),config('code.msg.2011'));
            };
            return ResponseJson::JsonData(config('code.error'),config('code.msg.2012'));
        }
        $role = $this->roleRepository->GetRoles();
        $manager = $this->managerRepository->ManagerFind($id);
        $r_ids_arr = json_decode($manager->roles->pluck('r_id'),true);
        //dump($r_ids_arr);
        return view('admin.manager.allocation',compact('role','manager','r_ids_arr'));
    }
}
