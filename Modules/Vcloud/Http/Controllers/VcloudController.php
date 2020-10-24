<?php

namespace Modules\Vcloud\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Vcloud\Repositories\Vcloud\VcloudRepositoryInterface;

class VcloudController extends Controller
{
    protected $vcloud;
    public function __construct(
        VcloudRepositoryInterface $vcloud
    )
    {
        $this->vcloud = $vcloud;
    }
    /**
     * remote view for vms
     * @param int $id
     * @return Response
     */
    public function remote(Request $request){
        set_time_limit(0);
        return view('vcloud::remote.index');
    }
    /**
     * action to vms
     * @param int $id
     * @return Response
     */
    public function action(Request $request){
        set_time_limit(0);
        $data = $request->validate([
            'action' => 'required',
            'customer_service_id' => 'required'
        ]);
        return $this->vcloud->doAction($data['action'], $data['customer_service_id']);
    }
    /**
     * detail to vms
     * @param int $id
     * @return Response
     */
    public function detail(Request $request){
        set_time_limit(0);
        $data = $request->validate([
            'customer_service_id' => 'required'
        ]);
        return $this->vcloud->getDetail($data['customer_service_id']);
    }
    public function createOrg(Request $request){
        set_time_limit(0);
        $data = $request->validate([
            'customer_no' => 'required'
        ]);
        try{
            return $this->vcloud->createOrg($data['customer_no']);
        }catch(\Exception $e){
            return ['error' => 1];
        }
    }
    public function createVm(Request $request){
        set_time_limit(0);
        $data = $request->validate([
            'customer_service_id' => 'required'
        ]);
        try{
            return $this->vcloud->createVapp($data['customer_service_id']);
        }catch(\Exception $e){
            return ['error' => 1];
        }
    }
    public function configFirewall(Request $request){
        set_time_limit(0);
        $data = $request->validate([
            'customer_no' => 'required'
        ]);
        try{
            return $this->vcloud->configFirewall($data['customer_no']);
        }catch(\Exception $e){
            return ['error' => 1];
        }
    }
}
