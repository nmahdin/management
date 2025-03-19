<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    // start products
    public function products_list()
    {
        $count = Product::where('deleted', 0)->count();
        $products = Product::where('deleted', 0)->get();
        return view('dashboard.products.list', ['n' => $count, 'products' => $products]);
    }

    public function products_trash()
    {
        $count = Product::where('deleted', 1)->count();
        $products = Product::where('deleted', 1)->get();
        return view('dashboard.products.trash', ['n' => $count, 'products' => $products]);
    }

    public function product_create()
    {
        return view('dashboard.products.create');
    }

    public function product_create_post(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'max:255', 'unique:' . Product::class],
            'name' => ['required', 'max:255'],
            'color' => ['required', 'max:255'],
            'category_id' => ['required', 'max:255'],
            'partner_id' => ['required', 'max:255'],
            'status_id' => ['required', 'max:255'],
            'label' => ['required', 'max:255'],
            'price_materials' => ['required', 'max:255'],
            'salary' => ['required', 'max:255'],
            'profit' => ['required', 'max:255'],
            'materials_profit' => ['required', 'max:255'],
            'additional_costs' => ['required', 'max:255'],
            'inventory' => ['required', 'max:255'],
            'picture' => ['nullable', 'image', 'max:2048'],
            'note' => ['nullable'],
        ]);

        $total_price = $data['price_materials'] + $data['profit'] + $data['salary'] + $data['materials_profit'] + $data['additional_costs'];
        $data['total_price'] = $total_price;

        $file = $request->picture;
        $path = "/assets/img/products";

        $product = Product::create($data);
        if ($file != null) {
            $file->move(public_path($path), $product->id . '.' . $file->getClientOriginalExtension());
            $product->update(['picture' => $path . '/' . $product->id . '.' . $file->getClientOriginalExtension()]);
        }

        return redirect(route('product.create'))->with('created', $data['name']);
    }

    public function product_delete(Product $product)
    {
        $product->update(['deleted' => 1]);
        return back()->with('deleted', $product->name);
    }

    public function product_edit(Product $product)
    {
        return view('dashboard.products.edit', compact('product'));
    }

    public function product_edit_post(Request $request, Product $product)
    {
        $data = $request->validate([
            'product_id' => ['required', 'max:255', Rule::unique('products')->ignore($product->product_id, 'product_id')],
            'name' => ['required', 'max:255'],
            'color' => ['required', 'max:255'],
            'category_id' => ['required', 'max:255'],
            'partner_id' => ['required', 'max:255'],
            'status_id' => ['required', 'max:255'],
            'label' => ['required', 'max:255'],
            'price_materials' => ['max:255'],
            'salary' => ['max:255'],
            'profit' => ['max:255'],
            'materials_profit' => ['max:255'],
            'additional_costs' => ['max:255'],
            'inventory' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);
        $total_price = $data['price_materials'] + $data['profit'] + $data['salary'] + $data['materials_profit'] + $data['additional_costs'];
        $data['total_price'] = $total_price;

        $product->update($data);

        return redirect(route('product.detail', $product->id))->with('edited', $data['name']);
    }

    public function product_detail(Product $product)
    {
        return view('dashboard.products.detail', compact('product'));
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
        return view('dashboard.products.categories.list', ['n' => $count, 'categories' => $categories]);
    }

    public function products_category_create()
    {
        return view('dashboard.products.categories.create');
    }

    public function products_category_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', 'unique:' . Category::class],
            'notes' => ['nullable'],
        ]);

        Category::create($data);

        return redirect(route('products.categories.create'))->with('created', $data['name']);
    }

    public function products_category_trash_d(Category $category)
    {
        $name = $category->label;
        $category->delete();
        return redirect(route('products.categories.trash'))->with('deleted', $name);
    }

    public function products_category_edit(Category $category)
    {
        return view('dashboard.products.categories.edit', compact('category'));
    }

    public function products_category_edit_post(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'notes' => ['nullable'],
        ]);
        $category->update($data);

        return redirect(route('products.categories.list'))->with('edited', $data['name']);
    }

    public function products_category_delete(Category $category)
    {
        $category->update(['deleted' => 1]);
        return redirect(route('products.categories.list'))->with('deleted', $category->label);
    }

    public function products_category_trash()
    {
        $count = Category::where('deleted', 1)->count();
        $categories = Category::where('deleted', 1)->get();
        return view('dashboard.products.categories.trash', ['n' => $count, 'categories' => $categories]);
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
        return view('dashboard.products.statuses.list', ['n' => ProductStatus::where('deleted', 0)->count(), 'statuses' => ProductStatus::where('deleted', 0)->get()]);
    }

    public function products_statuses_create()
    {
        return view('dashboard.products.statuses.create');
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
        return view('dashboard.products.statuses.edit', ['status' => $status]);
    }

    public function products_statuses_edit_post(Request $request, ProductStatus $status)
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
        return redirect(route('products.statuses.list'))->with('deleted', $status->name);
    }

    public function products_statuses_trash_delete(ProductStatus $status)
    {
        $name = $status->name;
        $status->delete();
        return redirect(route('products.statuses.trash'))->with('deleted', $name);
    }

    public function products_statuses_trash_restore(ProductStatus $status)
    {
        $status->update(['deleted' => 0]);
        return redirect(route('products.statuses.trash'))->with('restored', $status->name);
    }

    public function products_statuses_trash_list()
    {

        return view('dashboard.products.statuses.trash', ['n' => ProductStatus::where('deleted', 1)->count(), 'statuses' => ProductStatus::where('deleted', 1)->get()]);
    }
    // end products statuses
}
