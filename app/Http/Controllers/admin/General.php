<?php

namespace App\Http\Controllers\admin;

use App\helper\services\Custom;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\Purchase;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\permissions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;
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
            'birthday' => [],
        ]);

//        dd($data);
        $customer = Customer::create([
            'name' => $data['name'],
            'number' => $data['number'],
            'city' => $data['city'],
            'address' => $data['address'],
            'com_ways' => json_encode($data['com_ways']),
            'birthday' => $data['birthday'],
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
        $data = $request->validate([
            'product_id' => ['required', 'max:255', 'unique:' . Product::class],
            'name' => ['required', 'max:255'],
            'color' => ['required' ,'max:255'],
            'category_id' => ['required' , 'max:255'],
            'partner_id' => ['required' , 'max:255'],
            'status_id' => ['required' , 'max:255'],
            'label' => ['required' , 'max:255'],
            'price_materials' => ['required' , 'max:255'],
            'salary' => ['required' ,'max:255'],
            'profit' => ['required' ,'max:255'],
            'materials_profit' => ['required' ,'max:255'],
            'additional_costs' => ['required' ,'max:255'],
            'inventory' => ['required' , 'max:255'],
            'picture' => ['nullable' , 'image' , 'max:2048'],
            'note' => ['nullable'],
        ]);

        $total_price = $data['price_materials'] + $data['profit'] + $data['salary'] + $data['materials_profit'] + $data['additional_costs'];
        $data['total_price'] = $total_price;

        $file = $request->picture;
        $path = "/assets/img/products";

        $product = Product::create($data);

        $file->move(public_path($path), $product->id .'.'. $file->getClientOriginalExtension());
        $product->update(['picture' => $path.'/'. $product->id .'.'. $file->getClientOriginalExtension()]);

        return redirect(route('product.create'))->with('created', $data['name']);
    }

    public function product_delete(Product $product)
    {
        $product->update(['deleted' => 1]);
        return back()->with('deleted', $product->name);
    }

    public function product_edit(Product $product)
    {
        return view('admin.management.products.edit' , compact('product'));
    }

    public function product_edit_post(Request $request, Product $product)
    {
        $data = $request->validate([
            'product_id' => ['required', 'max:255', Rule::unique('products')->ignore($product->product_id , 'product_id')],
            'name' => ['required', 'max:255'],
            'color' => ['required' ,'max:255'],
            'category_id' => ['required' , 'max:255'],
            'partner_id' => ['required' , 'max:255'],
            'status_id' => ['required' , 'max:255'],
            'label' => ['required' , 'max:255'],
            'price_materials' => ['max:255'],
            'salary' => ['max:255'],
            'profit' => ['max:255'],
            'materials_profit' => ['max:255'],
            'additional_costs' => ['max:255'],
            'inventory' => ['required' , 'max:255'],
            'note' => ['nullable'],
        ]);
        $total_price = $data['price_materials'] + $data['profit'] + $data['salary'] + $data['materials_profit'] + $data['additional_costs'];
        $data['total_price'] = $total_price;

        $product->update($data);

        return redirect(route('product.detail' , $product->id))->with('edited', $data['name']);
    }

    public function product_detail(Product $product)
    {
        return view('admin.management.products.detail' , compact('product'));
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
            'notes' => ['nullable'],
        ]);

        Category::create($data);

        return redirect(route('products.category.create'))->with('created', $data['name']);
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
            'notes' => ['nullable'],
        ]);
        $category->update($data);

        return redirect(route('products.categories.list'))->with('edited' ,$data['name']);
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

    // start products statuses
    public function products_statuses_list()
    {
        return view('admin.management.products.statuses.list' , ['n' => ProductStatus::where('deleted' , 0)->count() , 'statuses' => ProductStatus::where('deleted' , 0)->get()]);
    }

    public function products_statuses_create()
    {
        return view('admin.management.products.statuses.create');
    }

    public function products_statuses_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'note' => [],
        ]);

        ProductStatus::create($data);
        return redirect(route('products.status.create'))->with('created', $data['name']);
    }

    public function products_statuses_edit($status)
    {
        $status = ProductStatus::find($status);
//        dd($productStatus);
        return view('admin.management.products.statuses.edit' , ['status' => $status]);
    }

    public function products_statuses_edit_post(Request $request , ProductStatus $status)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'note' => [],
        ]);

        $status->update($data);
        return redirect(route('products.statuses.list'))->with('edited', $data['name']);
    }

    public function products_statuses_delete(ProductStatus $status)
    {
        $status->update(['deleted' => 1]);
        return redirect(route('products.statuses.list'))->with('deleted' , $status->name);
    }

    public function products_statuses_trash_delete(ProductStatus $status)
    {
        $name =  $status->name;
        $status->delete();
        return redirect(route('products.statuses.trash'))->with('deleted' , $name);
    }

    public function products_statuses_trash_restore(ProductStatus $status)
    {
        $status->update(['deleted' => 0]);
        return redirect(route('products.statuses.trash'))->with('restored' , $status->name);
    }

    public function products_statuses_trash_list()
    {

        return view('admin.management.products.statuses.trash' , ['n' => ProductStatus::where('deleted' , 1)->count() , 'statuses' => ProductStatus::where('deleted' , 1)->get()]);
    }
    // end products statuses

    // start purchases
    public function purchases_list()
    {
        $n = Purchase::Where('deleted', 0)->count();
        $purchases = Purchase::Where('deleted' , 0)->get();
        return view('admin.financial.purchases.list' , ['n' => $n, 'purchases' => $purchases]);
    }
    public function purchases_create()
    {
        return view('admin.financial.purchases.create');
    }
    public function purchases_create_post(Request $request)
    {

        $data = $request->validate([
           'code' => ['required' , Rule::unique('purchases')],
           'picture' => ['nullable'],
           'name' => ['required'],
           'color' => ['required'],
           'amount' => ['required'],
           'unit' => ['required'],
           'unit_price' => ['integer' , 'required'],
           'total_price' => ['integer' ,'required'],
           'date' => ['required'],
           'category_id' => ['required' , 'exists:purchases_category,id'],
           'seller_id' => ['required'],
           'notes' => ['nullable'],
        ]);

        if ($request->hasFile('picture')) {
            $file = $request->picture;
            $path = "/assets/files/purchases";
            $file->move(public_path($path), now()->timestamp .'.'.$file->getClientOriginalExtension());

            $data['picture'] = now()->timestamp .'.'.$file->getClientOriginalExtension();
        }
        $data['date'] = Custom::changDate($data['date']);
        Purchase::create($data);

        return redirect(route('purchases.create'))->with('created', $data['name']);
    }
    public function purchases_detail(Purchase $purchase)
    {
        return view('admin.financial.purchases.detail' , ['purchase' => $purchase]);
    }
    public function purchases_delete(Purchase $purchase)
    {
        $purchase->update(['deleted' => 1]);
        return back()->with('deleted', $purchase->name);
    }
    public function purchases_trash()
    {
        $purchases = Purchase::where('deleted', 1)->get();
        $n = Purchase::where('deleted', 1)->count();
        return view('admin.financial.purchases.trash' ,['purchases' => $purchases , 'n' => $n]);
    }
    public function purchases_trash_delete(Purchase $purchase)
    {
        $name = $purchase->name;
        $purchase->delete();
        return back()->with('deleted' , $name);
    }
    public function purchases_trash_restore(Purchase $purchase)
    {
        $purchase->update(['deleted' => 0]);
        return back()->with('restored' , $purchase->name);
    }
    // categories
    public function purchases_categories_list()
    {

    }
    public function purchases_categories_create()
    {

    }
    public function purchases_categories_create_post()
    {

    }
    public function purchases_categories_delete()
    {

    }
    public function purchases_categories_trash()
    {

    }
    public function purchases_categories_trash_delete()
    {

    }
    public function purchases_categories_trash_restore()
{

}
    // sellers
    public function sellers_list()
    {

    }
    public function sellers_create()
{

}
    public function sellers_create_post()
    {

    }
    public function sellers_delete()
    {

    }
    public function sellers_trash()
    {

    }
    public function sellers_trash_delete()
    {

    }
    public function sellers_trash_restore()
    {

    }

    // end purchases
}


