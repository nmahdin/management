<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomersController extends Controller
{
    // start customers
    public function customers_list()
    {
        $customers = Customer::all();
        $count = Customer::count();
        return view('dashboard.customers.list', ['customers' => $customers, 'n' => $count]);
    }

    public function customers_trash()
    {
        $customers = Customer::onlyTrashed()->get();
        $count = Customer::onlyTrashed()->count();
        return view('dashboard.customers.trash', ['customers' => $customers, 'n' => $count]);
    }

    public function customers_create()
    {
        return view('dashboard.customers.create');
    }

    public function customer_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:250'],
            'number' => ['min:8', 'max:12', Rule::unique('customers')],
            'city' => ['required', 'min:1', 'max:255'],
            'address' => ['max:250'],
            'com_ways' => ['required', 'array'],
            'birthday' => ['nullable'],
            'gender' => ['required' , 'in:female,male'],
            'category_id' => ['nullable'],
//            'attachment' => ['nullable'],
        ]);

        $customer = Customer::create([
            'name' => $data['name'],
            'number' => $data['number'],
            'city' => $data['city'],
            'address' => $data['address'],
            'com_ways' => json_encode($data['com_ways']),
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'category_id' => $data['category_id'],
//            'attachment' => $data['attachment'],
        ]);
        return back()->with('created', $customer->name);
    }

    public function customer_info(Customer $customer)
    {
        $customer = $customer;
        return view('dashboard.customers.info', compact('customer'));
    }

    public function customer_edit(Customer $customer)
    {
        return view('dashboard.customers.edit', compact('customer'));
    }

    public function customer_edit_post(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => ['required', 'max:250'],
            'number' => ['min:8', 'max:12', Rule::unique('customers')->ignore($customer->id)],
            'city' => ['required', 'min:1', 'max:255'],
            'address' => ['max:250'],
            'com_ways' => ['required', 'array'],
            'gender' => ['required' , 'in:female,male'],
            'category_id' => ['nullable'],
//            'attachment' => ['nullable'],
        ]);

        $customer->update([
            'name' => $data['name'],
            'number' => $data['number'],
            'city' => $data['city'],
            'address' => $data['address'],
            'gender' => $data['gender'],
            'com_ways' => json_encode($data['com_ways']),
            'category_id' => $data['category_id'],
//            'attachment' => $data['attachment'],
        ]);
        return redirect(route('customers.info', $customer->id))->with('edited', $customer->name);
    }

    public function customers_delete(Customer $customer)
    {
        $customer->delete();
        return redirect(route('customers.list'))->with('deleted', $customer->name);
    }

    public function customers_restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();
        return back()->with('restored', $customer->name);
    }

    public function customers_forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $name = $customer->name;
        $customer->forceDelete();
        return back()->with('deleted', $name);
    }

    public function customers_category_list()
    {
        $categories = CustomerCategory::all();
        $n = CustomerCategory::count();
        return view('dashboard.customers.categories.list', ['categories' => $categories , 'n' => $n]);
    }

    public function customers_category_create()
    {
        return view('dashboard.customers.categories.create');
    }

    public function customers_category_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:customer_categories',
            'notes' => 'nullable|string|max:500',
        ]);


        $category = CustomerCategory::create([
            'category_name' => $request->category_name,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('created', $category->category_name);
    }

    public function customers_category_edit($id)
    {
        $category = CustomerCategory::findOrFail($id);
        return view('dashboard.customers.categories.edit', compact('category'));
    }

    public function customers_category_update(Request $request, $id)
    {
        $category = CustomerCategory::findOrFail($id);

        $data = $request->validate([
            'category_name' => 'required|string|max:255|unique:customer_categories',
            'notes' => 'nullable|string|max:500',
        ]);

        $category->update([
            'category_name' => $data['category_name'],
            'notes' => $data['notes'],
        ]);

        return redirect()->route('customers.categories.list')
            ->with('updated', $category->category_name);
    }

    public function customers_category_delete($id)
    {
        $category = CustomerCategory::findOrFail($id);
        $categoryName = $category->category_name;

        // بررسی وابستگی‌ها قبل از حذف
        if ($category->customers()->count() > 0) {
            return redirect()->back()
                ->with('error', 'این دسته‌بندی به مشتریان متصل است و قابل حذف نیست.');
        }

        // انتقال به سطل زباله
        $category->delete();

        return redirect()->route('customers.categories.list')
            ->with('deleted', $categoryName);
    }

    public function customers_category_trash()
    {
        $categories = CustomerCategory::onlyTrashed()->get();
        $n = $categories->count();

        return view('dashboard.customers.categories.trash', compact('categories', 'n'));
    }

    /**
     * بازیابی دسته‌بندی از سطل زباله
     */
    public function customers_category_restore($id)
    {
        $category = CustomerCategory::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->back()->with('restored', $category->category_name);
    }

    /**  حذف دائمی دسته‌بندی از سطل زباله   */
    public function customers_category_forceDelete($id)
    {
        $category = CustomerCategory::onlyTrashed()->findOrFail($id);
        $categoryName = $category->category_name;

        $category->forceDelete();

        return redirect()->back()->with('deleted', $categoryName);
    }
    // end customers
}
