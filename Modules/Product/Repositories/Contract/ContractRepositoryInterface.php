<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/18/2019
 * Time: 5:06 PM
 */

namespace Modules\Product\Repositories\Contract;


interface ContractRepositoryInterface
{
public function getList(array $filters = []);

    public function action(array $data = []);

    public function upload($id, $file);

    public function getItemByCode($code);

    public function getContractFile();

    public function getContractFileById($id);

    /*
     * get list contract annex
     * **/
    public function getListAnnex(array  $filter = []);

    public  function getAnnexFile($id);

    public function updateContract($id, $data);

    public function getDetailAnnex($id);

    /**
     * Get all contract file.
     * @return mixed
     */
    public function getAllAnnexFile();

    public function updateAnnex($id, $data);

    public function uploadAnnex($id, $file);
}
