<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/18/2019
 * Time: 5:06 PM
 */

namespace Modules\Product\Repositories\Contract;


use Carbon\Carbon;
use function Composer\Autoload\includeFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Product\Http\Api\General;
use Modules\Product\Models\ContractFileTable;
use Modules\Product\Models\CustomerContractTable;
use Modules\Ticket\Http\Api\TicketApi;
use Modules\Product\Models\ContractAnnexTable;
use Modules\Product\Models\ContractAnnexFileTable;

class ContractRepository implements ContractRepositoryInterface
{
    protected $contract;
    protected $contractFile;
    protected $general;
    protected $contractAnnex;
    protected $annexFile;

    public function __construct(
        CustomerContractTable $contract,
        ContractFileTable $contractFile,
        General $general,
        ContractAnnexTable $contractAnnex,
        ContractAnnexFileTable $annexFile
    ) {
        $this->contract = $contract;
        $this->contractFile = $contractFile;
        $this->general = $general;
        $this->contractAnnex = $contractAnnex;
        $this->annexFile = $annexFile;
    }

    /**
     * Danh sách hợp đồng
     * @param array $filters
     *
     * @return array
     */
    public function getList(array $filters = [])
    {
        if (!isset($filters['customer_contract$status'])) {
            $filters['customer_contract$status'] = null;
        }

        if (!isset($filters['keyword_customer_contract$contract_no'])) {
            $filters['keyword_customer_contract$contract_no'] = null;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 1;
        }
        $list = $this->contract->getList($filters);
        return [
            'filter' => $filters,
            'list' => $list
        ];
    }

