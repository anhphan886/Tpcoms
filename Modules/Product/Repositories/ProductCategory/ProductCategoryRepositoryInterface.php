<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/17/2019
 * Time: 7:45 PM
 */

namespace Modules\Product\Repositories\ProductCategory;


interface ProductCategoryRepositoryInterface
{
    public function getList(array $filters = []);

    public function store(array $data = []);

    public function destroy($id);

    public function getItem($id);

    public function update(array $data = []);
}