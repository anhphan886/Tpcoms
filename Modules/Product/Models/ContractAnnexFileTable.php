<?php

namespace Modules\Product\Models;
use http\Env\Request;
use MyCore\Models\Traits\ListTableTrait;

class ContractAnnexFileTable extends BaseModel
{
    protected $table = 'contract_annex_file';
    protected $primaryKey = 'contract_annex_file_id';
    protected $fillable = [
        'contract_annex_file_id',
        'customer_contract_annex_id',
        'file_name',
        'link_file',
        'file_type',
        'created_at',
        'created_by',
    ];
    public $timestamps = false;

    /*
     * upload file
     *@param $filename
     *
     * @return string
     */
    public function upLoadFile($filename, $destination)
    {
        $old_name = public_path().'/'.TEMP_PATH.$filename;
        if (!file_exists($old_name)) {
            return $filename;
        }

        $path = '/uploads/'.$destination.'/';
        $destination = public_path().$path;
        // tao thu muc
        if (! is_dir ( $destination )) {
            mkdir ( $destination, 0777, true );
            if( chmod($destination, 0777) ) {
                // more code
                chmod($destination, 0755);
            }
        }

        rename($old_name, $destination.$filename);

        return $path.$filename;
    }

    /**
     * Thêm file contract.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->create($data)->{$this->primaryKey};
    }

    /**
     * Xóa file của hợp đồng
     * @param $id
     *
     * @return mixed
     */
    public function removeFile($id)
    {
        $select = $this->where('customer_contract_annex_id', $id)
            ->where('file_type', 'contract_annex_sample')
            ->delete();
        return $select;
    }


    public function getAnnexFileByID($id)
    {
        $select = $this->select(
            'customer_contract_annex_id',
            'file_name', 'link_file', 'file_type'
        )
            ->where('customer_contract_annex_id', $id)
            ->get();
        return $select;
    }


    /**
     * Get all annex file.
     * @return mixed
     */
    public function getAnnexFile()
    {
        $select = $this->select(
            'customer_contract_annex_id',
            'file_name', 'link_file', 'file_type'
        )
            ->get();
        return $select;
    }



}
