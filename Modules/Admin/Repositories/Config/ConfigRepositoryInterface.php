<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/25/2019
 * Time: 11:53 AM
 */

namespace Modules\Admin\Repositories\Config;


interface ConfigRepositoryInterface
{
    public function getAll();

    public function update(array $data = []);

    public function getConfigRemindReceipt();

}