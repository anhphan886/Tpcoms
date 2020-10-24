<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Modules\Core\Http\Requests\AdminGroup\AdminGroupUpdateRequest;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use Modules\Core\Repositories\AdminAction\AdminActionRepositoryInterface;
use Modules\Core\Repositories\AdminGroup\AdminGroupRepositoryInterface;
use Modules\Core\Http\Requests\AdminGroup\AdminGroupStoreRequest;
use Modules\Core\Repositories\AdminGroupAction\AdminGroupActionRepositoryInterface;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepositoryInterface;

class AdminGroupController extends Controller
{
    /**
     * @var AdminGroupRepositoryInterface
     */
    protected $adminGroup;

    /**
     * @var AdminActionRepositoryInterface
     */
    protected $adminAction;

    /**
     * @var AdminRepositoryInterface
     */
    protected $admin;

    /**
     * @var AdminGroupActionRepositoryInterface
     */
    protected $adminGroupAction;

    /**
     * @var AdminMenuRepositoryInterface
     */
    protected $adminMenu;

    public function __construct(
        AdminActionRepositoryInterface $adminAction,
        AdminGroupRepositoryInterface $adminGroup,
        AdminRepositoryInterface $admin,
        AdminGroupActionRepositoryInterface $adminGroupAction,
        AdminMenuRepositoryInterface $adminMenu
    ) {
        $this->adminAction = $adminAction;
        $this->adminGroup = $adminGroup;
        $this->admin = $admin;
        $this->adminGroupAction = $adminGroupAction;
        $this->adminMenu = $adminMenu;
    }

    /**
     * Hiển thị danh sách nhóm quyền
     *
     * @return Response
     */
    public function index()
    {
//        dd(App::getLocale());
        $filter = request()->all();

        $data = $this->adminGroup->getList($filter);

        return view('core::admin-group.index', [
            'list' => $data['listAdminGroup'],
            'filter' => $data['filter'],
        ]);
    }

    /**
     * Hiển thị form tạo nhóm quyền
     *
     * @return Response
     */
    public function create()
    {
        $listActionAll = $this->adminAction->getListAll();
        $listUser = $this->admin->getListAll(['is_admin' => 0]);
        $listMenu = $this->adminMenu->getListAll();

        return view('core::admin-group.create', [
            'list_action_all' => $listActionAll,
            'list_user' => $listUser,
            'list_menu_all' => $listMenu
        ]);
    }

    /**
     * Xử lý lưu thông tin tạo nhóm quyền
     *
     * @param  AdminGroupStoreRequest $request
     * @return Response
     */
    public function store(AdminGroupStoreRequest $request)
    {
        $dataRequest = $request->all();
        array_filter($dataRequest);
        unset($dataRequest['_token']);
        $result = $this->adminGroup->add($dataRequest);

        return response()->json($result);
    }

    /**
     * Hiển thị thông tin chi tiết
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $detail = $this->adminGroup->getDetail($id);
        $listUser = $this->adminGroup->getListUser($id);
        $listAction = $this->adminGroupAction->getListActionByGroup($id);
        $listMenu = $this->adminMenu->getListMenuByGroup($id);

        if ($detail == null) {
            return redirect()->route('core.admin-group.index');
        }

        return view('core::admin-group.detail', [
            'detail' => $detail,
            'admin_has_group' => $listUser,
            'list_action' => $listAction,
            'list_menu' => $listMenu
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa nhóm quyền
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $detail = $this->adminGroup->getDetail($id);
        $listUser = $this->adminGroup->getListUser($id);
        $listAction = $this->adminGroupAction->getListActionByGroup($id);
        $listMenu = $this->adminMenu->getListMenuByGroup($id);

        if ($detail == null) {
            return redirect()->route('core.admin-group.index');
        }

        return view('core::admin-group.edit', [
            'detail' => $detail,
            'admin_has_group' => $listUser,
            'list_action' => $listAction,
            'list_menu' => $listMenu
        ]);
    }

    /**
     * Xử lý lưu thông tin chỉnh sửa nhóm quyền
     *
     * @param  AdminGroupUpdateRequest $request
     * @return Response
     */
    public function update(AdminGroupUpdateRequest $request)
    {
        $dataRequest = $request->all();
        array_filter($dataRequest);
        unset($dataRequest['_token']);
        $result = [
            'error' => 1,
            'message' => __('admin::admin-group.edit.FAILED'),
        ];
        if (isset($dataRequest['group_id'])) {
            $group_id = $dataRequest['group_id'];
            unset($dataRequest['group_id']);
            $result = $this->adminGroup->edit($dataRequest, $group_id);
        }

        return response()->json($result);
    }

