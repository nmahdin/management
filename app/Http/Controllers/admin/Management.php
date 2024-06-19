<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\permissions;
use Illuminate\Http\Request;

class Management extends Controller
{
    // start users
    public function users_all()
    {
        $users = User::all();
        $n = User::count();
        return view('admin.management.users.all' , ['users' => $users , 'n' => $n]);
    }

    public function users_permissions()
    {
        $permissions = Permission::all();
        $n = Permission::count();
        return view('admin.management.users.show-permissions' , ['permissions' => $permissions , 'n' => $n]);
    }

    public function users_roles()
    {
        $roles = Group::all();
        $n = Group::count();
        return view('admin.management.users.show-roles' , ['roles' => $roles , 'n' => $n]);
    }

    public function users_roles_creat()
    {
        return view('admin.management.users.creat-role');
    }

    public function users_roles_creat_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required' , 'max:255' , 'unique:'.permission::class],
            'label' => ['required' , 'max:255'],
            'permissions' => ['required' , 'array'],
        ]);
        $role = Group::create([
            'name' => $data['name'],
            'label' => $data['label'],
            'note' => $request->note,
        ]);
        $role->permissions()->sync($data['permissions']);
        return redirect(route('users.roles'));
    }
    // end users

    // start customers
    public function customers_list()
    {
        $customers = Customer::where('deleted' , 0)->get();
        $count = Customer::count();
        return view('admin.management.customers.list' , ['customers' => $customers , 'n' => $count]);
    }
    public function customers_creat()
    {

    }

    public function customers_delete(Customer $customer)
    {
        $customer->update(['deleted' => 1]);
        return back()->with('deleted' , $customer->name);
    }
    // end customers
}
