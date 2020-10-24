<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Product\Repositories\Segment\SegmentRepositoryInterface;
use Modules\Product\Http\Requests\segment\StoreSegment;
use Modules\Product\Http\Requests\segment\UpdateSegment;

class SegmentController extends Controller
{
    protected $segment;

    public function __construct(
        SegmentRepositoryInterface $segment

    ) {
        $this->segment = $segment;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $data = $this->segment->getList($filter);
        return view('product::segment.index',[
            'list' => $data['list'],
            'filter' => $data['filter'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('product::segment.add');
    }

    public function store(StoreSegment $request)
    {
        $data = $request->all();
        array_filter($data);
        unset($data['_token']);
        $result = $this->segment->store($data);

        return $result;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $detail = $this->segment->getItem($id);
        if ($detail == null) {
            return redirect('error-404');
        }
        return view(
            'product::segment.detail', [
            'detail' => $detail,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $detail = $this->segment->getItem($id);
        if ($detail == null) {
            return redirect('error-404');
        }
        return view(
            'product::segment.edit', [
            'detail' => $detail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateSegment $request)
    {
        $data = $request->all();
        $id   =$data['id'];
        array_filter($data);
        unset($data['_token']);
        $result = $this->segment->update($id, $data);

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = intval($request->id);
        return $this->segment->destroy($id);
    }
}