    /**
     * Xử lý đánh dấu xóa nhóm quyền
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only(['group_id']);

        $result = $this->adminGroup->remove($data['group_id']);

        if ($result) {
            return response()->json([
                'error' => 0,
                'message' => __('core::admin-group.destroy.IS_DELETED'),
            ]);
        } else {
            return response()->json([
                'error' => 0,
                'message' => __('core::admin-group.destroy.ERROR'),
            ]);
        }
    }

    /**
     * Hiển thị form giao quyền cho nhân viên
     *
     * @param int $group_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addUserIntoGroup($group_id)
    {
        $detail = $this->adminGroup->getDetail($group_id);
        $listUser = $this->adminGroup->getListUser($group_id);

        return view('core::admin-group.add-user-into-group', [
            'detail' => $detail,
            'admin_has_group' => $listUser,
        ]);
    }

    /**
     * Xử lý giao quyền cho nhân viên
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitAddUserIntoGroup(Request $request)
    {
        $data = $request->all();
        $result = $this->adminGroup->addUserInToGroup($data);

        return response()->json($result);
    }

    /**
     * Ajax lấy danh sách nhóm quyền con ra popup
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListGroupChild(Request $request)
    {
        $listChildId = $request->only(['group_id_list', 'group_id']);
        $listChild = $this->adminGroup->getListGroupChildForPopup($listChildId);

        return view('core::admin-group.popup.popup-list-group-child', [
            'list_group_child' => $listChild
        ]);
    }

    /**
     * Ajax thêm danh sách vào table
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCollectionListGroupChild(Request $request)
    {
        $collection = $request->only(['collection']);

        if (count($collection) > 0) {
            $listChild = $this->adminGroup->getListAll(['in' => $collection['collection']]);
        } else {
            $listChild = [];
        }

        return view('core::admin-group.partial.list-tr-group-child', [
            'list_group_child' => $listChild
        ]);
    }

    /**
     * Ajax lấy danh sách user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListUser(Request $request)
    {
        $listUserId = $request->only(['user_id_list']);
        $listUser = $this->admin->getListUserForPopup($listUserId);

        return view('core::admin-group.popup.popup-list-user', [
            'list_user' => $listUser
        ]);
    }

    /**
     * Ajax thêm danh sách user vào table
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCollectionListUser(Request $request)
    {
        $collection = $request->only(['collection']);

        if (count($collection) > 0) {
            $listUser = $this->admin->getListAll(['in' => $collection['collection']]);
        } else {
            $listUser = [];
        }

        return view('core::admin-group.partial.list-tr-user', [
            'list_user' => $listUser
        ]);
    }

    /**
     * Ajax lấy danh sách menu
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListMenu(Request $request)
    {
        $listMenuId = $request->only(['menu_id_list']);
        $listMenu = $this->adminMenu->getListMenuForPopup($listMenuId);

        return view('core::admin-group.popup.popup-list-menu', [
            'list_menu' => $listMenu
        ]);
    }

    /**
     * Ajax thêm danh sách menu vào table
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCollectionListMenu(Request $request)
    {
        $collection = $request->only(['collection']);

        if (count($collection) > 0) {
            $listMenu = $this->adminMenu->getListAll(['in' => $collection['collection']]);
        } else {
            $listMenu = [];
        }

        return view('core::admin-group.partial.list-tr-menu', [
            'list_menu' => $listMenu
        ]);
    }

    /**
     * Ajax lấy danh sách menu
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListAction(Request $request)
    {
        $listActionId = $request->only(['action_id_list']);
        $listAction = $this->adminAction->getListActionForPopup($listActionId);

        return view('core::admin-group.popup.popup-list-action', [
            'list_action' => $listAction
        ]);
    }

    /**
     * Ajax thêm danh sách menu vào table
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCollectionListAction(Request $request)
    {
        $collection = $request->only(['collection']);

        if (count($collection) > 0) {
            $listAction = $this->adminAction->getListAll(['in' => $collection['collection']]);
        } else {
            $listAction = [];
        }

        return view('core::admin-group.partial.list-tr-action', [
            'list_action' => $listAction
        ]);
    }
}
