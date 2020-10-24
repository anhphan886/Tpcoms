<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/13/2019
 * Time: 12:08 PM
 */

namespace Modules\Product\Repositories\AttributeGroup;


interface AttributeGroupRepositoryInterface
{
    public function getList(array $filters = []);

    public function store(array $data = []);

    public function update(array $data = []);

    public function destroy($id);

    public function getItem($id);
}