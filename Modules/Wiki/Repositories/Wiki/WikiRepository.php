<?php


namespace Modules\Wiki\Repositories\Wiki;

use Modules\Wiki\Models\WikiCategoryTable;
use Modules\Wiki\Models\WikiDetailTable;
use Modules\Wiki\Models\WikiSlugTable;

class WikiRepository implements WikiRepositoryInterface
{
    protected $categoryWiki;
    protected $wikiSlug;
    protected $detailTable;
    public function __construct(WikiCategoryTable $categoryWiki, WikiSlugTable $wikiSlug, WikiDetailTable $detailTable)
    {
        $this->categoryWiki = $categoryWiki;
        $this->wikiSlug = $wikiSlug;
        $this->detailTable = $detailTable;
    }

    public function getListCategory(array $filter = [])
    {
        return $this->categoryWiki->getList($filter);
    }

    public function getListKnowledgeBase(array $filter = [])
    {
        return $this->detailTable->getList($filter);
    }

    public function getDetailCategory($id)
    {
        return $this->categoryWiki->getDetailCategory($id);
    }

    public function getDetail($id)
    {
        return $this->detailTable->getDetail($id);
    }

    public function addCategory($param)
    {
        if ($param['name_en'] == null) {
            return response()->json([
                'error' => true,
                'message' => __('wiki::wiki.index.nhapdanhmuctienganh')
            ]);
        } else {
            if ($param['name_vi'] == null) {
                return response()->json([
                    'error' => true,
                    'message' => __('wiki::wiki.index.nhapdanhmuctiengviet')
                ]);
            } else {
                $validator = \Validator::make($param, [
                    'name_en' => 'max:250',
                    'name_vi' => 'max:250',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'error' => true,
                        'message' => __('wiki::wiki.index.danhmucmaxlengh')
                    ]);
                } else {
                    $arr = [];
                    $arr['alias_en'] = str_slug($param['name_en'], '-');
                    $arr['alias_vi'] = str_slug($param['name_vi'], '-');
                    $checkEn = $this->categoryWiki->checkCategoryEn(null, $arr['alias_en']);
                    if ($checkEn->count() != 0) {
                        return response()->json([
                            'error' => true,
                            'message' => __('wiki::wiki.index.trungdanhmucen')
                        ]);
                    } else {
                        $checkVi = $this->categoryWiki->checkCategoryVi(null, $arr['alias_vi']);
                        if ($checkVi->count() != 0) {
                            return response()->json([
                                'error' => true,
                                'message' => __('wiki::wiki.index.trungdanhmucvi')
                            ]);
                        } else {
                            $this->wikiSlug->addCategory($arr);
                            $arr['name_en'] = $param['name_en'];
                            $arr['name_vi'] = $param['name_vi'];
                            $this->categoryWiki->addCategory($arr);
                            return response()->json([
                                'error' => false,
                                'message' => __('wiki::wiki.index.taothanhcong')
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function editCategory($param)
    {
        if ($param['name_en'] == null) {
            return response()->json([
                'error' => true,
                'message' => __('wiki::wiki.index.nhapdanhmuctienganh')
            ]);
        } else {
            if ($param['name_vi'] == null) {
                return response()->json([
                    'error' => true,
                    'message' => __('wiki::wiki.index.nhapdanhmuctiengviet')
                ]);
            } else {
                $validator = \Validator::make($param, [
                    'name_en' => 'max:250',
                    'name_vi' => 'max:250',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'error' => true,
                        'message' => __('wiki::wiki.index.danhmucmaxlengh')
                    ]);
                } else {
                    $getDetail = $this->categoryWiki->getDetailCategory($param['id']);
                    $arr = [];
                    $arr['alias_en'] = str_slug($param['name_en'], '-');
                    $arr['alias_vi'] = str_slug($param['name_vi'], '-');
                    if ($arr['alias_en'] == $getDetail['alias_en']
                        && $arr['alias_vi'] == $getDetail['alias_vi']) {
                        $arr['name_en'] = $param['name_en'];
                        $arr['name_vi'] = $param['name_vi'];
                        $this->categoryWiki->editCategory($param['id'], $arr);
                        return response()->json([
                            'error' => false,
                            'message' => __('wiki::wiki.index.capnhatthanhcong')
                        ]);
                    } else {
                        $checkEn = $this->categoryWiki->checkCategoryEn($param['id'], $arr['alias_en']);
                        if ($checkEn->count() != 0) {
                            return response()->json([
                                'error' => true,
                                'message' => __('wiki::wiki.index.trungdanhmucen')
                            ]);
                        } else {
                            $checkVi = $this->categoryWiki->checkCategoryVi($param['id'], $arr['alias_vi']);
                            if ($checkVi->count() != 0) {
                                return response()->json([
                                    'error' => true,
                                    'message' => __('wiki::wiki.index.trungdanhmucvi')
                                ]);
                            } else {
                                $this->wikiSlug->editCategory($getDetail['alias_en'], $getDetail['alias_vi'], $arr);
                                $arr['name_en'] = $param['name_en'];
                                $arr['name_vi'] = $param['name_vi'];
                                $this->categoryWiki->editCategory($param['id'], $arr);
                                return response()->json([
                                    'error' => false,
                                    'message' => __('wiki::wiki.index.capnhatthanhcong')
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }

    public function deleteCategory($param)
    {
        $alias = $this->categoryWiki->getDetailCategory($param['id']);
        $this->wikiSlug->deleteCategory($alias['alias_en'], $alias['alias_vi']);
        $this->categoryWiki->deleteCategory($param);
        return response()->json([
            'error' => false,
            'message' => __('wiki::wiki.index.xoathanhcong')
        ]);
    }

    public function deleteDetail($param)
    {
        $alias = $this->detailTable->getDetail($param['id']);
        $this->wikiSlug->deleteDetail($alias['alias_en'], $alias['alias_vi']);
        $this->detailTable->deleteDetail($param);
        return response()->json([
            'error' => false,
            'message' => __('wiki::wiki.index.xoathanhcong')
        ]);
    }

    public function addDetail($param)
    {
        if ($param['name_en'] == null) {
            return response()->json([
                'error' => true,
                'message' => __('wiki::wiki.index.nhaptentienganh')
            ]);
        } else {
            if ($param['name_vi'] == null) {
                return response()->json([
                    'error' => true,
                    'message' => __('wiki::wiki.index.nhaptentiengviet')
                ]);
            } else {
                $validator = \Validator::make($param, [
                    'name_en' => 'max:250',
                    'name_vi' => 'max:250',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'error' => true,
                        'message' => __('wiki::wiki.index.tenmaxlengh')
                    ]);
                } else {
                    $arr = [];
                    $arr['alias_en'] = str_slug($param['name_en'], '-');
                    $arr['alias_vi'] = str_slug($param['name_vi'], '-');
                    $checkEn = $this->detailTable->checkDetailEn(null, $arr['alias_en']);
                    if ($checkEn->count() != 0) {
                        return response()->json([
                            'error' => true,
                            'message' => __('wiki::wiki.index.trungtenen')
                        ]);
                    } else {
                        $checkVi = $this->detailTable->checkDetailVi(null, $arr['alias_vi']);
                        if ($checkVi->count() != 0) {
                            return response()->json([
                                'error' => true,
                                'message' => __('wiki::wiki.index.trungtenvi')
                            ]);
                        } else {
                            $this->wikiSlug->addDetail($arr);
                            $arr['name_en'] = $param['name_en'];
                            $arr['name_vi'] = $param['name_vi'];
                            $arr['description_en'] = $param['description_en'];
                            $arr['description_vi'] = $param['description_vi'];
                            $arr['category_id'] = $param['category_id'];
                            $this->detailTable->addDetail($arr);
                            return response()->json([
                                'error' => false,
                                'message' => __('wiki::wiki.index.taothanhcong')
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function editDetail($param)
    {
        if ($param['name_en'] == null) {
            return response()->json([
                'error' => true,
                'message' => __('wiki::wiki.index.nhaptentienganh')
            ]);
        } else {
            if ($param['name_vi'] == null) {
                return response()->json([
                    'error' => true,
                    'message' => __('wiki::wiki.index.nhaptentiengviet')
                ]);
            } else {
                $validator = \Validator::make($param, [
                    'name_en' => 'max:250',
                    'name_vi' => 'max:250',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'error' => true,
                        'message' => __('wiki::wiki.index.tenmaxlengh')
                    ]);
                } else {
                    $getDetail = $this->detailTable->getDetail($param['id']);
                    $arr = [];
                    $arr['alias_en'] = str_slug($param['name_en'], '-');
                    $arr['alias_vi'] = str_slug($param['name_vi'], '-');
                    if ($arr['alias_en'] == $getDetail['alias_en']
                        && $arr['alias_vi'] == $getDetail['alias_vi']) {
                        $arr['name_en'] = $param['name_en'];
                        $arr['name_vi'] = $param['name_vi'];
                        $arr['description_en'] = $param['description_en'];
                        $arr['description_vi'] = $param['description_vi'];
                        $arr['category_id'] = $param['category_id'];
                        $this->detailTable->editDetail($param['id'], $arr);
                        return response()->json([
                            'error' => false,
                            'message' => __('wiki::wiki.index.capnhatthanhcong')
                        ]);
                    } else {
                        $checkEn = $this->detailTable->checkDetailEn($param['id'], $arr['alias_en']);
                        if ($checkEn->count() != 0) {
                            return response()->json([
                                'error' => true,
                                'message' => __('wiki::wiki.index.trungtenen')
                            ]);
                        } else {
                            $checkVi = $this->detailTable->checkDetailVi($param['id'], $arr['alias_vi']);
                            if ($checkVi->count() != 0) {
                                return response()->json([
                                    'error' => true,
                                    'message' => __('wiki::wiki.index.trungtenvi')
                                ]);
                            } else {
                                $this->wikiSlug->editDetail($getDetail['alias_en'], $getDetail['alias_vi'], $arr);
                                $arr['name_en'] = $param['name_en'];
                                $arr['name_vi'] = $param['name_vi'];
                                $arr['description_en'] = $param['description_en'];
                                $arr['description_vi'] = $param['description_vi'];
                                $arr['category_id'] = $param['category_id'];
                                $this->detailTable->editDetail($param['id'], $arr);
                                return response()->json([
                                    'error' => false,
                                    'message' => __('wiki::wiki.index.capnhatthanhcong')
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getCategory()
    {
        return $this->categoryWiki->getCategory();
    }
}
