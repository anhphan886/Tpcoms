<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Repositories\Contract\ContractRepositoryInterface;

class AnnexController extends  Controller
{
    protected $annex;

    public function  __construct(
        ContractRepositoryInterface $annex
    ) {
        $this->annex = $annex;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $dataAnnex = $this->annex->getListAnnex($filter);
        $annexFile = $this->annex->getAllAnnexFile();
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;
//        dd($dataAnnex);
        return  view('product::annex.index',[
            'dataAnnex' => $dataAnnex['list'],
            'perpage' => $perpage,
            'filter' => $dataAnnex['filter'],
            'annexFile' => $annexFile
        ]);
    }

    /**
     * Upload file(pdf)
     * @param Request $request
     *
     * @return mixed
     */
    public function upload(Request $request)
    {
        $file = $image = $request->file('file');
        $id = intval($request->id);

        $result = $this->annex->uploadAnnex($id, $file);

        return $result;
    }

    public function show($id)
    {
        $detail = $this->annex->getDetailAnnex($id);
        $file = $this->annex->getAnnexFile($id);
//        dd($file);
        return view('product::annex.detail',[
            'detail' => $detail,
            'file' => $file

        ]);
    }

    public function edit($id)
    {
        $detail = $this->annex->getDetailAnnex($id);
        $file = $this->annex->getAnnexFile($id);
//        dd($file);
        return view('product::annex.edit',[
            'detail' => $detail,
            'file' => $file

        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['customer_contract_annex_id'];
        array_filter($data);
        unset($data['_token']);

        $result =$this->annex->updateAnnex($id, $data);

        return $result;
    }
}
