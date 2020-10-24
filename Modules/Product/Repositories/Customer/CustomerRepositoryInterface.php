<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/13/2019
 * Time: 12:08 PM
 */

namespace Modules\Product\Repositories\Customer;


interface CustomerRepositoryInterface
{
    public function getList(array $filters = []);

    public function  getDetail($customer_service_id);

    public function getOptionCustomer();


    /**
     * function update content dịch vụ
     *
     * @param  int $customer_service_id
     * @param int $data
     * @return mixed
     */
    public function update(array $data, $customer_service_id);

    /**
     * get all list service
     *
     * @return mixed
     */
    public function getListAllService(array $filters = []);

    public function store(array $data = []);

    public function getListServiceCode($code);

    public function getContractFile();

    public function upload($id, $file);

    public function getListChildAccount(array $filters = []);

    /**
     * function get total  child account
     * @param int $customer_account_id
     * @return total
     */
    public function getTotalChildAccount($id, $param);

    /**
     * function get detail info child accoount
     * @param int $customer_account_id
     * @return mixed
     */
    public function getDetailChildAccount($id);

    /**
     * get account type
     */
    public function getAccountType();

    /**
     * get list all province
     */
    public function getLisAllProvince();

    /**
     * function update info child accoount
     * @param int $customer_account_id
     * @param array $data
     * @return mixed
     */
    public function updateChildAccount(array  $data, $id);

    /**
     * function update password child accoount
     * @param int $customer_account_id
     * @param array $data
     * @return mixed
     */
    public function updatePassWord(array $data, $id);

    /**
     * create tài khoản con with customer_id
     *@param array $data
     * @return mixed
     */
    public function  createAccount(array $data);
    public function detail($id);

    public function segmentOption();

    public function editCustomer(array $data = []);
    public function blockServiceExpired($date);
    public function blockServicePayment($date);

    public function stopPayment(array  $data, $service_id);
    public function extendsService(array  $data, $service_id);

    /**
     * change status customer
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function changeStatusCustomer($id, $data);
    public function check($param);
}
