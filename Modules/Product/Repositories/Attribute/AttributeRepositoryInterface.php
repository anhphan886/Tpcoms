<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/13/2019
 * Time: 12:08 PM
 */

namespace Modules\Product\Repositories\Attribute;


interface AttributeRepositoryInterface
{
    public function getList(array $filters = []);

    public function store(array $data = []);

    public function update(array $data = []);

    public function attributeOption();

    public function destroy($id);

    public function getItem($id);

    public function getItemByCode($code);

    public function getDetailAttribute($customer_service_id);
}
