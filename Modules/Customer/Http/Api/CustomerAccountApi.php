<?php

namespace Modules\Customer\Http\Api;

use MyCore\Api\ApiAbstract;

class CustomerAccountApi extends ApiAbstract
{
    /**
     * Lấy danh sách tài khoản khách hàng có phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getList(array $filters = [])
    {
        return $this->baseClient('customer/account/list', $filters);
    }

    /**
     * Lấy danh sách tài khoản khách hàng không phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->baseClient('customer/account/list-all', $filters);
    }

    /**
     * Lấy chi tiết tài khoản khách hàng
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getDetail(array $filters = [])
    {
        return $this->baseClient('customer/account/detail', $filters);
    }
}
