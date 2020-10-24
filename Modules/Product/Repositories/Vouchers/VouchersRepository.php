<?php


namespace Modules\Product\Repositories\Vouchers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Product\Models\VoucherLogTable;
use Modules\Product\Models\VoucherTable;


class VouchersRepository implements VouchersRepositoryInterface
{
    protected $voucher;

    public function __construct(
        VoucherTable $voucher
    )
    {
        $this->voucher = $voucher;
    }

    public function getListVoucher($filters)
    {
        if (!isset($filters['keyword_vouchers$code'])) {
            $filters['keyword_vouchers$code'] = null;
        }
        if (!isset($filters['vouchers$type'])) {
            $filters['vouchers$type'] = null;
        }
        if (!isset($filters['vouchers$percent'])) {
            $filters['vouchers$percent'] = null;
        }
        if (!isset($filters['vouchers$cash'])) {
            $filters['vouchers$cash'] = null;
        }
        if (!isset($filters['vouchers$expired_date'])) {
            $filters['vouchers$expired_date'] = null;
        }
        if (!isset($filters['vouchers$quota'])) {
            $filters['vouchers$quota'] = null;
        }
        if (!isset($filters['vouchers$is_actived'])) {
            $filters['vouchers$is_actived'] = null;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 1;
        }
        $list = $this->voucher->getList($filters);
        return [
            'list' => $list,
            'filter' => $filters
        ];
    }

    public function changeStatus(array $data, $id)
    {
//        if ($data['is_actived'] == 1) {
//            DB::table('vouchers')->where('voucher_id', $id)->delete();
//        }
        return $this->voucher->changeStatus($data, $id);
    }

    public function detail ($id)
    {
        return $this->voucher->getItemById($id);
    }

    public function editVoucher(array $data = [])
    {
//        dd($data);
        try {
            DB::beginTransaction();
            $dataInsert['code'] = strtoupper($data['code']);
            $dataInsert['type'] = strip_tags($data['type']);
            if ($dataInsert['type'] == 'sale_percent') {
                $dataInsert['percent'] = isset($data['cash']) ? (int)str_replace(',','',strip_tags($data['cash'])): (int)str_replace(',','',strip_tags($data['percent']));
                $dataInsert['cash'] = null;
            }else{
                $dataInsert['cash'] = isset($data['cash']) ? (int)str_replace(',','',strip_tags($data['cash'])): (int)str_replace(',','',strip_tags($data['percent']));
                $dataInsert['percent'] = null;
            }

            if(isset($data['max_price'])) {
                $dataInsert['max_price'] = (int)str_replace(',','',strip_tags($data['max_price']));
            }
            $dataInsert['required_price'] = (int)str_replace(',','',strip_tags($data['required_price']));
            $dataInsert['expired_date'] = date('Y-m-d', strtotime($data['expired_date']));;
            $dataInsert['slug'] = str_slug($data['code']);
            $dataInsert['quota'] = strip_tags($data['quota']);
            $dataInsert['updated_at'] = date('Y-m-d H:i:s');
            $dataInsert['updated_by'] = Auth::id();
//            dd($dataInsert);
            $this->voucher->edit($dataInsert, $data['id']);

            DB::commit();
            return [
                'error' => false,
                'message' => __('product::validation.voucher.edit_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
//                'aaaa' => $e->getMessage(),
                'message' => __('product::validation.voucher.edit_fail'),
            ];
        }
    }

    public function store(array $data = [])
    {
        try {
            DB::beginTransaction();
            $dataInsert['code'] = strtoupper(strip_tags($data['code']));
            $dataInsert['is_all'] = '1';
            $dataInsert['type'] = strip_tags($data['type']);
            if ($dataInsert['type'] == 'sale_percent') {
                $dataInsert['percent'] = strip_tags($data['percent']);
                $dataInsert['cash'] = null;
            }else{
                $dataInsert['cash'] = (int)str_replace(',','',strip_tags($data['cash']));
                $dataInsert['percent'] = null;
            }
            if(isset($data['max_price'])) {
                $dataInsert['max_price'] = (int)str_replace(',','',strip_tags($data['max_price']));
            }
            $dataInsert['required_price'] = (int)str_replace(',','',strip_tags($data['required_price']));
            $dataInsert['total_use'] = '0';
            $dataInsert['expired_date'] = Carbon::createFromFormat('d/m/Y', $data['expired_date'])->format('Y-m-d');
            $dataInsert['quota'] = (int)str_replace(',','',strip_tags($data['quota']));
            $dataInsert['slug'] = str_slug($data['code']);
            $dataInsert['created_at'] = date('Y-m-d H:i:s');
            $dataInsert['created_by'] = Auth::id();
            $this->voucher->add($dataInsert);

            DB::commit();
            return [
                'error' => false,
                'message' => __('product::validation.voucher.add_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
                'aaaa' => $e->getMessage(),
                'message' => __('product::validation.voucher.add_fail'),
            ];
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $this->voucher->edit(['is_deleted' => 1], intval($id));

            DB::commit();
            return [
                'error'   => 0,
                'message' => 'Xoá thành công',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Số lượng sử dụng
     * @param $code
     *
     * @return mixed
     */
    public function countVoucherLog($code)
    {
        $voucherLog = new VoucherLogTable();
        $result = $voucherLog->countVoucher($code);
        return $result;
    }

    public function getTotoUse(array $data = [])
    {
        $voucherLog = new VoucherLogTable();
        return $voucherLog->getTotoUse($data);
    }
}
