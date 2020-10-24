<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 1/16/2020
 * Time: 2:58 PM
 */

namespace Modules\Admin\Repositories\Config;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\ConfigTable;

class ConfigRepository implements ConfigRepositoryInterface
{
    protected $config;


    public function __construct(ConfigTable $config)
    {
        $this->config = $config;
    }

    public function getAll()
    {
        return $this->config->getAll();
    }

    public function getConfigRemindReceipt()
    {
        return $this->config->getItem(1);
    }

    public function update(array $data = [])
    {
        $dataFormat = [];
        foreach ($data['configRemindReceipt'] as $key => $value) {
            $dataFormat[] =  intval($value);
        }
        if (!isset($data['configRemindReceipt'])) {
            return response()->json(['error' => true]);
        }
        //Kiểm tra trùng input cấu hình nhắc hạn thanh toán phiếu thu
        if ($this->array_has_dupes($dataFormat) == true) {
            return response()->json(['error' => 1]);
        } else if(in_array(0, $dataFormat)) {
            return response()->json(['error' => 2]);
        }


        $fields = [
           'value' => implode($dataFormat, ','),
           'updated_at' => date('Y-m-d H:i:s')
        ];

        $update = $this->config->edit($fields, 1);
        foreach($data as $key => $value){
            if($key == 'configRemindReceipt'){
                continue;
            }
            $this->config->updateByKey($key, $value);
        }
        if ($update) {
            return response()->json(['error' => false]);
        } else {
            return response()->json(['error' => true]);
        }
    }

    /**
     * Function check value trong array có trùng không
     *
     * @param $array
     * @return bool
     */
    function array_has_dupes($array) {
        return count($array) !== count(array_unique($array));
    }
}
