<?php

  

namespace App\Http\Controllers\Auth;

  

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

  

class Login2Controller extends Controller

{

  

    use AuthenticatesUsers;

    

    protected $redirectTo = '/';

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {
        $this->middleware('guest:admin')->except('logout');

    }

  

    /**

     * Create a new controller instance.

     *

     * @return void

     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function adminLogin()
    {
        return view('admins.auth.adminlogin');
    }
    
    public function login(Request $request)

    {   

        $this->validate($request, [
            'name'   => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['name' => $request->name, 'password' => $request->password])) {

            return redirect('admin');
        }
        else{
            return redirect()->back()
                ->with('error','Email-Address And Password Are Wrong.');
        }

    }

}