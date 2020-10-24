<?php

namespace Modules\Vcloud\Repositories\Vcloud;
use Modules\Vcloud\Repositories\Vcloud\VcloudRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Repositories\Customer\CustomerRepositoryInterface;

class VcloudRepository implements VcloudRepositoryInterface
{
    protected $service;
    public function __construct(
        CustomerRepositoryInterface $service
    )
    {
        $this->service = $service;
    }
    public function getDetail($customer_service_id){
        $detail = $this->service->getDetail($customer_service_id);
        $customerId = $detail['customer_id'];
        $serviceDetail = $this->service->detail($customerId);
        $orgName = $serviceDetail['customer_no'];
        $serviceName = 'SERVICE_'.$customer_service_id;
        $vcloudData = $this->vcloudApi->getAll([
            'org_name' => $orgName,
            'service_code' => $serviceName
        ]);
        return $vcloudData;
    }

    public function doAction($action, $customer_service_id){
        $detail = $this->service->getDetail($customer_service_id);
        $customerId = $detail['customer_id'];
        $serviceDetail = $this->service->detail($customerId);
        $orgName = $serviceDetail['customer_no'];
        $serviceName = 'SERVICE_'.$customer_service_id;
        $vcloudData = $this->vcloudApi->doAction([
            'object' => 'vm',
            'action' => $action,
            'vapp_name' => DEFAULT_VAPP,
            'org_name' =>  $orgName,
            'vm_name' => $serviceName
        ]);
        return $vcloudData;
    }
    public function createVApp($customer_service_id){
        $detail = $this->service->getDetail($customer_service_id);
        $customerId = $detail['customer_id'];
        $serviceDetail = $this->service->detail($customerId);
        $orgName = $serviceDetail['customer_no'];
        $cpu = 2;
        $memory = 4;
        $disk = 50;
        $vcloudData = $this->vcloudApi->createVm([
            'org_name' =>  $orgName,
            'service_code' => $customer_service_id,
            'cpu' => $cpu,
            'memory' => $memory,
            'disk' => $disk
        ]);
        return $vcloudData;
    }
    public function createOrg($customerNo){
        $vcloudData = $this->vcloudApi->createFullOrg([
            'org_name' => $customerNo,
            'description' =>$customerNo,
            'full_name' =>$customerNo,
        ]);
        return $vcloudData;
    }
    public function configFirewall($customerNo){
        $vcloudData = $this->vcloudApi->configFirewall([
            'org_name' => $customerNo
        ]);
        return $vcloudData;
    }
}
