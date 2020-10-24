<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Repositories\User\UserRepositoryInterface;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepositoryInterface;
use Modules\Core\Repositories\AdminGroup\AdminGroupRepositoryInterface;
use Modules\Core\Repositories\AdminHasGroup\AdminHasGroupRepositoryInterface;
use Modules\Core\Http\Requests\User\UpdateRequest;
use Modules\Core\Http\Requests\User\StoreRequest;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user;
    protected $adminMenu;
    protected $adminGroup;
    protected $adminHasGroup;

    public function __construct(
        UserRepositoryInterface $user,
        AdminGroupRepositoryInterface $adminGroup,
        AdminHasGroupRepositoryInterface $adminHasGroup,
        AdminMenuRepositoryInterface $adminMenu

    ) {
        $this->user = $user;
        $this->adminMenu = $adminMenu;
        $this->adminGroup = $adminGroup;
        $this->adminHasGroup = $adminHasGroup;
    }

    public function index()
    {
        $filter = request()->all();

        $data = $this->user->getList($filter);

        return view('core::user.index', ['LIST' => $data, 'filter' => $filter]);
    }

    public function create()
    {
        $optionAdminMenu = $this->adminMenu->getOption();

        return view('core::user.create', ['optionAdminMenu' => $optionAdminMenu]);
    }

    public function store(StoreRequest $request)
    {
        $param = $request->all();
        return $this->user->store($param);
    }

    public function destroy($id)
    {
        $this->user->remove($id);
        return redirect()->route('core.user.index');
    }

    public function edit($id)
    {
        $userRoleGroup = $this->adminGroup->getListRoleGroupUser($id);

        $data = $this->user->getDetail($id);
        $optionAdminMenu = $this->adminMenu->getOption();
        return view('core::user.edit', [
            'data' => $data,
            'optionAdminMenu' => $optionAdminMenu,
            'list_group_child' => $userRoleGroup
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
        return $this->user->edit($data, $data['id']);
    }

    public function changeStatusMyStoreUserAction(Request $request)
    {

        $data=[
            'is_actived' => $request->is_actived
        ];

        $this->user->changeStatus($data, $request->id);

        return response()->json([
            'error' => false,
            'message' => __('core::user.index.CHANGE_STATUS_SUCCESS')
        ]);
    }

    public function showResetPassword(Request $request)
    {
        $data = $request->all();
        $result = $this->user->getDetail($data['user_id']);

        return view('core::user.popup.popup-reset-password', [
            'item' => $result
        ]);
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();
        $result = $this->user->updatePassword($data, $data['userId']);
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
        $listChild = $this->user->getListGroupChildForPopup($listChildId);

        return view('core::user.popup.popup-list-group-child', [
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
        return view('core::user.include.list-tr-group-child', [
            'list_group_child' => $listChild
        ]);
    }
}
