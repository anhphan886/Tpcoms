<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/18/2019
 * Time: 9:48 AM
 */

namespace Modules\Product\Http\Api;

use MyCore\Api\ApiAbstract;

class Address extends ApiAbstract
{
    public function optionProvince(array $data = [])
    {
        return $this->baseClient('/option-province', $data);
    }

    public function optionDistrict(array $data = [])
    {
        return $this->baseClient('/option-district', $data);
    }
}