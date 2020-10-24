<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Models\LockOutTable;
use Modules\Core\Repositories\Admin\AdminRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    protected $user;

    const BLOCK_USER_TIMES = 5;

    /**
     * Hiển thị form đăng nhập
     *
     * @return Response
     */
    public function index()
    {
        $oUser = Auth::user();

        if ($oUser) {
            return redirect()->route(LOGIN_HOME_PAGE);
        }

        return view('core::login.index');
    }

    /**
     * Xử lý đăng nhập
     *
     * @param Request $request
     * @return void
     */
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => __('core::validation.login.email_required'),
            'email.email' => __('core::validation.shared.email'),
            'password.required' => __('core::validation.login.password_required'),
            'password.min' => __('core::validation.login.wrong'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 1,
                'message' => $validator->errors()->all()
            ]);
        }

        $certifications = [
            'email'      => $request->input('email'),
            'password'   => $request->input('password'),
            'is_deleted' => 0
        ];
        $mLockOut = new LockOutTable();
        $totalLock = $mLockOut->where('email', $request->input('email'))->get()->count();

        if (Auth::attempt($certifications)) {
            if ($totalLock < self::BLOCK_USER_TIMES) {
                $oUser = Auth::user();
                $credentials = $request->only('email', 'password');

                $token = JWTAuth::attempt($credentials);
                session(['authen_token' => $token]);
                if ($oUser->is_actived == 1) {
                    $listAction = $this->listActionById(Auth::id());
                    if ($oUser->is_admin == 1) {
                        $redirect = route(LOGIN_HOME_PAGE);
                        $request->session()->put('user_menu', []);
                    } else {
                        if (!$request->session()->has('user_menu')) {
                            $listMenu = $this->listMenu(Auth::id());
                            $request->session()->put('user_menu', $listMenu);
                        }
                        if (count($listAction) > 0) {
                            $checkDashboard = 0;
                            foreach ($listAction as $keys => $items) {
                                if ($items == LOGIN_HOME_PAGE) {
                                    $checkDashboard = 1;
                                }
                            }
                            if ($checkDashboard == 1) {
                                $redirect = route(LOGIN_HOME_PAGE);
                            } else {
                                $redirect = (count($listAction) > 0) ? route($listAction[0]) : route('nothing');
                            }
                        } else {
                            $redirect = (count($listAction) > 0) ? route($listAction[0]) : route('nothing');
                        }
                    }
                    return response()->json([
                        'error' => 0,
                        'message' => __('core::validation.login.success'),
                        'url' => $redirect
                    ]);
                } else {
                    session()->flush();
                    Auth::logout();
                    return response()->json([
                        'error' => 1,
                        'message' => __('core::validation.login.locked'),
                    ]);
                }
            } else {
                session()->flush();
                Auth::logout();
                return response()->json([
                    'error' => 1,
                    'message' => __('core::validation.login.locked'),
                ]);
            }

        } else {
            return response()->json([
                'error' => 1,
                'message' => __('core::validation.login.wrong'),
            ]);
        }
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();

        return redirect()->route('login');
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
}
