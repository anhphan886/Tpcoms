<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Repositories\Config\ConfigRepositoryInterface;

class ConfigController extends Controller
{
    protected $config;

    public function __construct(ConfigRepositoryInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Index
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {
        $configRemindReceipt = $this->config->getConfigRemindReceipt();
        $configRemindReceipt->setAttribute('array_value', explode(',', $configRemindReceipt['value']));
        $allConfig = $this->config->getAll();
        return view(
            'admin::config.index',
            [
                'configRemindReceipt' => $configRemindReceipt,
                'allConfig' => $allConfig
            ]
        );
    }

    public function update(Request $request)
    {
        $data = $request->all();
        return $this->config->update($data);
    }
}
