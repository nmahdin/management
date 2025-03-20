<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    // start products
    public function products_list()
    {
        $count = Product::count();
        $products = Product::all();
        return view('dashboard.products.list', ['n' => $count, 'products' => $products]);
    }

    public function products_trash()
    {
        $count = Product::onlyTrashed()->count();
        $products = Product::onlyTrashed()->get();
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

        return back()->with('created', $data['name']);
    }

    public function product_delete(Product $product)
    {
        $product->delete();
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
            'picture' => ['nullable' , 'image' , 'max:2048'],
            'note' => ['nullable'],
        ]);
        $total_price = $data['price_materials'] + $data['profit'] + $data['salary'] + $data['materials_profit'] + $data['additional_costs'];
        $data['total_price'] = $total_price;

        $file = $request->picture;
        $path = "/assets/img/products";

        if ($file != null) {
            if ($product->picture != null) {
                if (File::exists(public_path($product->picture))) {
                    File::delete(public_path($product->picture));
                }
            }

            $file->move(public_path($path), $product->id . '.' . $file->getClientOriginalExtension());
            $data['picture'] = $path . '/' . $product->id . '.' . $file->getClientOriginalExtension();
//            $product->update(['picture' => $path . '/' . $product->id . '.' . $file->getClientOriginalExtension()]);
        }

        $product->update($data);

        return redirect(route('products.detail', $product->id))->with('edited', $data['name']);
    }

    public function product_delete_picture(Product $product)
    {
        if ($product->picture != null) {
            if (File::exists(public_path($product->picture))) {
                File::delete(public_path($product->picture));
                $product->update(['picture' => null]);
            }
        }
        return back()->with('picture' , 'عکس با موفقیت حذف شد.');
    }

    public function product_detail(Product $product)
    {
        return view('dashboard.products.detail', compact('product'));
    }

    public function product_delete_trash($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return back()->with('deleted', $product->name);
    }

    public function product_restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return back()->with('restored', $product->name);
    }

    // category
    public function products_categories_list()
    {
        $count = Category::count();
        $categories = Category::all();
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

    public function products_category_trash_d($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return back()->with('deleted', $category->name);
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

    public function products_category_delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return back()->with('deleted', $category->name);
    }

    public function products_category_trash()
    {
        $count = Category::onlyTrashed()->count();
        $categories = Category::onlyTrashed()->get();
        return view('dashboard.products.categories.trash', ['n' => $count, 'categories' => $categories]);
    }

    public function products_category_trash_restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return back()->with('restored', $category->name);
    }
    // end products

    // start products statuses
    public function products_statuses_list()
    {
        return view('dashboard.products.statuses.list', ['n' => ProductStatus::count(), 'statuses' => ProductStatus::all()]);
    }

    public function products_statuses_create()
    {
        return view('dashboard.products.statuses.create');
    }

    public function products_statuses_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255' , 'unique:' . ProductStatus::class],
            'note' => ['nullable'],
        ]);

        ProductStatus::create($data);
        return back()->with('created', $data['name']);
    }

    public function products_statuses_edit($id)
    {
        $status = ProductStatus::findOrFail($id);
        return view('dashboard.products.statuses.edit', ['status' => $status]);
    }

    public function products_statuses_edit_post(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255' , Rule::unique('products_statuses')->ignore($id)],
            'note' => [],
        ]);
        ProductStatus::findOrFail($id)->update($data);
        return redirect(route('products.statuses.list'))->with('edited', $data['name']);
    }

    public function products_statuses_delete($id)
    {
        $status = ProductStatus::findOrFail($id);
        $status->delete();
        return back()->with('deleted', $status->name);
    }

    public function products_statuses_trash_delete($id)
    {
        $status = ProductStatus::onlyTrashed()->findOrFail($id);
        $status->forceDelete();
        return back()->with('deleted', $status->name);
    }

    public function products_statuses_trash_restore($id)
    {
        $status = ProductStatus::onlyTrashed()->findOrFail($id);
        $status->restore();
        return back()->with('restored', $status->name);
    }

    public function products_statuses_trash_list()
    {

        return view('dashboard.products.statuses.trash', ['n' => ProductStatus::onlyTrashed()->count(), 'statuses' => ProductStatus::onlyTrashed()->get()]);
    }
    // end products statuses
}
