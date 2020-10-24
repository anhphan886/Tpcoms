<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepositoryInterface;
use Modules\Core\Repositories\AdminGroup\AdminGroupRepositoryInterface;
use Modules\Core\Repositories\AdminHasGroup\AdminHasGroupRepositoryInterface;
use Modules\Core\Http\Requests\Admin\UpdateRequest;
use Modules\Core\Http\Requests\Admin\StoreRequest;

class AdminController extends Controller
{
    /**
     * @var AdminRepositoryInterface
     */
    protected $admin;
    protected $adminMenu;
    protected $adminGroup;
    protected $adminHasGroup;

    public function __construct(
        AdminRepositoryInterface $admin,
        AdminGroupRepositoryInterface $adminGroup,
        AdminHasGroupRepositoryInterface $adminHasGroup,
        AdminMenuRepositoryInterface $adminMenu

    ) {
        $this->admin = $admin;
        $this->adminMenu = $adminMenu;
        $this->adminGroup = $adminGroup;
        $this->adminHasGroup = $adminHasGroup;
    }

    public function index()
    {
        $filter = request()->all();

        $data = $this->admin->getList($filter);

        return view('core::admin.index', ['LIST' => $data, 'filter' => $filter]);
    }

    public function create()
    {
        $optionAdminMenu = $this->adminMenu->getOption();

        return view('core::admin.create', ['optionAdminMenu' => $optionAdminMenu]);
    }

    public function store(StoreRequest $request)
    {
        $param = $request->all();
        return $this->admin->store($param);
    }

    public function destroy($id)
    {
        $this->admin->remove($id);
        return redirect()->route('core.user.index');
    }

    public function edit($id)
    {
        $admin = Auth::user();
        $is_admin = $admin['is_admin'];
        $userRoleGroup = $this->adminGroup->getListRoleGroupUser($id);

        $data = $this->admin->getDetail($id);
        $optionAdminMenu = $this->adminMenu->getOption();
        return view('core::admin.edit', [
            'data' => $data,
            'optionAdminMenu' => $optionAdminMenu,
            'list_group_child' => $userRoleGroup,
            'is_admin' => $is_admin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request)
    {
        $data = $request->all();
        return $this->admin->edit($data, $data['id']);
    }

    public function changeStatusMyStoreUserAction(Request $request)
    {

        $data=[
            'is_actived' => $request->is_actived
        ];

        $this->admin->changeStatus($data, $request->id);

        return response()->json([
            'error' => false,
            'message' => __('core::admin.index.CHANGE_STATUS_SUCCESS')
        ]);
    }

    public function showResetPassword(Request $request)
    {
        $data = $request->all();
        $result = $this->admin->getDetail($data['user_id']);

        return view('core::admin.popup.popup-reset-password', [
            'item' => $result
        ]);
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();
        $result = $this->admin->updatePassword($data, $data['userId']);
        return $result;
    }

    /**
     * Ajax lấy danh sách nhóm quyền con ra popup
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListGroupChild(Request $request)
    {
        $listChildId = $request->only(['group_id_list', 'group_id']);
        $listChild = $this->admin->getListGroupChildForPopup($listChildId);

        return view('core::admin.popup.popup-list-group-child', [
            'list_group_child' => $listChild
        ]);
    }

    public function addCollectionListGroupChild(Request $request)
    {
        $collection = $request->only(['collection']);

        if (count($collection) > 0) {
            $listChild
                = $this->adminGroup->getListAll(['in' => $collection['collection']]);
        } else {
            $listChild = [];
        }
        return view('core::admin.include.list-tr-group-child', [
            'list_group_child' => $listChild
        ]);
    }

    public function changPassword()
    {
        if (Auth::user() != null) {
            return view('core::account.change-password');
        } else {
            return redirect()->route('login');
        }
    }

    public function submitChangPassword(Request $request)
    {
        $data = $request->all();
        $result = $this->admin->changPassword($data);
        return $result;
    }
}
