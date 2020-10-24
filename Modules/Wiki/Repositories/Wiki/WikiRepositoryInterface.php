<?php


namespace Modules\Wiki\Repositories\Wiki;

interface WikiRepositoryInterface
{
    public function getListCategory(array $filter = []);
    public function getListKnowledgeBase(array $filter = []);
    public function getDetailCategory($id);
    public function getDetail($id);
    public function addCategory($param);
    public function addDetail($param);
    public function editCategory($param);
    public function deleteCategory($param);
    public function deleteDetail($param);
    public function editDetail($param);
    public function getCategory();
}
