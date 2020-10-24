<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Requests\AdminMenuCategory\AdminMenuCategoryStoreRequest;
use Modules\Core\Http\Requests\AdminMenuCategory\AdminMenuCategoryUpdateRequest;
use Modules\Core\Repositories\AdminAction\AdminActionRepositoryInterface;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepositoryInterface;
use Modules\Core\Repositories\AdminMenuCategory\AdminMenuCategoryRepositoryInterface;

class AdminMenuCategoryController extends Controller
{
    /**
     * @var AdminMenuRepositoryInterface
     */
    protected $adminMenu;

    /**
     * @var AdminMenuCategoryRepositoryInterface
     */
    protected $adminMenuCategory;

    protected $adminAction;

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
        AdminActionRepositoryInterface $adminAction
    ) {
        $this->adminMenu = $adminMenu;
        $this->adminMenuCategory = $adminMenuCategory;
        $this->adminAction = $adminAction;
    }

    /**
     * Trang chính
     *
     * @return Response
     */
    public function index()
    {
        $filter = request()->all();
        $title = $this->adminAction->getNameByRoute(Route::currentRouteName());

        $data = $this->adminMenuCategory->getList($filter);

        return view('core::admin-menu-category.index', [
            'list' => $data['list'],
            'filter' => $data['filter'],
            'title' => $title,
        ]);
    }

    /**
     * Hiển thị form thêm
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->adminAction->getNameByRoute(Route::currentRouteName());

        return view('core::admin-menu-category.create', [
            'title' => $title,
            'list_icons' => $this->listIcons
        ]);
    }

    /**
     * Xử lý thêm nhóm menu
     *
     * @param  AdminMenuCategoryStoreRequest $request
     * @return Response
     */
    public function store(AdminMenuCategoryStoreRequest $request)
    {
        $data = $request->all();

        $result = $this->adminMenuCategory->add($data);

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
        $title = $this->adminAction->getNameByRoute(Route::currentRouteName());
        $detail = $this->adminMenuCategory->getDetail($id);

        if ($detail == null) {
            return redirect()->route('core.admin-menu-category.index');
        }

        return view('core::admin-menu-category.detail', [
            'title' => $title,
            'detail' => $detail,
            'list_icons' => $this->listIcons,
        ]);
    }

    /**
     * Hiển thị chi tiết lên form chỉnh sửa
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $title = $this->adminAction->getNameByRoute(Route::currentRouteName());
        $detail = $this->adminMenuCategory->getDetail($id);

        if ($detail == null) {
            return redirect()->route('core.admin-menu-category.index');
        }

        return view('core::admin-menu-category.edit', [
            'title' => $title,
            'detail' => $detail,
            'list_icons' => $this->listIcons,
        ]);
    }

    /**
     * Xử lý cập nhật
     *
     * @param  AdminMenuCategoryUpdateRequest $request
     * @return Response
     */
    public function update(AdminMenuCategoryUpdateRequest $request)
    {
        $data = $request->all();

        $result = $this->adminMenuCategory->edit($data);

        return response()->json($result);
    }

    /**
     * Đánh dấu xóa nhóm menu
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only(['menu_category_id']);

        $result = $this->adminMenuCategory->remove($data['menu_category_id']);

        if ($result) {
            return response()->json([
                'error' => 0,
                'message' => __('core::admin-menu-category.popup.IS_DELETED'),
            ]);
        } else {
            return response()->json([
                'error' => 0,
                'message' => __('core::admin-menu-category.popup.ERROR'),
            ]);
        }
    }
}
