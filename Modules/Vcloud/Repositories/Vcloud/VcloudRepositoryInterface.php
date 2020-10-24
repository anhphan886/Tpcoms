<?php

namespace Modules\Vcloud\Repositories\Vcloud;

interface VcloudRepositoryInterface
{
    public function getDetail($customer_service_id);
    public function doAction($action, $customer_service_id);
    public function createVApp($customer_service_id);
    public function createOrg($customer_no);
    public function configFirewall($customer_no);

}
