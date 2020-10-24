<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/14/2019
 * Time: 5:09 PM
 */

namespace Modules\Product\Repositories\Product;


interface ProductRepositoryInterface
{
    public function getList(array $filter = []);

    public function getAttributeGroupOption();

    public function optionSoldTogether();

    public function getAttributeOption($attributeGroup, $arrayIdAttribute);

    public function getOptionAttributeSoldTogether($attributeGroup, $arrayIdAttribute);

    public function getItemAttribute($id);

    public function store(array $data = []);

    public function update(array $data = []);

    public function getProductCategoryOption();

    public function destroy($id);

    public function getItem($id);

    public function getItemByCode($code);

    public function getProductAttributeMap($productId);

    public function getProductAttributeGroupMap($productId);

    public function getItemAttrGroup($productId);

    public function getAttrGroupWhereNotIn($attributeGroup, $arrayIdAttribute);
}
