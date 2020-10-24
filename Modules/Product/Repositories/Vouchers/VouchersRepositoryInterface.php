<?php


namespace Modules\Product\Repositories\Vouchers;


 interface  VouchersRepositoryInterface
{
     public function getListVoucher($filters);

     public function changeStatus(array $data, $id);

     public function detail ($id);

     public function editVoucher(array $data = []);

     public function store(array $data = []);

     public function destroy($id);

     public function countVoucherLog($code);

     public function getTotoUse(array $data = []);

}
