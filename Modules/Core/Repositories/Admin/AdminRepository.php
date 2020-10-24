<?php

namespace Modules\Core\Repositories\Admin;

use App\Mail\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Modules\Core\Models\AdminForgotPassTable;
use Modules\Core\Models\AdminGroupTable;
use Modules\Core\Models\AdminTable;
use Modules\Core\Repositories\AdminHasGroup\AdminHasGroupRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{
    /**
     * @var AdminTable
     */
    protected $admin;
    protected $adminHasGroup;
    protected $adminGroup;
    protected $forgotPass;
    protected $timestamps = true;

    public function __construct(
        AdminTable $admin,
        AdminGroupTable $adminGroup,
        AdminHasGroupRepositoryInterface $adminHasGroup
    ) {
        $this->admin = $admin;
        $this->adminGroup = $adminGroup;
        $this->adminHasGroup = $adminHasGroup;
        // $this->forgotPass = new AdminForgotPassTable();
    }

    /**
     * Lấy danh sách admin
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = [])
    {
        $filters['is_deleted'] = 0;
        return $this->admin->getList($filters);
    }

//    public  function getListAll(array $filters=[])
//    {
//        return $this->admin->getListAll($filters);
//    }
    /**
     * Xóa admin
     *
     * @param int $id
     * @return mixed
     */
    public function remove($id)
    {
        return $this->admin->remove($id);
    }

    /**
     * Thêm admin
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $arrayRoleGroup = [];
            if (isset($data['arrayRoleGroup'])) {
                $arrayRoleGroup = $data['arrayRoleGroup'];
            }

            $param['full_name'] = strip_tags($data['full_name']);
            $param['email'] = strip_tags($data['email']);
            $param['is_admin'] = 0;
            $param['is_actived'] = $data['isActive'];
            $param['is_deleted'] = 0;
            $param['created_at'] = date('Y-m-d H:m:i');
            $param['updated_at'] = date('Y-m-d H:m:i');
            $param['password'] = Hash::make($data['password']);

            $validator = \Validator::make($param, [
                'full_name' => 'max:250',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'data' => 'Họ và tên vượt quá ký tự cho phép'
                ]);
            } else {
                unset($param['password_confirm']);

                $userId = $this->admin->store($param);

                if ($arrayRoleGroup != null) {
                    $insertAdminHasGroup = [];
                    foreach ($arrayRoleGroup as $key => $value) {
                        $insertAdminHasGroup[] = [
                            'admin_id' => $userId,
                            'group_id' => $value,
                            'is_deleted' => 0,
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];

                    }
                    $this->adminHasGroup->addMultipleRecords($insertAdminHasGroup);
                }
            }

            DB::commit();

            return response()->json([
                'error' => false,
                'data' => __('core::admin.create.CREATE_SUCCESS')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'data' => __('core::admin.create.CREATE_FAIL')
            ]);
        }
    }

    public function getDetail($id)
    {
        return $this->admin->getDetail($id);
    }

    public function edit(array $data, $id)
    {
        if (!isset($data['password']) || $data['password'] == null) {
            unset($data['password']);
        }
        $param['full_name'] = strip_tags($data['full_name']);
        $param['is_actived'] = strip_tags($data['is_actived']);
        $param['updated_at'] = date('Y-m-d H:m:i');
        //Xóa hết nhóm quyền của user.
        $this->adminHasGroup->removeByUser($data['id']);

        if (isset($data['arrayRoleGroup']) && count($data['arrayRoleGroup'])) {
            //Nếu tồn tại nhóm quyền thì add quyền cho user.
            foreach ($data['arrayRoleGroup'] as $key => $value) {
                $insertAdminHasGroup = [
                    'admin_id' => $data['id'],
                    'group_id' => $value,
                    'is_deleted' => 0,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $this->adminHasGroup->addMultipleRecords($insertAdminHasGroup);
            }
        }
        if ($data['is_actived'] == 1) {
            DB::table('admin_lock_out')->where('admin_id', $id)->delete();
        }
        $edit = $this->admin->edit($param, $data['id']);
        return response()->json([
            'error' => false,
            'message' => ''
        ]);
    }

    /**
     * Lấy danh sách admin không phân trang
     *
     * @param array $filters
     * @return mixed
     */
    public function getListAll(array $filters = [])
    {
        return $this->admin->getListAll($filters);
    }

    /**
     * Lấy danh sách quyền truy cập người dùng
     *
     * @param int $admin_id
     * @return array|mixed
     */
    public function getListActionById($admin_id)
    {
        $result = $this->admin->getListActionById($admin_id)->toArray();

        return $result;
    }


    /**
     * Chỉnh sửa trạng thái my store user
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function changeStatus(array $data, $id)
    {
        if ($data['is_actived'] == 1) {
            DB::table('admin_lock_out')->where('admin_id', $id)->delete();
        }
        // TODO: Implement changeStatus() method.
        return $this->admin->changeStatus($data, $id);
    }

    public function updatePassword(array $data, $id)
    {

        $tk = $this->admin->getDetail($id);
        $pass = isset($data['password']) ? $data['password'] : '23873463';
//        $params['is_change_pass'] = !$data['is_activated'];
        $item = [
            'email' => $tk['email'],
            'full_name' => $tk['full_name'],
            'password' =>  Hash::make(strip_tags($pass)),
            'is_change_pass' => !$data['is_activated']
        ];
        $this->admin->edit($item, $id);
        return response()->json([
            'error' => false,
            'message' => __('core::admin.reset-password.UPDATE_SUCCESS'),
//            'item' => view('core::index.popup.popup-reset-password-success', $item)->render()
        ]);
    }

    /**
     * Lấy danh sách nhóm quyền cho user chọn.
     *
     * @param array $listChildId
     * @return mixed
     */
    public function getListGroupChildForPopup(array $listChildId)
    {
        $group_id_list = [];

        if (count($listChildId) > 0) {
            if (isset($listChildId['group_id_list'])) {
                if (isset($listChildId['group_id'])
                    && $listChildId['group_id'] > 0
                ) {
                    array_push(
                        $listChildId['group_id_list'],
                        $listChildId['group_id']
                    );
                    $listParent
                        = $this->getListParent($listChildId['group_id']);
                    $listParent = $listParent->keyBy('group_id')->keys()->all();
                    $group_id_list = array_merge(
                        $listParent,
                        $listChildId['group_id_list']
                    );
                } else {
                    $group_id_list = $listChildId['group_id_list'];
                }
            } else {
                if (isset($listChildId['group_id'])
                    && $listChildId['group_id'] > 0
                ) {
                    $listParent
                        = $this->getListParent($listChildId['group_id']);
                    $listParent = $listParent->keyBy('group_id')->keys()->all();
                    $group_id_list[] = $listChildId['group_id'];
                    $group_id_list = array_merge($listParent, $group_id_list);
                }
            }

            $listChild
                = $this->getAdminGroupListAll(['notin' => $group_id_list]);
        } else {
            $listChild = $this->getAdminGroupListAll();
        }

        return $listChild;
    }

    public function getListParent($group_id)
    {
        return $this->adminGroup->getListParent($group_id);
    }

    public function getAdminGroupListAll(array $filters = [])
    {
        $result = $this->adminGroup->getListAll($filters);

        return $result->toArray();
    }

    /**
     * Lấy danh sách user cho popup
     *
     * @param array $listUserId
     * @return mixed
     */
    public function getListUserForPopup(array $listUserId)
    {
        if (count($listUserId) > 0 && isset($listUserId['user_id_list'])) {
            $result = $this->admin->getListAll(['notin' => $listUserId['user_id_list']]);
        } else {
            $result = $this->admin->getListAll();
        }

        return $result;
    }

    /**
     * Lấy danh sách menu theo admin id
     *
     * @param int $admin_id
     * @return mixed
     */
    public function getListMenuByAdminId($admin_id)
    {
        $result = $this->admin->getListMenuByAdminId($admin_id)->toArray();

        return $result;
    }

    public function getUserByEmail($email)
    {
        $getUserByEmail = $this->admin->getUserByEmail($email);
        if ($getUserByEmail == null) {
            return response()->json(['error' => true]);
        } else {
            $ran_string = Str::random(32);
            $data = [
                'remember_token' => $ran_string,
            ];
            DB::table('admin')->where('email', $email)->update($data);
            //viết hàm gửi email
            Mail::to($email)->send(new ResetPassword($ran_string));

            return response()->json([
                'error' => false,
                'message' => 'Gửi email thành công'
            ]);
        }
    }

    public function getUserToken($token)
    {
        return $this->admin->getUserToken($token);
    }

    public function forgetPassword($data)
    {
        $param = $data;

        $validator = \Validator::make($param, [
            'password' => ['required', 'required_with:password_confirm', 'min:6'],

        ], [
            'password.required' => 'Hãy nhập mật khẩu'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Reset password fail'
            ]);
        } else {
            $param['password'] =  Hash::make(strip_tags($param['password']));

            $data = [
                'password' => $param['password'],
                'remember_token' => null
            ];

            //change password
            $getUser = $this->admin->getUserToken($param['token']);

            $this->admin->edit($data, $getUser['id']);

            return response()->json([
                'error' => false,
                'message' => 'Reset password success'
            ]);

        }
    }

    public function changPassword(array $data = [])
    {
        $id = Auth::id();
        $tk = $this->admin->getDetail($id);
        if (Hash::check($data['old_password'], $tk['password'])) {
            $item = [
                'email'     => $tk['email'],
                'full_name' => $tk['full_name'],
                'password'  => Hash::make(strip_tags($data['new_password'])),
            ];
            $this->admin->edit($item, $id);
            return [
                'error' => false,
                'message' => __('core::validation.change_password.edit_success'),
            ];
        } else {
            return [
                'error'   => true,
                'message' => __(
                    'core::validation.change_password.error_old_password'
                )
            ];
        }
    }
}
