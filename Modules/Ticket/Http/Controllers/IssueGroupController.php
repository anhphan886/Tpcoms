<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ticket\Http\Requests\IssueGroup\IssueGroupStoreRequest;
use Modules\Ticket\Http\Requests\IssueGroup\IssueGroupUpdateRequest;
use Modules\Ticket\Repositories\IssueGroup\IssueGroupRepositoryInterface;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Modules\Ticket\Repositories\TicketQueue\TicketQueueRepositoryInterface;

class IssueGroupController extends Controller
{
    protected  $queue;
    private $issueGroup;
    protected $admin;
    protected $request;

    public function __construct(
        TicketQueueRepositoryInterface $queue,
        IssueGroupRepositoryInterface $issueGroup,
        Request $request,
        AdminRepositoryInterface $admin
    ) {
        $this->queue =$queue;
        $this->issueGroup = $issueGroup;
        $this->request = $request;
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $param =$this->request->all();
        $data = $this->issueGroup->getList($param);
        $listAdmin = $this->admin->getListAll();
        if ($data['data'] != null) {
            $page = $data['data']->currentPage();
        } else {
            $page = 1;
        }
//        dd($data);
        return view('ticket::issue-group.index', [
            'list'=>$data['data'],
            'listAdmin'=>$listAdmin,
            'filter' =>$param,
            'page' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('ticket::issue-group.popup.create');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function add()
    {
        $listQueue = $this->queue->getListAll();
        return view('ticket::issue-group.create',[
            'listQueue' => $listQueue,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param IssueGroupStoreRequest $request
     * @return Response
     */
    public function store(IssueGroupStoreRequest $request)
    {
        $data = $request->all();
//        dd($data);
        $result = $this->issueGroup->add($data);

        return $result;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('ticket::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $listQueue = $this->queue->getListAll();
        $detail = $this->issueGroup->getDetail($id);
        if ($detail ==  null) {
            return redirect()->route('ticket::issue-group.index');
        }
        return view(
            'ticket::issue-group.edit',[
                'detail' => $detail,
                'listQueue' => $listQueue,
            ]
        );

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);

        $result = $this->issueGroup->update($data, $data['portal_ticket_issue_group_id']);

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = intval($request->ticket_issue_group_id);
        return $this->issueGroup->destroy($id);
    }
}
