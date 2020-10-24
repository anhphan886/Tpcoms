<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ticket\Http\Requests\Queue\QueueStoreRequest;
use Modules\Ticket\Http\Requests\Queue\QueueUpdateRequest;
use Modules\Ticket\Repositories\TicketQueue\TicketQueueRepositoryInterface;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;



class QueueController extends Controller
{
    /**
     * @var TicketQueueRepositoryInterface;
    */
    protected $ticketQueue;

    /**
     * @var AdminRepositoryInterface;
    */
    protected  $admin;

    protected $request;
    public  function __construct(
        AdminRepositoryInterface $admin,
        TicketQueueRepositoryInterface $ticketQueue,
        Request $request
    ) {
        $this->admin = $admin;
        $this->ticketQueue = $ticketQueue;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $parram = $this->request->all();
        $data = $this->ticketQueue->getList($parram);
        $listAdmin = $this->admin->getListAll();
//        dd($listAdmin);
        if ($data['data'] != null) {
            $page = $data['data']->currentPage();
        } else {
            $page = 1;
        }

        return view('ticket::ticket-queue.index', [
                'LIST'=>$data,
                'listAdmin' => $listAdmin,
                'filter' => $parram,
                'page' => $page,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $listAdmin = $this->admin->getListAll();
        return view('ticket::ticket-queue.create',[
            'listAdmin' => $listAdmin,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param QueueStoreRequest $request
     * @return Response
     */
    public function store(QueueStoreRequest $request)
    {
        $data = $request->all();
        $result = $this->ticketQueue->add($data);

        return $result;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(QueueUpdateRequest $request)
    {
        $data = $request->all();
        $result = $this->ticketQueue->edit($data, $data['ticket_queue_id']);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = intval($request->ticket_queue_id);
        return $this->ticketQueue->destroy($id);
    }

    public function ShowPopup()
    {
        return response()->json([
            'error' => false,
            'data' => view('ticket::ticket-queue.popup.create')->render()
        ]);
    }

    /**
     * show form edit
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $detail = $this->ticketQueue->getDetai($id);
        $listAdmin = $this->admin->getListAll();
        $queueStaff = $this->ticketQueue->getListStaffByQueue($id);
        if (isset($queueStaff['operator'])) {
            $operator = collect($queueStaff['operator'])->keyBy('id')->toArray();
            $operator = array_keys($operator);
        } else {
            $operator = [];
            $operator = array_keys($operator);
        }
        if (isset($queueStaff['processor'])) {
            $processor = collect($queueStaff['processor'])->keyBy('id')->toArray();
            $processor = array_keys($processor);
        } else {
            $processor =[];
            $processor = array_keys($processor);
        }

        if ($detail == null) {
            return redirect()->route('ticket.queue.index');
        }
       return view( 'ticket::ticket-queue.edit',[
          'detail' => $detail,
           'listAdmin' => $listAdmin,
//           'listOperator' => $queueStaff['operator'] ?? null,
//           'listProcessor' => $queueStaff['processor'] ?? null,
           'operator' => $operator,
           'processor' => $processor
       ]);
    }

}
