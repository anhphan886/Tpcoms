<?php

namespace Modules\Product\Http\Api;

use MyCore\Api\ApiAbstract;

class ProductApi extends ApiAbstract
{
    /**
     * Lấy danh sách sản phẩm/dịch vụ không phân trang
     *
     * @param array $filters
     * @return mixed
     * @throws \MyCore\Api\ApiException
     */
    public function getListAll(array $filters = [])
    {
        return $this->baseClient('product/list-all', $filters);
    }
}
