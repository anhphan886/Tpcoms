<?php

namespace Modules\Wiki\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Wiki\Repositories\Wiki\WikiRepositoryInterface;

class WikiController extends Controller
{
    protected $wiki;
    protected $request;
    public function __construct(WikiRepositoryInterface $wiki, Request $request)
    {
        $this->wiki = $wiki;
        $this->request = $request;
    }

    public function listCategory()
    {
        $param = $this->request->all();
        $wiki = $this->wiki->getListCategory($param);
        return view('wiki::category-knowledge-base.index', [
            'list' => $wiki,
            'filter' => $param
        ]);
    }

    public function createCategory()
    {
        return view('wiki::category-knowledge-base.create-category', [
        ]);
    }

    public function editCategory($id)
    {
        $detail = $this->wiki->getDetailCategory($id);
        return view('wiki::category-knowledge-base.edit-category', [
            'detail' => $detail
        ]);
    }

    public function createCategoryPost()
    {
        $param = $this->request->all();
        $data = $this->wiki->addCategory($param);
        return $data;
    }

    public function editCategoryPost()
    {
        $param = $this->request->all();
        $data = $this->wiki->editCategory($param);
        return $data;
    }

    public function deleteCategoryPost()
    {
        $param = $this->request->all();
        $data = $this->wiki->deleteCategory($param);
        return $data;
    }

    public function listKnowledgeBase()
    {
        $param = $this->request->all();
        $wiki = $this->wiki->getListKnowledgeBase($param);
        return view('wiki::detail-knowledge-base.index', [
            'list' => $wiki,
            'filter' => $param
        ]);
    }

    public function createKnowledgeBase()
    {
        $listCategory = $this->wiki->getCategory();
        return view('wiki::detail-knowledge-base.create', [
            'listCategory' => $listCategory
        ]);
    }

    public function createKnowledgeBasePost()
    {
        $param = $this->request->all();
        $detail = $this->wiki->addDetail($param);
        return $detail;
    }

    public function editKnowledgeBase($id)
    {
        $detail = $this->wiki->getDetail($id);
        $listCategory = $this->wiki->getCategory();
        return view('wiki::detail-knowledge-base.edit', [
            'detail' => $detail,
            'listCategory' => $listCategory
        ]);
    }

    public function editKnowledgeBasePost()
    {
        $param = $this->request->all();
        $detail = $this->wiki->editDetail($param);
        return $detail;
    }

    public function deleteKnowledgeBasePost()
    {
        $param = $this->request->all();
        $data = $this->wiki->deleteDetail($param);
        return $data;
    }

//    Upload Image
    public function uploadImage(Request $request)
    {
        $param = $request->all();
        if ($request->file('file') != null) {
            $file = $this->uploadImageIntroduction($request->file('file'));
            return response()->json(["file" => $file, "success" => "1"]);
        }
    }

    public function uploadImageIntroduction($file)
    {
        $time = Carbon::now();
        $file_name = rand(0, 9) . time() .
            date_format($time, 'd') .
            date_format($time, 'm') .
            date_format($time, 'Y') . "_page." . $file->getClientOriginalExtension();

        $file->move("uploads/image", $file_name);
        return $file_name;
    }
}
