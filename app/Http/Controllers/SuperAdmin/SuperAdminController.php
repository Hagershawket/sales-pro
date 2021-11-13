<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Traits\permissionTrait;
use App\SuperAdmin;
use App\User;
use App\Roles;
use App\Biller;
use App\Warehouse;
use App\CustomerGroup;
use App\Customer;
use Auth;
use Hash;
use Keygen;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class SuperAdminController extends Controller
{
    use permissionTrait;
    public function index()
    {
        $role = Role::find(Auth::guard('admin')->user()->role_id);
        $permission_active = $this->checkPermission($role , 'superadmins-index');
        if($permission_active){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            $lims_admin_list = SuperAdmin::where('is_deleted', false)->get();
            return view('admins.superadmin.index', compact('lims_admin_list', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::guard('admin')->user()->role_id);
        $permission_active = $this->checkPermission($role , 'superadmins-add');
        if($permission_active){
            return view('admins.superadmin.create');
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generatePassword()
    {
        $id = Keygen::numeric(6)->generate();
        return $id;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('superadmins')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
        ]);
        if($request->email) {
            $this->validate($request, [
                'email' => [
                    'email',
                    'max:255',
                        Rule::unique('superadmins')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
            ]);
        }

        $data = $request->all();
        $message = 'SuperAdmin created successfully';
        try {
            Mail::send( 'mail.user_details', $data, function( $message ) use ($data)
            {
                $message->to( $data['email'] )->subject( 'SuperAdmin Account Details' );
            });
        }
        catch(\Exception $e){
            $message = 'SuperAdmin created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
        }
        if(!isset($data['is_active']))
            $data['is_active'] = false;
        $data['is_deleted'] = false;
        $data['role_id'] = 1;
        $data['password'] = bcrypt($data['password']);
        $data['phone'] = $data['phone_number'];
        SuperAdmin::create($data);
        return redirect('admin')->with('message1', $message); 
    }

    public function edit($id)
    {
        $role = Role::find(Auth::guard('admin')->user()->role_id);
        $permission_active = $this->checkPermission($role , 'superadmins-edit');
        if($permission_active){
            $lims_admin_data = SuperAdmin::find($id);
            return view('admins.superadmin.edit', compact('lims_admin_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('superadmins')->ignore($id)->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ]
        ]);
        if($request->email) {
            $this->validate($request, [
                'email' => [
                    'email',
                    'max:255',
                        Rule::unique('superadmins')->ignore($id)->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
            ]);
        }

        $input = $request->except('password');
        if(!isset($input['is_active']))
            $input['is_active'] = false;
        if(!empty($request['password']))
            $input['password'] = bcrypt($request['password']);
        $lims_user_data = SuperAdmin::find($id);
        $lims_user_data->update($input);
        return redirect('admin')->with('message2', 'Data updated successfullly');
    }

    public function profile($id)
    {
        $lims_admin_data = SuperAdmin::find($id);
        return view('admins.superadmin.profile', compact('lims_admin_data'));
    }

    public function profileUpdate(Request $request, $id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $input = $request->all();
        $lims_user_data = SuperAdmin::find($id);
        $lims_user_data->update($input);
        return redirect()->back()->with('message3', 'Data updated successfullly');
    }

    public function changePassword(Request $request, $id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $input = $request->all();
        $lims_user_data = SuperAdmin::find($id);
        if($input['new_pass'] != $input['confirm_pass'])
            return redirect("user/" .  "profile/" . $id )->with('message2', "Please Confirm your new password");

        if (Hash::check($input['current_pass'], $lims_user_data->password)) {
            $lims_user_data->password = bcrypt($input['new_pass']);
            $lims_user_data->save();
        }
        else {
            return redirect("user/" .  "profile/" . $id )->with('message1', "Current Password doesn't match");
        }
        auth()->logout();
        return redirect('/');
    }

    public function deleteBySelection(Request $request)
    {
        $user_id = $request['userIdArray'];
        foreach ($user_id as $id) {
            $lims_user_data = SuperAdmin::find($id);
            $lims_user_data->is_deleted = true;
            $lims_user_data->is_active = false;
            $lims_user_data->save();
        }
        return 'SuperAdmin deleted successfully!';
    }

    public function destroy($id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        
        $lims_user_data = SuperAdmin::find($id);
        $lims_user_data->is_deleted = true;
        $lims_user_data->is_active = false;
        $lims_user_data->save();
        if(Auth::guard('admin')->user()->id == $id){
            auth()->logout();
            return redirect('/login');
        }
        else
            return redirect('admin')->with('message3', 'Data deleted successfullly');
    }
}
