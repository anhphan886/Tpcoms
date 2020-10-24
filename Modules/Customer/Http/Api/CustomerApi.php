<?php

namespace Modules\Customer\Http\Api;

use MyCore\Api\ApiAbstract;

class CustomerApi extends ApiAbstract
{
    /**
     * Lấy danh sách khách hàng không phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->baseClient('customer/list-all', $filters);
    }

    /**
     *  lấy chi tiết khách khàng
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public  function getDetail(array $filters = [])
    {
        return $this->baseClient('customer/detail', $filters);
    }
}
