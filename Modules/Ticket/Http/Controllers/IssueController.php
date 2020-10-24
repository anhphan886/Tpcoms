<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ticket\Http\Requests\Issue\IssueStoreRequest;
use Modules\Ticket\Repositories\Issue\IssueRepositoryInterface;
use Modules\Ticket\Repositories\IssueGroup\IssueGroupRepositoryInterface;
use Modules\Ticket\Repositories\TicketQueue\TicketQueueRepositoryInterface;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;

class IssueController extends Controller
{
    /**
     * @var IssueRepositoryInterface
     */
    private $issue;

    /**
     * @var IssueGroupRepositoryInterface
     */
    private $issueGroup;

    /**
     * @var AdminRepositoryInterface
     */
    private $admin;

    private $queue;

    protected $request;

    public function __construct(
        IssueRepositoryInterface $issue,
        IssueGroupRepositoryInterface $issueGroup,
        TicketQueueRepositoryInterface $queue,
        AdminRepositoryInterface $admin,
        Request $request
    ) {
        $this->issue = $issue;
        $this->issueGroup = $issueGroup;
        $this->queue = $queue;
        $this->admin = $admin;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $param = $this->request->all();
        $data = $this->issue->getList($param);
        $listAdmin = $this->admin->getListAll();
        if ($data['data'] != null) {
            $page = $data['data']->currentPage();
        } else {
            $page = 1;
        }
//        dd($data);
        return view('ticket::issue.index', [
            'list' => $data['data'],
            'listAdmin' => $listAdmin,
            'filter' => $param,
            'page' => $page
        ]);
    }

    /**
     * chuyển trang thêm issue
     * @return mixed
     */
    public function add(){
        $listGroup = $this->issueGroup->getListAll();
        $listQueue = $this->queue->getListAll();
        $listLevel = $this->issue->getListLevel();
        //        dd($listLevel);
        return view('ticket::issue.create',[
            'listGroup' => $listGroup,
            'listQueue' => $listQueue,
            'listLevel' => $listLevel,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $listGroup = $this->issueGroup->getListAll();
        $listQueue = $this->queue->getListAll();
        $listLevel = $this->issue->getListLevel();

        return view('ticket::issue.popup.create', [
            'listGroup' => $listGroup,
            'listQueue' => $listQueue,
            'listLevel' => $listLevel,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param IssueStoreRequest $request
     * @return Response
     */
    public function store(IssueStoreRequest $request)
    {
        $data = $request->all();
        $result = $this->issue->add($data);

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
     *
     * @param int $portal_ticket_issue_id
     * @return Response
     */
    public function edit($portal_ticket_issue_id)
    {
        $detail = $this->issue->getDetail($portal_ticket_issue_id);
        $listGroup = $this->issueGroup->getListAll();
        $listQueue = $this->queue->getListAll();
        $listLevel = $this->issue->getListLevel();
//        dd($detail);
//        if ( $detail ==null) {
//            return redirect()->route(ticket::ticket.issue.index);
//        }
        return view('ticket::issue.edit', [
            'detail' => $detail,
            'listGroup' => $listGroup,
            'listQueue' =>$listQueue,
            'listLevel' => $listLevel
        ]);
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
//        dd($data);
        $result = $this->issue->update($data, $data['portal_ticket_issue_id']);
         return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id =intval($request->portal_ticket_issue_id);
        return  $this->issue->destroy($id);
    }
}
