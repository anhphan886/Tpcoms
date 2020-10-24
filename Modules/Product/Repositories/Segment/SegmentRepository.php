<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 11/17/2019
 * Time: 7:45 PM
 */

namespace Modules\Product\Repositories\Segment;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\SegmentTable;

class SegmentRepository implements SegmentRepositoryInterface
{
    protected $segment;

    public function __construct(
        SegmentTable $segment
    ) {
        $this->segment = $segment;
    }
    public function getList(array $filters = [])
    {
        if (!isset($filters['keyword'])) {
            $filters['keyword'] = null;
        }
        if (!isset($filters['page'])) {
            $filters['page'] = 0;
        }
        $list = $this->segment->getList($filters);
        return [
            'filter' => $filters,
            'list' => $list
        ];
    }

    /**
     * Thêm
     * @param array $data
     *
     * @return array
     */
    public function store(array $data = [])
    {
        try {
            DB::beginTransaction();
            $dataSegment = [
                'name' => $data['name_vi'],
                'name_en' => $data['name_en'],
                'created_at' =>  date('Y-m-d H:i:s'),
                'created_by' =>   Auth::id(),
                'updated_at' =>  date('Y-m-d H:i:s'),
                'updated_by' =>   Auth::id(),
            ];
            $result = $this->segment->add($dataSegment);
            DB::commit();
            return [
                'error' => false,
                'message' => __('product::validation.segment.add_success'),
                'data' => $result
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => 1,
                'message' => __('product::validation.product.add_fail'),
            ];
        }
    }

    public function destroy($id)
    {
        try {
            $this->segment->editSegment($id, ['is_deleted' => 1]);
            return [
                'error'   => 0,
                'message' => 'Xoá thành công',
            ];
        } catch (\Exception $e) {
            return [
                'error'   => 1,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getItem($id)
    {
        return $this->segment->getItem($id);
    }

    /**
     * Thêm
     * @param array $data
     *
     * @return array
     */
    public function update($id, array $data = [])
    {
        try {
            $dataSegment = [
                'name' => $data['name_vi'],
                'name_en' => $data['name_en'],
                'updated_at' =>  date('Y-m-d H:i:s'),
                'updated_by' =>   Auth::id(),
            ];
            $result = $this->segment->editSegment($id, $dataSegment);

            return [
                'error' => false,
                'message' => __('product::validation.segment.edit_success'),
                'data' => $result
            ];
        } catch (\Exception $e) {
            return [
                'aaaa' => $e->getMessage(),
                dd($e),
                'error' => 1,
                'message' => __('product::validation.segment.edit_fail'),
            ];
        }
    }
}
