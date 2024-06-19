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
        $count = Customer::where('deleted' , 0)->count();
        return view('admin.management.customers.list' , ['customers' => $customers , 'n' => $count]);
    }
    public function customers_trash()
    {
        $customers = Customer::where('deleted' , 1)->get();
        $count = Customer::where('deleted' , 1)->count();
        return view('admin.management.customers.trash' , ['customers' => $customers , 'n' => $count]);
    }
    public function customers_creat()
    {
        return view('admin.management.customers.creat');
    }
    public function customer_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required' , 'max:250'],
            'number' => [ 'min:8' , 'max:12'],
            'address' => ['max:250'],
            'com_ways' => ['array'],
        ]);

        dd($data);
        Customer::create([]);
        return back()->with('created' , );
    }

    public function customers_delete(Customer $customer)
    {
        $customer->update(['deleted' => 1]);
        return back()->with('deleted' , $customer->name);
    }
    public function customers_restore(Customer $customer)
    {
        $customer->update(['deleted' => 0]);
        return back()->with('restored' , $customer->name);
    }
    public function customers_delete_trash(Customer $customer)
    {
        $name = $customer->name;
        $customer->delete();
        return back()->with('deleted' , $name);
    }
    // end customers

    // start products
    public function products_list()
    {

    }
    public function products_trash()
    {

    }
    public function product_create()
    {

    }
    public function product_edit()
    {

    }
    public function product_detail()
    {

    }
    public function products_categories_list()
    {

    }
    public function products_category_create()
    {

    }
    public function products_category_edit()
    {

    }
    public function products_category_delete()
    {

    }
    // end products
}
