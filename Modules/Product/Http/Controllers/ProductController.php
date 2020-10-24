<?php

namespace Modules\Product\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\product\Store;
use Modules\Product\Http\Requests\product\Update;
use Modules\Product\Models\ProductAttributeGroupTable;
use Modules\Product\Models\ProductAttributeTable;
use Modules\Product\Repositories\Product\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductRepositoryInterface $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $data = $this->product->getList($filter);
        $productGroup = $this->product->getProductCategoryOption();
        return view(
            'product::product.index', [
                'list'           => $data['list'],
                'filter'         => $data['filter'],
                'productGroup' => $productGroup
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $attributeGroup = $this->product->getAttributeGroupOption();
        $productGroup = $this->product->getProductCategoryOption();
        $attributeGroupSoldTogether = $this->product->optionSoldTogether();

        return view('product::product.add',[
            'attributeGroup' => $attributeGroup,
            'productGroup' => $productGroup,
            'attributeGroupSoldTogether' => $attributeGroupSoldTogether
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
        $result = $this->product->store($data);
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
        $result = $this->product->getAttributeOption($attributeGroup, $arrayIdAttribute);
        return response()->json($result);
    }

    /**
     * Option attribute sold together
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptionAttributeSoldTogether(Request $request)
    {
        $attributeGroup = intval($request->attributeGroup);
        $arrayIdAttribute = $request->arrayIdAttribute;
        $result = $this->product->getOptionAttributeSoldTogether($attributeGroup, $arrayIdAttribute);
//        dd($result);
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
        $result = $this->product->getItemAttribute($id);
        return response()->json($result);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($code)
    {
        $product = $this->product->getItemByCode($code);

        if ($product != null) {
            $attributeGroup = $this->product->getAttributeGroupOption();
            $productGroup = $this->product->getProductCategoryOption();
            $productAttributeMap= $this->product->getProductAttributeMap($product['product_id']);
            $productAttributeGroupMap= $this->product->getProductAttributeGroupMap($product['product_id']);
            $infoGroupAttr = $this->product->getItemAttrGroup($product['product_id']);
//            dd($infoGroupAttr);
            return view('product::product.detail',[
                'product' => $product,
                'attributeGroup' => $attributeGroup,
                'productGroup' => $productGroup,
                'productAttributeMap' => $productAttributeMap,
                'productAttributeGroupMap' => $productAttributeGroupMap,
                'infoGroupAttr' => $infoGroupAttr
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
        $product = $this->product->getItemByCode($code);
        if ($product != null) {
            $attributeGroup = $this->product->getAttributeGroupOption();
            $productGroup = $this->product->getProductCategoryOption();
            $productAttributeMap= $this->product->getProductAttributeMap($product['product_id']);
            $productAttributeGroupMap= $this->product->getProductAttributeGroupMap($product['product_id']);
            $infoGroupAttr = $this->product->getItemAttrGroup($product['product_id']);
            $attributeGroupSoldTogether = $this->product->optionSoldTogether();

            return view('product::product.edit',[
                'product' => $product,
                'attributeGroup' => $attributeGroup,
                'productGroup' => $productGroup,
                'productAttributeMap' => $productAttributeMap,
                'productAttributeGroupMap' => $productAttributeGroupMap,
                'infoGroupAttr' => $infoGroupAttr,
                'attributeGroupSoldTogether' => $attributeGroupSoldTogether
            ]);
        } else {
            return redirect()->route('product.product');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Update $request)
    {
//        dd($request->all());
        $data = $request->all();
        $result = $this->product->update($data);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        return $this->product->destroy($id);
    }

    public function uploads(Request $request)
    {
        $time = Carbon::now();
        // Requesting the file from the form
        $image = $request->file('file');
        //tên của hình ảnh

        $extension = $image->getClientOriginalExtension();
        $filename = time() . date_format($time, 'd') . date_format($time, 'm') . date_format($time, 'Y') . '_'.  str_random(15) . '.' . $extension;

        //$filename = time() . str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . time() . "." . $extension;
        // This is our upload main function, storing the image in the storage that named 'public'
        $upload_success = $image->storeAs(TEMP_PATH, $filename, 'public');
        // If the upload is successful, return the name of directory/filename of the upload.
        if ($upload_success) {
            return response()->json($filename);
        } else {
            return response()->json('error');
        }
    }

    public function chooseAttrAction(Request $request)
    {
        $infoGroupAttr = $this->product->getItemAttributeGroup($request->attribute_group_id);
        $attr = $this->product->getAttributeByGroup($request->attribute_group_id);
        return response()->json([
            'info' => $infoGroupAttr,
            'attr' => $attr
        ]);
    }
    public function getAttrGroupWhereNotIn(Request $request)
    {
        $attributeGroup = intval($request->attribute_group_id);
        $arrayIdAttribute = $request->arrayGroup;
        $result = $this->product->getAttrGroupWhereNotIn($attributeGroup, $arrayIdAttribute);
        return response()->json($result);
    }
}
