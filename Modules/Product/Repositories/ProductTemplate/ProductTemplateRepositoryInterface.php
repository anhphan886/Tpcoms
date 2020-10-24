<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/14/2019
 * Time: 5:09 PM
 */

namespace Modules\Product\Repositories\ProductTemplate;


interface ProductTemplateRepositoryInterface
{
    public function getList(array $filter = []);

    public function getAttributeGroupOption();

    public function getAttributeOption($attributeGroup, $arrayIdAttribute);

    public function getItemAttribute($id);

    public function store(array $data = []);

    public function update(array $data = []);

    public function getProductCategoryOption();

    public function getProductOption();
    
    public function destroy($id);

    public function getProductAttributeMap($productId);

    public function getItem($productId);

    public function getItemByCode($productCode);

    public function getProductTemplateAttributeMap($productId);

}