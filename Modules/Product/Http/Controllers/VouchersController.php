<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use Modules\Product\Http\Requests\voucher\Store;
use Modules\Product\Repositories\Vouchers\VouchersRepositoryInterface;
use Modules\Product\Http\Requests\voucher\Update;

class VouchersController extends Controller
{
    protected $voucher;
    protected  $admin;
    protected $request;

    public function __construct(
        VouchersRepositoryInterface $voucher,
        AdminRepositoryInterface $admin,
        Request $request

    ){
        $this->voucher = $voucher;
        $this->admin = $admin;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        $list = $this->voucher->getListVoucher($filter);
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;

        $arrayCode = [];
        if (isset($list['list']) && count($list['list']) > 0) {
            foreach ($list['list'] as $item) {
                $arrayCode[] =  $item['code'];
            }
        }
        $selectTotalUse = $this->voucher->getTotoUse($arrayCode);
        $totalUse = [];
        if (count($selectTotalUse) > 0) {
            foreach ($selectTotalUse as $item) {
                $totalUse[$item['code']] =  $item['used'];
            }
        }
//        dd($list, $selectTotalUse);
        return view('product::vouchers.index',
            [
                'list' => $list['list'],
                'filter' => $list['filter'],
                'totalUse' => $totalUse,
                'perpage' => $perpage,
            ]);
    }

    public function changeStatusVouchers(Request $request)
    {
        $data = [
            'is_actived' => $request->is_actived
        ];
        $this->voucher->changeStatus($data, $request->id);

        return response()->json([
            'error' => false,
            'message' => __('product::voucher.index.CHANGE_STATUS_SUCCESS')
        ]);
    }

    public function edit($id)
    {
        $list = $this->voucher->detail($id);
        if($list == null){
            return redirect('error-404');
        }

        return view('product::vouchers.edit',
            [
                'list' => $list,
            ]);
    }
    public function editPost(Update $update)
    {
        $data = $this->request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->voucher->editVoucher($data);
        return response()->json([
            'error' => true,
            'message' => $result
        ]);
    }
    public function detail($id)
    {
        $list = $this->voucher->detail($id);
        if($list == null){
            return redirect('error-404');
        }
        $countVoucherLog = $this->voucher->countVoucherLog($list['code']);

        return view('product::vouchers.detail',
            [
                'list' => $list,
                'id' => $id,
                'countVoucherLog' => $countVoucherLog
            ]);
    }

    public function create()
    {
        return view('product::vouchers.add');
    }

    public function store(Store $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->voucher->store($data);

        return response()->json($result);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
//        dd($id);
        return $this->voucher->destroy($id);
    }
}
