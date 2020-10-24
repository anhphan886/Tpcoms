<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\attributeGroup\Store;
use Modules\Product\Repositories\AttributeGroup\AttributeGroupRepositoryInterface;
use Modules\Product\Repositories\Contract\ContractRepositoryInterface;
use Modules\Product\Repositories\Customer\CustomerRepositoryInterface;


class ContractController extends Controller
{
    protected $contract;
    protected $service;

    public function __construct(
        ContractRepositoryInterface $contract,
        CustomerRepositoryInterface $service
    ) {
        $this->contract = $contract;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $data = $this->contract->getList($filter);
        $contractFile = $this->contract->getContractFile();
        $perpage = isset($filter['perpage']) ? $filter['perpage'] : PAGING_ITEM_PER_PAGE;
        return view('product::contract.index',[
            'list' => $data['list'],
            'filter' => $data['filter'],
            'contractFile' => $contractFile,
            'perpage' => $perpage,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $id=$request->all();
        return view('product::contract.add_annex', [
            'id' => $id,
        ]);
    }

    /**
     * Hành động ở list.
     * @param Request $request
     *
     * @return mixed
     */
    public function action(Request $request)
    {
        $data = $request->all();
        $result = $this->contract->action($data);
        return $result;
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

        $result = $this->contract->upload($id, $file);

        return $result;
    }

    public function show($code)
    {
        $contract = $this->contract->getItemByCode($code);
        $filter = ['contract_id' => $code];
        $file = $this->contract->getContractFileById($contract['customer_contract_id']);
        $annex = $this->contract->getListAnnex($filter);
        $service = $this->service->getListAllService($filter);
        $annexFile = $this->contract->getAnnexFile($code);
        $allFileAnnex = $this->contract->getAllAnnexFile();
//        dd($service);
        return view('product::contract.detail',
            [
                'contract' => $contract,
                'file' => $file,
                'annex' => $annex,
                'service' => $service,
                'annexFile' => $annexFile,
                'allFileAnnex' => $allFileAnnex
            ]
        );
    }

    public function edit($code)
    {
        $contract = $this->contract->getItemByCode($code);
        $file = $this->contract->getContractFileById($contract['customer_contract_id']);

        return view('product::contract.edit',
            [
                'contract' => $contract,
                'file' => $file,
            ]
        );
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['customer_contract_id'];
//        dd($id, $data);
        array_filter($data);
        unset($data['_token']);

        $result = $this->contract->updateContract($id, $data);
        return $result;
    }
}
