<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/18/2019
 * Time: 9:48 AM
 */

namespace Modules\Product\Http\Api;

use MyCore\Api\ApiAbstract;

class General extends ApiAbstract
{
    public function uploadGeneral(array $data = [])
    {
        return $this->baseClientUpload('filemanager/upload-general', $data);
    }
}