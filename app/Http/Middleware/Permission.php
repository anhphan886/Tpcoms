<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use Modules\Core\Repositories\AdminAction\AdminActionRepositoryInterface;
use Modules\Core\Repositories\AdminMenu\AdminMenuRepositoryInterface;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            $admin_id = Auth::id();

            if (!$request->session()->has('all_route')) {
                $allRoute = $this->listAction();
                $request->session()->put('all_route', $allRoute);
            }

            if (!$request->session()->has('user_route')) {
                $listAction = $this->listActionById($admin_id);
                $request->session()->put('user_route', $listAction);
            }

            if (!$request->session()->has('user_menu')) {
                $listMenu = $this->listMenu($admin_id);
                $request->session()->put('user_menu', $listMenu);
            }

//            if (Auth::user()->is_change_pass == 0) {
//                return redirect()->route('change-password-first');
//            }

            if (Auth::user()->is_admin == 1) {
                return $next($request);
            }

            $currentRoute = $request->route()->getName();
            $sessionAllRoute = $request->session()->get('all_route');
            $sessionUserRoute = $request->session()->get('user_route');
            $sessionMenuItems = $request->session()->get('user_menu');

            if (in_array($currentRoute, $sessionAllRoute)) {
                if (!in_array($currentRoute, $sessionUserRoute)) {
                    if (count($sessionUserRoute) > 0) {
                        if (count($sessionMenuItems) > 0 && $this->checkRouteMenu($currentRoute)) {
                            return redirect()->route('nothing');
                        }
                        return redirect()->route('nothing');
                    } else {
                        return redirect()->route('nothing');
                    }
                }
            }
        }

        return $next($request);
    }

    /**
     * Lấy danh sách quyền truy cập của người dùng
     *
     * @param int $admin_id
     * @return array
     */
    private function listActionById($admin_id)
    {
        $admin = app(AdminRepositoryInterface::class);
        $listAction = $admin->getListActionById($admin_id);
        $result = [];

        if (count($listAction) > 0) {
            foreach ($listAction as $item) {
                if (!in_array($item['route'], $result)) {
                    $result[] = $item['route'];
                }
            }
        }

        return $result;
    }

    /**
     * Lấy danh sách toàn bộ các route được phân quyền
     *
     * @return array
     */
    private function listAction()
    {
        $adminAction = app(AdminActionRepositoryInterface::class);
        $listAllRoute = $adminAction->getAllRoute();

        return $listAllRoute;
    }

    /**
     * Lấy danh sách menu theo admin id
     *
     * @param int $admin_id
     * @return array
     */
    private function listMenu($admin_id)
    {
        $admin = app(AdminRepositoryInterface::class);
        $listMenu = $admin->getListMenuByAdminId($admin_id);

        $result = [];
        if (count($listMenu) > 0) {
            foreach ($listMenu as $item) {
                $result[] = $item['menu_id'];
            }
        }

        return $result;
    }

    private function checkRouteMenu($menu_route)
    {
        $menu = app(AdminMenuRepositoryInterface::class);
        $menu_id = $menu->getMenuIdByRoute($menu_route);

        $sessionMenuItems = request()->session()->get('user_menu');

        foreach ($menu_id as $item) {
            if (in_array($item, $sessionMenuItems)) {
                return true;
            }
        }
        return false;
    }
}
