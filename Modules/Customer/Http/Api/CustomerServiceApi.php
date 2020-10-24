<?php

namespace Modules\Customer\Http\Api;

use MyCore\Api\ApiAbstract;

class CustomerServiceApi extends ApiAbstract
{
    /**
     * Lấy danh sách customer service
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->baseClient('customer/service/list-all', $filters);
    }
}