    /**
     * Hành động: Duyệt, hủy.
     * @param array $data
     *
     * @return array
     */
    public function action(array $data = [])
    {
        $type = strip_tags($data['type']);
        $id = intval($data['id']);
        $status = '';
        if ($type == 'approve') {
            $status = 'approved';
        } else if ($type == 'cancel') {
            $status = 'approved_cancel';
        }
        if ($status != '') {
            $dataUpdate = [
                'status' => $status,
                'updated_by' => Auth::id(),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->contract->edit($dataUpdate, $id);
            return [
                'error'   => 0,
                'message' => '',
            ];
        } else {
            return [
                'error'   => true,
                'message' => '',
            ];
        }
    }

    /**
     * Upload file
     * @param $id
     * @param $file
     *
     * @return array
     */
    public function upload($id, $file)
    {
        $time = Carbon::now();
        //tên của file
        $name = str_replace('.pdf', '', $file->getClientOriginalName());
        $extension = $file->getClientOriginalExtension();
        $filename = $name . '_' . date_format($time, 'd') . date_format(
                $time, 'm'
            ) . date_format($time, 'Y') . '_' . time();
        $upload_success = $file->storeAs(
            CONTRACT_UPLOADS_PATH, $filename . '.' . $extension, 'public'
        );

        $result = $this->general->uploadGeneral(
            [
                'type'     => 'contract',
                'name'     => 'upload_file',
                'contents' => fopen($upload_success, 'r'),
                'filename' => $filename . '.' . $extension,
            ]
        );

        if (isset($result['file_name'])) {
            $dataInsert = [
                'customer_contract_id' => $id,
                'file_name'            => $result['file_name'],
                'link_file'            => CONTRACT_UPLOADS . $result['file_name'],
                'file_type'            => 'contract_sample',
                'created_at'           => date('Y-m-d H:i:s'),
                'created_by'           => Auth::id()
            ];

            $this->contractFile->removeFile($id);
            $this->contractFile->add($dataInsert);
            $dataUpdate = [
                'updated_by' => Auth::id(),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->contract->edit($dataUpdate, $id);
            return [
                'error'   => 0,
                'message' => '',
            ];
        } else {
            return [
                'error'   => true,
                'message' => '',
            ];
        }
    }

    /**
     * Get contract by code.
     * @param $code
     *
     * @return mixed
     */
    public function getItemByCode($code)
    {
        $select = $this->contract->getItemByCode($code);
        return $select;
    }

    /**
     * Get all contract file.
     * @return mixed
     */
    public function getContractFile()
    {
        $select = $this->contractFile->getContractFile();
        return $select;
    }

    /**
     * Get all contract file by contract id.
     * @return mixed
     */
    public function getContractFileById($id)
    {
        $select = $this->contractFile->getContractFileById($id);
        return $select;
    }

    /*
     * get list contract annex
     * **/
    public function getListAnnex(array $filters = [])
    {
        if (!isset($filters['page'])) {
            $filters['page'] = 1;
        }
        $list = $this->contractAnnex->getList($filters);
        return [
            'filter' => $filters,
            'list' => $list
        ];

    }

    /**
     * Upload file contract annex
     * @param $id
     * @param $file
     *
     * @return array
     */
    public function uploadAnnex($id, $file)
    {
        $time = Carbon::now();
        //tên của file
        $name = str_replace('.pdf', '', $file->getClientOriginalName());
        $extension = $file->getClientOriginalExtension();
        $filename = $name . '_' . date_format($time, 'd') . date_format(
                $time, 'm'
            ) . date_format($time, 'Y') . '_' . time();
        $upload_success = $file->storeAs(
            ANNEX_UPLOADS_PATH, $filename . '.' . $extension, 'public'
        );

        $result = $this->general->uploadGeneral(
            [
                'type'     => 'annex',
                'name'     => 'upload_file',
                'contents' => fopen($upload_success, 'r'),
                'filename' => $filename . '.' . $extension,
            ]
        );

        if (isset($result['file_name'])) {
            $dataInsert = [
                'customer_contract_annex_id' => $id,
                'file_name'            => $result['file_name'],
                'link_file'            => ANNEX_UPLOADS . $result['file_name'],
                'file_type'            => 'contract_annex_sample',
                'created_at'           => date('Y-m-d H:i:s'),
                'created_by'           => Auth::id()
            ];

            $this->annexFile->removeFile($id);
            $this->annexFile->add($dataInsert);
            $dataUpdate = [
                'updated_by' => Auth::id(),
                'updated_at' => date('Y-m-d H:i:m'),
            ];
            $this->contractAnnex->updateData($id, $dataUpdate);
            return [
                'error'   => 0,
                'message' => '',
            ];
        } else {
            return [
                'error'   => true,
                'message' => '',
            ];
        }
    }

    /*
     * get annex file
     * @param int $id
     * @return mixed
     * */
    public  function getAnnexFile($id)
    {
        $result = $this->annexFile->getAnnexFileByID($id);
        return $result;
    }

    /**
     * update contract
     * @param int $id
     * @param array $data
     * @return mixed
    */
    public function updateContract($id, $data)
    {
        $contract = $this->contract->getItemByCode($id);
        $created_at = $contract['created_at'];
//        dd($created_at);
        try {
            $dataContract = [
                'time_contract' => strip_tags($data['time_contract']),
                'updated_at' =>Carbon::now(),
                'updated_by' => Auth::id(),
            ];
            if (isset($data['contract_date']) )
            {
                $data['contract_date'] = str_replace('/', '-', $data['contract_date']);
                $data['contract_date'] = date('Y-m-d', strtotime($data['contract_date']));
                $dataContract['contract_date'] = $data['contract_date'];
                $newDay = Carbon::parse($created_at) ->format('Y-m-d');

                if ($newDay > $dataContract['contract_date']) {
                    return [
                        'error' => 1,
                        'message'  => 'Ngày ký hợp đồng phải lớn hơn hoặc bằng ngày tạo hợp đồng',
                    ];
                } elseif (isset($data['time_contract'])) {
                    $expired_date = Carbon::parse($dataContract['contract_date'])->addDays($data['time_contract'])->format('Y-m-d H:i:m');
                    $dataContract['expired_date'] = $expired_date;

                    $result = $this->contract->updateData($id, $dataContract);

                    return [
                        'error' => 0,
                        'message' => __('Cập nhật thành công'),
                        'data' => $result,
                    ];
                } else {
                    $result = $this->contract->updateData($id, $dataContract);

                    return [
                        'error' => 0,
                        'message' => __('Cập nhật thành công'),
                        'data' => $result,
                    ];
                }

            }

        } catch (\Exception $e) {
            return [
                'aaaa' => $e->getMessage(),
                'error' => 1,
                'message' => __('ticket::issue.info.update_failed'),
                'data' => null
            ];
        }
    }

    public function getDetailAnnex($id)
    {
        return $this->contractAnnex->getDetailByID($id);
    }

    /**
     * Get all contract file.
     * @return mixed
     */
    public function getAllAnnexFile()
    {
        $select = $this->annexFile->getAnnexFile();
        return $select;
    }

    public function updateAnnex($id, $data)
    {
        try {
            $annex = $this->contractAnnex->getDetailByID($id);
            $created_at = $annex['created_at'];
            $newDay = Carbon::parse($created_at) ->format('Y-m-d');
            $dataAnnex = [
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::id(),
            ];
            if( isset($data['contract_annex_date']) && $data['contract_annex_date']) {
                $data['contract_annex_date'] = str_replace('/', '-', $data['contract_annex_date']);
                $data['contract_annex_date'] = date('Y-m-d', strtotime($data['contract_annex_date']));
                $dataAnnex['contract_annex_date'] = $data['contract_annex_date'];

                if($newDay > $dataAnnex['contract_annex_date']) {
                    return [
                        'error' => 1,
                        'message'  => 'Ngày ký phụ lục hợp đồng phải lớn hơn hoặc bằng ngày tạo phụ hợp đồng',
                    ];
                } else {
                    $result = $this->contractAnnex->updateData($id, $dataAnnex);

                    return [
                        'error' => 0,
                        'message' => __('Cập nhật thành công'),
                        'data' => $result,
                    ];
                }
            } else {
                $dataAnnex['contract_annex_date'] = null;
            }

            $result = $this->contractAnnex->updateData($id, $dataAnnex);

            return [
                'error' => 0,
                'message' => __('Cập nhật thành công'),
                'data' => $result,
            ];


        } catch (\Exception $e) {
            return [
                'aaaa' => $e->getMessage(),
                'error' => 1,
                'message' => __('ticket::issue.info.update_failed'),
                'data' => null
            ];
        }
    }
}
