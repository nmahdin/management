<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\permissions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\PseudoTypes\ConstExpression;

class General extends Controller
{
    // start users
    public function users_all()
    {
        $users = User::all();
        $n = User::count();
        return view('admin.management.users.all', ['users' => $users, 'n' => $n]);
    }

    public function users_permissions()
    {
        $permissions = Permission::all();
        $n = Permission::count();
        return view('admin.management.users.show-permissions', ['permissions' => $permissions, 'n' => $n]);
    }

    public function users_roles()
    {
        $roles = Group::all();
        $n = Group::count();
        return view('admin.management.users.show-roles', ['roles' => $roles, 'n' => $n]);
    }

    public function users_roles_creat()
    {
        return view('admin.management.users.creat-role');
    }

    public function users_roles_creat_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', 'unique:' . permission::class],
            'label' => ['required', 'max:255'],
            'permissions' => ['required', 'array'],
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
        $customers = Customer::where('deleted', 0)->get();
        $count = Customer::where('deleted', 0)->count();
        return view('admin.management.customers.list', ['customers' => $customers, 'n' => $count]);
    }

    public function customers_trash()
    {
        $customers = Customer::where('deleted', 1)->get();
        $count = Customer::where('deleted', 1)->count();
        return view('admin.management.customers.trash', ['customers' => $customers, 'n' => $count]);
    }

    public function customers_create()
    {
        return view('admin.management.customers.create');
    }

    public function customer_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:250'],
            'number' => ['min:8', 'max:12', Rule::unique('customers')],
            'city' => ['required', 'min:1', 'max:255'],
            'address' => ['max:250'],
            'com_ways' => ['required', 'array'],
        ]);

//        dd($data);
        $customer = Customer::create([
            'name' => $data['name'],
            'number' => $data['number'],
            'city' => $data['city'],
            'address' => $data['address'],
            'com_ways' => json_encode($data['com_ways']),
        ]);
        return back()->with('created', $customer->name);
    }

    public function customer_info(Customer $customer)
    {
        $customer = $customer;
        return view('admin.management.customers.info', compact('customer'));
    }

    public function customer_edit(Customer $customer)
    {
        return view('admin.management.customers.edit', compact('customer'));
    }

    public function customer_edit_post(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => ['required', 'max:250'],
            'number' => ['min:8', 'max:12', Rule::unique('customers')->ignore($customer->id)],
            'city' => ['required', 'min:1', 'max:255'],
            'address' => ['max:250'],
            'com_ways' => ['required', 'array'],
        ]);

        $customer->update([
            'name' => $data['name'],
            'number' => $data['number'],
            'city' => $data['city'],
            'address' => $data['address'],
            'com_ways' => json_encode($data['com_ways']),
        ]);
        return redirect(route('customer.info', $customer->id))->with('edited', $customer->name);
    }

    public function customers_delete(Customer $customer)
    {
        $customer->update(['deleted' => 1]);
        return redirect(route('customers.list'))->with('deleted', $customer->name);
    }

    public function customers_restore(Customer $customer)
    {
        $customer->update(['deleted' => 0]);
        return back()->with('restored', $customer->name);
    }

    public function customers_delete_trash(Customer $customer)
    {
        $name = $customer->name;
        $customer->delete();
        return back()->with('deleted', $name);
    }
    // end customers

    // start products
    public function products_list()
    {
        $count = Product::where('deleted', 0)->count();
        $products = Product::where('deleted', 0)->get();
        return view('admin.management.products.list', ['n' => $count, 'products' => $products]);
    }

    public function products_trash()
    {
        $count = Product::where('deleted', 1)->count();
        $products = Product::where('deleted', 1)->get();
        return view('admin.management.products.trash', ['n' => $count, 'products' => $products]);
    }

    public function product_create()
    {
        return view('admin.management.products.create');
    }

    public function product_create_post(Request $request)
    {
        dd($request->all());
        return view('admin.management.products.create');
    }

    public function product_delete(Product $product)
    {
        $product->update(['deleted' => 1]);
        return back()->with('deleted', $product->name);
    }

    public function product_edit()
    {

    }

    public function product_detail()
    {

    }

    public function product_delete_trash(Product $product)
    {
        $name = $product->name;
        $product->delete();
        return back()->with('deleted', $name);
    }

    public function product_restore(Product $product)
    {
        $product->update(['deleted' => 0]);
        return back()->with('restored', $product->name);
    }

    // category
    public function products_categories_list()
    {
        $count = Category::where('deleted', 0)->count();
        $categories = Category::where('deleted', 0)->get();
        return view('admin.management.products.categories.list', ['n' => $count, 'categories' => $categories]);
    }

    public function products_category_create()
    {
        return view('admin.management.products.categories.create');
    }

    public function products_category_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', 'unique:' . Category::class],
            'label' => ['required', 'max:255'],
            'notes' => ['max:255'],
        ]);

        Category::create($data);

        return redirect(route('products.category.create'))->with('created', $data['label']);
    }

    public function products_category_trash_d(Category $category)
    {
        $name = $category->label;
        $category->delete();
        return redirect(route('products.category.trash'))->with('deleted', $name);
    }

    public function products_category_edit(Category $category)
    {
        return view('admin.management.products.categories.edit' , compact('category'));
    }

    public function products_category_edit_post(Request $request , Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'label' => ['required', 'max:255'],
            'notes' => ['max:255'],
        ]);
        $category->update($data);

        return redirect(route('products.categories.list'))->with('edited' ,$data['label']);
    }

    public function products_category_delete(Category $category)
    {
        $category->update(['deleted' => 1]);
        return back()->with('deleted', $category->label);
    }

    public function products_category_trash()
    {
        $count = Category::where('deleted', 1)->count();
        $categories = Category::where('deleted', 1)->get();
        return view('admin.management.products.categories.trash', ['n' => $count, 'categories' => $categories]);
    }

    public function products_category_trash_restore(Category $category)
    {
        $category->update(['deleted' => 0]);
        return back()->with('restored', $category->label);
    }
    // end products
}
