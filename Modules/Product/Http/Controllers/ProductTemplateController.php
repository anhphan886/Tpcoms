<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\productTemplate\Store;
use Modules\Product\Http\Requests\productTemplate\Update;
use Modules\Product\Repositories\ProductTemplate\ProductTemplateRepositoryInterface;

class ProductTemplateController extends Controller
{
    protected $productTemple;

    public function __construct(ProductTemplateRepositoryInterface $productTemple)
    {
        $this->productTemple = $productTemple;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $data = $this->productTemple->getList($filter);
        $product = $this->productTemple->getProductOption();
        return view(
            'product::product-template.index', [
                'list'           => $data['list'],
                'filter'         => $data['filter'],
                'product' => $product
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $attributeGroup = $this->productTemple->getAttributeGroupOption();
        $product = $this->productTemple->getProductOption();
        return view('product::product-template.add',[
            'attributeGroup' => $attributeGroup,
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Store $request)
    {
        $data = $request->all();
        $result = $this->productTemple->store($data);
        return $result;
    }

    /**
     * Option attribute
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptionAttribute(Request $request)
    {
        $attributeGroup = intval($request->attributeGroup);
        $arrayIdAttribute = $request->arrayIdAttribute;
        $result = $this->productTemple->getAttributeOption($attributeGroup, $arrayIdAttribute);

        return response()->json($result);
    }

    /**
     * Get detail attribute.
     * @param Request $request
     * @return mixed
     */
    public function getDetailAttribute(Request $request)
    {
        $id = intval($request->idAttribute);
        $result = $this->productTemple->getItemAttribute($id);
        return response()->json($result);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($code)
    {
        $product = $this->productTemple->getItemByCode($code);
        if ($product != null) {
            $attributeGroup = $this->productTemple->getAttributeGroupOption();
            $productOption = $this->productTemple->getProductOption();
            $productTempAttMap = $this->productTemple->getProductTemplateAttributeMap($product['product_id']);

            return view('product::product-template.detail',[
                'attributeGroup' => $attributeGroup,
                'product' => $product,
                'productOption' => $productOption,
                'productTempAttMap' => $productTempAttMap,
            ]);
        } else {
            return redirect()->route('product.product');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($code)
    {
        $product = $this->productTemple->getItemByCode($code);
        if ($product != null) {
            $attributeGroup = $this->productTemple->getAttributeGroupOption();
            $productOption = $this->productTemple->getProductOption();
            $productTempAttMap = $this->productTemple->getProductTemplateAttributeMap($product['product_id']);

            return view('product::product-template.edit',[
                'attributeGroup' => $attributeGroup,
                'product' => $product,
                'productOption' => $productOption,
                'productTempAttMap' => $productTempAttMap,
            ]);
        } else {
            return redirect()->route('product.product-template');
        }
    }

    /**
     * Update the product template
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Update $request)
    {
        $data = $request->all();
        $result = $this->productTemple->update($data);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        return $this->productTemple->destroy($id);
    }

    public function getAttributeByParent(Request $request)
    {
        $id = intval($request->parentId);
        $productAttributeMap= $this->productTemple->getProductAttributeMap($id);

        return response()->json($productAttributeMap);
    }
}
