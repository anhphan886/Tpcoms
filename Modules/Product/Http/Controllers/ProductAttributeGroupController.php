<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\attributeGroup\Store;
use Modules\Product\Http\Requests\attributeGroup\Update;
use Modules\Product\Repositories\AttributeGroup\AttributeGroupRepositoryInterface;

class ProductAttributeGroupController extends Controller
{
    protected $attributeGroup;

    public function __construct(
        AttributeGroupRepositoryInterface $attributeGroup

    ) {
        $this->attributeGroup = $attributeGroup;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $data = $this->attributeGroup->getList($filter);
        return view('product::product-attribute-group.index',[
            'list' => $data['list'],
            'filter' => $data['filter'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('product::product-attribute-group.add');
    }

    public function store(Store $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->attributeGroup->store($data);

        return response()->json($result);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $detail = $this->attributeGroup->getItem($id);
        if ($detail == null) {
            return redirect('error-404');
        }
        return view(
            'product::product-attribute-group.detail', [
            'detail' => $detail,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $detail = $this->attributeGroup->getItem($id);
        if ($detail == null) {
            return redirect('error-404');
        }
        return view(
            'product::product-attribute-group.edit', [
            'detail' => $detail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Update $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->attributeGroup->update($data);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        return $this->attributeGroup->destroy($id);
    }
}
