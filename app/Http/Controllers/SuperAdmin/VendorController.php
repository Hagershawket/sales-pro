<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\SuperAdmin;
use App\User;
use App\Roles;
use App\Biller;
use App\Warehouse;
use App\CustomerGroup;
use App\Customer;
use App\Vendor;
use Auth;
use Hash;
use Keygen;
use DB;
use App\Traits\permissionTrait;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class VendorController extends Controller
{
    use permissionTrait;

    public function index()
    {
        $role = Role::find(Auth::guard('admin')->user()->role_id);
        $permission_active = $this->checkPermission($role , 'vendors-index');
        if($permission_active){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            $lims_vendor_list = Vendor::where('is_deleted', false)->get();
            return view('admins.vendor.index', compact('lims_vendor_list', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::guard('admin')->user()->role_id);
        $permission_active = $this->checkPermission($role , 'vendors-add');
        if($permission_active){
            return view('admins.vendor.create');
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
                    Rule::unique('vendors')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif',
        ]);

        $data = $request->except('image');
        $message = 'Vendor created successfully';
        $image = $request->image;
        if(isset($image)) {            
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis");
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/vendor', $imageName);
            $data['image'] = $imageName;
        }
        if(!isset($data['is_active']))
            $data['is_active'] = false;
        $data['is_deleted'] = false;
        $data['phone'] = $data['phone_number'];
        $data['createdby_id'] = Auth::guard('admin')->user()->id;
        $vendor = Vendor::create($data);
        if(!isset($data['admin_is_active']))
            $data['is_active'] = false;
        else
            $data['is_active'] = true;
        $data['is_deleted'] = false;
        $data['name'] = $data['admin_name'];
        $data['password'] = bcrypt($data['password']);
        $data['phone'] = $data['admin_phone_number'];
        $data['role_id'] = 1;
        $data['v_id'] = $vendor->id;
        $user = User::create($data);
        $vendor->admin_id = $user->id;
        $vendor->save();
        return redirect('admin/vendors')->with('message1', $message); 
    }

    public function edit($id)
    {
        $role = Role::find(Auth::guard('admin')->user()->role_id);
        $permission_active = $this->checkPermission($role , 'vendors-edit');
        if($permission_active){
            $lims_vendor_data = Vendor::find($id);
            $lims_user_data = User::where('id', $lims_vendor_data->admin_id)->first();
            return view('admins.vendor.edit', compact('lims_vendor_data', 'lims_user_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $vendor_data = Vendor::find($id);
        $user_data = User::where('id', $vendor_data->admin_id )->first();

        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('vendors')->ignore($id)->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif',
        ]);
        if($request->email) {
            $this->validate($request, [
                'email' => [
                    'email',
                    'max:255',
                        Rule::unique('users')->ignore($user_data->id)->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
            ]);
        }

        $input = $request->except('password','image');
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis");
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/vendor', $imageName);
            $input['image'] = $imageName;
        }
        if(!isset($input['is_active']))
            $input['is_active'] = false;
        $input['phone'] = $input['phone_number'];
        $lims_vendor_data = Vendor::find($id);
        $lims_vendor_data->update($input);
        $lims_user_data = User::where('id', $lims_vendor_data->admin_id )->first();
        if(!isset($input['admin_is_active']))
            $input['is_active'] = false;
        else
            $input['is_active'] = true;
        if(!empty($request['password']))
            $input['password'] = bcrypt($request['password']);
        $input['is_deleted'] = false;
        $input['name'] = $input['admin_name'];
        $input['phone'] = $input['admin_phone_number'];
        $lims_user_data->update($input);
        return redirect('admin/vendors')->with('message2', 'Data updated successfullly');
    }

    public function profile($id)
    {
        $lims_admin_data = Vendor::find($id);
        return view('admins.superadmin.profile', compact('lims_admin_data'));
    }

    public function profileUpdate(Request $request, $id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $input = $request->all();
        $lims_user_data = Vendor::find($id);
        $lims_user_data->update($input);
        return redirect()->back()->with('message3', 'Data updated successfullly');
    }

    public function changePassword(Request $request, $id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $input = $request->all();
        $lims_user_data = Vendor::find($id);
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
            $lims_user_data = Vendor::find($id);
            $lims_user_data->is_deleted = true;
            $lims_user_data->is_active = false;
            $lims_user_data->save();
        }
        return 'Vendor deleted successfully!';
    }

    public function destroy($id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        
        $lims_vendor_data = Vendor::find($id);
        $lims_vendor_data->is_deleted = true;
        $lims_vendor_data->is_active = false;
        $lims_vendor_data->save();
        $lims_admin_data = User::where('id', $lims_vendor_data->admin_id)->first();
        $lims_admin_data->is_deleted = true;
        $lims_admin_data->is_active = false;
        $lims_admin_data->save();
        if(Auth::guard('admin')->user()->id == $id){
            auth()->logout();
            return redirect('/login');
        }
        else
            return redirect('admin/vendors')->with('message3', 'Data deleted successfullly');
    }
}
