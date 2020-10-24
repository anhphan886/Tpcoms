@@ -1,60 +0,0 @@
<?php

namespace Modules\Vcloud\Http\Api;

use MyCore\Api\ApiAbstract;

class VcloudApi extends ApiAbstract
{
    /**
     * Hành động trên VM, VApp
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function doAction(array $data = [])
    {
        return $this->baseClient('api/vcloud/org/action', $data);
    }
    /**
     * get thông tin VM
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getAll(array $data = []){
        return $this->baseClient('api/vcloud/vms/get-vms', $data);
    }
    /**
     * Tạo vm , vapp
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function createVm(array $data = []){
        return $this->baseClient('api/vcloud/vms/create-vapp-curl', $data);
    }
    /**
     * Tạo org
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function createFullOrg(array $data = []){
        return $this->baseClient('api/vcloud/org/create', $data);
    }
    /**
     * Config firewall
     *
     * @param array $data
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function configFirewall(array $data = []){
        return $this->baseClient('api/vcloud/vms/config-firewall', $data);
    }
}
