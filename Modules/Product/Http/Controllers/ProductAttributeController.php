<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\attribute\Store;
use Modules\Product\Http\Requests\attribute\Update;
use Modules\Product\Repositories\Attribute\AttributeRepositoryInterface;
use Modules\Product\Repositories\AttributeGroup\AttributeGroupRepositoryInterface;

class ProductAttributeController extends Controller
{
    protected $attribute;

    public function __construct(
        AttributeRepositoryInterface $attribute

    ) {
        $this->attribute = $attribute;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $data = $this->attribute->getList($filter);
        $attributeGroup = $this->attribute->attributeOption();
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;
        return view(
            'product::product-attribute.index', [
            'list'           => $data['list'],
            'filter'         => $data['filter'],
            'attributeGroup' => $attributeGroup,
            'perpage' => $perpage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $attributeGroup = $this->attribute->attributeOption();
        return view(
            'product::product-attribute.add', [
            'attributeGroup' => $attributeGroup
        ]);
    }

    public function store(Store $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->attribute->store($data);

        return response()->json($result);
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($code)
    {
        $detail = $this->attribute->getItemByCode($code);
        $attributeGroup = $this->attribute->attributeOption();
        if ($detail == null) {
            return redirect()->route('product.product-attribute');
        }
        return view(
            'product::product-attribute.detail', [
            'attributeGroup' => $attributeGroup,
            'detail' => $detail,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($code)
    {
        $detail = $this->attribute->getItemByCode($code);
        $attributeGroup = $this->attribute->attributeOption();
        if ($detail == null) {
            return redirect()->route('product.product-attribute');
        }
        return view(
            'product::product-attribute.edit', [
            'attributeGroup' => $attributeGroup,
            'detail' => $detail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Update $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->attribute->update($data);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        return $this->attribute->destroy($id);
    }
}
