<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Currency;
use Auth;

class CurrencyController extends Controller
{
    public function index()
    {
        $vendor_id = Auth::user()->v_id;
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('currency')) {
            $lims_currency_all = Currency::where('vendor_id', $vendor_id)->get();
            return view('currency.index', compact('lims_currency_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['vendor_id'] = Auth::user()->v_id;
        Currency::create($data);
        return redirect()->back()->with('message', 'Currency created successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        Currency::find($data['currency_id'])->update($data);
        return redirect()->back()->with('message', 'Currency updated successfully');
    }

    public function destroy($id)
    {
        Currency::find($id)->delete();
        return redirect()->back()->with('message', 'Currency deleted successfully');
    }
}
