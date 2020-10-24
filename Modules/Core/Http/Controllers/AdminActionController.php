<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Requests\AdminAction\AdminActionUpdateRequest;
use Modules\Core\Repositories\AdminAction\AdminActionRepositoryInterface;
use Modules\Core\Repositories\AdminGroupAction\AdminGroupActionRepositoryInterface;
use Modules\Core\Repositories\AdminGroup\AdminGroupRepositoryInterface;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepositoryInterface;

class AdminActionController extends Controller
{
    /**
     * @var AdminGroupActionRepositoryInterface
     */
    protected $adminGroupAction;

    /**
     * @var AdminActionRepositoryInterface
     */
    protected $adminAction;

    /**
     * @var AdminGroupRepositoryInterface
     */
    protected $adminGroup;

    /**
     * @var AdminMenuRepositoryInterface
     */
    protected $adminMenu;

    public function __construct(
        AdminGroupActionRepositoryInterface $adminGroupAction,
        AdminActionRepositoryInterface $adminAction,
        AdminGroupRepositoryInterface $adminGroup,
        AdminMenuRepositoryInterface $adminMenu
    ) {
        $this->adminGroupAction = $adminGroupAction;
        $this->adminAction = $adminAction;
        $this->adminGroup = $adminGroup;
        $this->adminMenu = $adminMenu;
    }

    /**
     * Hiển thị danh sách quyền truy cập
     *
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();

        $list = $this->adminAction->getList($filter);

        return view('core::admin-action.index', [
            'list' => $list['listAdminAction'],
            'filter' => $list['filter'],
        ]);
    }

    /**
     * Hiển thị thông tin chi tiết
     *
     * @param int $action_id
     * @return Response
     */
    public function show($action_id)
    {
        $detail = $this->adminAction->getDetail($action_id);
        $listGroup = $this->adminGroupAction->getListGroupByAction($action_id);

        if ($detail == null) {
            return redirect()->route('core.admin-action.index');
        }

        return view('core::admin-action.detail', [
            'detail' => $detail,
            'list_group' => $listGroup,
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa quyền truy cập
     *
     * @param int $action_id
     * @return Response
     */
    public function edit($action_id)
    {
        $detail = $this->adminAction->getDetail($action_id);
        $listGroup = $this->adminGroupAction->getListGroupByAction($action_id);

        if ($detail == null) {
            return redirect()->route('core::admin-action.index');
        }

        return view('core::admin-action.edit', [
            'detail' => $detail,
            'list_group' => $listGroup,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  AdminActionUpdateRequest $request
     * @return Response
     */
    public function update(AdminActionUpdateRequest $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $result = $this->adminGroupAction->edit($data);

        return response()->json($result);
    }

    /**
     * Ajax lấy danh sách nhóm quyền cho popup
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListGroup(Request $request)
    {
        $listChildId = $request->only(['group_id_list']);
        $listChild = $this->adminGroup->getListGroupChildForPopup($listChildId);

        return view('core::admin-action.popup.popup-list-group', [
            'list_group' => $listChild
        ]);
    }

    /**
     * Ajax thêm danh sách vào table
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCollectionListGroup(Request $request)
    {
        $dataRequest = $request->only(['collection']);

        if (isset($dataRequest['collection']) && count($dataRequest['collection']) > 0) {
            $listChild = $this->adminGroup->getListAll(['in' => $dataRequest['collection']]);
        } else {
            $listChild = [];
        }

        return view('core::admin-action.partial.list-tr-group', [
            'list_group' => $listChild,
        ]);
    }
}