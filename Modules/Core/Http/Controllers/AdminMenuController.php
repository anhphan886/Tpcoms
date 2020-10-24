<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Requests\AdminMenu\AdminMenuStoreRequest;
use Modules\Core\Http\Requests\AdminMenu\AdminMenuUpdateRequest;
use Modules\Core\Repositories\AdminAction\AdminActionRepositoryInterface;
use Modules\Core\Repositories\AdminGroup\AdminGroupRepositoryInterface;
use Modules\Core\Repositories\AdminGroupMenu\AdminGroupMenuRepositoryInterface;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepositoryInterface;
use Modules\Core\Repositories\AdminMenuCategory\AdminMenuCategoryRepositoryInterface;

class AdminMenuController extends Controller
{
    /**
     * @var AdminMenuRepositoryInterface
     */
    protected $adminMenu;

    /**
     * @var AdminActionRepositoryInterface
     */
    protected $adminAction;

    /**
     * @var AdminGroupRepositoryInterface
     */
    protected $adminGroup;

    /**
     * @var AdminGroupMenuRepositoryInterface
     */
    protected $adminGroupMenu;

    /**
     * @var AdminMenuCategoryRepositoryInterface
     */
    protected $adminMenuCategory;

    protected $listIcons = [
        'fa-address-card',
        'fa-box-open',
        'fa-building',
        'fa-city',
        'fa-cog',
        'fa-envelope',
        'fa-globe',
        'fa-globe-asia',
        'fa-home',
        'fa-image',
        'fa-layer-group',
        'fa-list',
        'fa-lock',
        'fa-map-marker-alt',
        'fa-plus',
        'fa-tachometer-alt',
        'fa-user',
        'fa-user-friends',
    ];

    public function __construct(
        AdminMenuRepositoryInterface $adminMenu,
        AdminMenuCategoryRepositoryInterface $adminMenuCategory,
        AdminActionRepositoryInterface $adminAction,
        AdminGroupRepositoryInterface $adminGroup,
        AdminGroupMenuRepositoryInterface $adminGroupMenu
    ) {
        $this->adminMenu = $adminMenu;
        $this->adminMenuCategory = $adminMenuCategory;
        $this->adminAction = $adminAction;
        $this->adminGroup = $adminGroup;
        $this->adminGroupMenu = $adminGroupMenu;
    }

    /**
     * Lấy danh sách menu
     *
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();

        $data = $this->adminMenu->getList($filter);

        return view('core::admin-menu.index', [
            'list' => $data['listAdminMenu'],
            'filter' => $data['filter'],
        ]);
    }

    /**
     * Hiển thị trang chi tiết
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $detail = $this->adminMenu->getDetail($id);
        $listAction = $this->adminAction->getListOption();
        $listGroup = $this->adminGroupMenu->getListAll(['menu_id' => $id]);
        $listMenuCategory = $this->adminMenuCategory->getListAll();

        if ($detail == null) {
            return redirect()->route('core.admin-menu.index');
        }

        return view('core::admin-menu.detail', [
            'detail' => $detail,
            'list_action' => $listAction,
            'list_group' => $listGroup,
            'list_icons' => $this->listIcons,
            'list_menu_category' => $listMenuCategory,
        ]);
    }

    /**
     * Hiển thị form thêm menu
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $listAction = $this->adminAction->getListOption();
        $listMenuCategory = $this->adminMenuCategory->getListAll();

        return view('core::admin-menu.create', [
            'list_action' => $listAction,
            'list_icons' => $this->listIcons,
            'list_menu_category' => $listMenuCategory,
        ]);
    }

    /**
     * Xử lý thêm menu
     *
     * @param AdminMenuStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminMenuStoreRequest $request)
    {
        $dataRequest = $request->all();
        unset($dataRequest['_token']);
        $result = $this->adminMenu->add($dataRequest);

        return response()->json($result);
    }

    /**
     * Hiển thị form chỉnh sửa quyền menu
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $detail = $this->adminMenu->getDetail($id);
        $listAction = $this->adminAction->getListOption();
        $listGroup = $this->adminGroupMenu->getListAll(['menu_id' => $id]);
        $listMenuCategory = $this->adminMenuCategory->getListAll();

        if ($detail == null) {
            return redirect()->route('core.admin-menu.index');
        }

        return view('core::admin-menu.edit', [
            'detail' => $detail,
            'list_action' => $listAction,
            'list_group' => $listGroup,
            'list_icons' => $this->listIcons,
            'list_menu_category' => $listMenuCategory,
        ]);
    }

    /**
     * Xử lý lưu thông tin cập nhật
     *
     * @param  AdminMenuUpdateRequest $request
     * @return Response
     */
    public function update(AdminMenuUpdateRequest $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $result = $this->adminMenu->edit($data);

        return response()->json($result);
    }

    /**
     * Đóng menu
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only(['menu_id']);

        $result = $this->adminMenu->remove($data['menu_id']);

        if ($result) {
            return response()->json([
                'error' => 0,
                'message' => __('core::admin-menu.destroy.IS_DELETED'),
            ]);
        } else {
            return response()->json([
                'error' => 0,
                'message' => __('core::admin-menu.destroy.ERROR'),
            ]);
        }
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

        return view('core::admin-menu.popup.popup-list-group', [
            'list_group' => $listChild
        ]);
    }

    /**
     * Ajax thêm danh sách vào table
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCollectionList(Request $request)
    {
        $collection = $request->only(['collection']);

        if (count($collection) > 0) {
            $listChild = $this->adminGroup->getListAll(['in' => $collection['collection']]);
        } else {
            $listChild = [];
        }

        return view('core::admin-menu.partial.list-tr-group', [
            'list_group' => $listChild
        ]);
    }
}
