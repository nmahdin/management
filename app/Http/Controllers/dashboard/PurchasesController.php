<?php

namespace App\Http\Controllers\dashboard;

use App\helper\services\Custom;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchasesCategory;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PurchasesController extends Controller
{
    // start purchases
    public function purchases_list()
    {
        $n = Purchase::Where('deleted', 0)->count();
        $purchases = Purchase::Where('deleted', 0)->get();
        return view('dashboard.purchases.list', ['n' => $n, 'purchases' => $purchases]);
    }

    public function purchases_create()
    {
        return view('dashboard.purchases.create');
    }

    public function purchases_create_post(Request $request)
    {

        $data = $request->validate([
            'code' => ['required', Rule::unique('purchases')],
            'picture' => ['nullable'],
            'name' => ['required'],
            'color' => ['required'],
            'amount' => ['required'],
            'unit' => ['required'],
            'unit_price' => ['integer', 'required'],
            'total_price' => ['integer', 'required'],
            'date' => ['required'],
            'category_id' => ['required', 'exists:purchases_category,id'],
            'seller_id' => ['required'],
            'notes' => ['nullable'],
        ]);

        if ($request->hasFile('picture')) {
            $file = $request->picture;
            $path = "/assets/files/purchases";
            $file->move(public_path($path), now()->timestamp . '.' . $file->getClientOriginalExtension());

            $data['picture'] = now()->timestamp . '.' . $file->getClientOriginalExtension();
        }
        $data['date'] = Custom::changDate($data['date']);
        Purchase::create($data);

        return redirect(route('purchases.create'))->with('created', $data['name']);
    }

    public function purchases_detail(Purchase $purchase)
    {
        return view('dashboard.purchases.detail', ['purchase' => $purchase]);
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
        return view('dashboard.purchases.trash', ['purchases' => $purchases, 'n' => $n]);
    }

    public function purchases_trash_delete(Purchase $purchase)
    {
        $name = $purchase->name;
        $purchase->delete();
        return back()->with('deleted', $name);
    }

    public function purchases_trash_restore(Purchase $purchase)
    {
        $purchase->update(['deleted' => 0]);
        return back()->with('restored', $purchase->name);
    }

    public function purchases_edit(Purchase $purchase)
    {
        return view('dashboard.purchases.edit', ['purchase' => $purchase]);
    }

    public function purchases_edit_store(Request $request, Purchase $purchase)
    {
        $data = $request->validate([
            'code' => ['required', Rule::unique('purchases')->ignore($purchase->code, 'code')],
            'picture' => ['nullable'],
            'name' => ['required'],
            'color' => ['required'],
            'amount' => ['required'],
            'unit' => ['required'],
            'unit_price' => ['integer', 'required'],
            'total_price' => ['integer', 'required'],
            'date' => ['required'],
            'category_id' => ['required', 'exists:purchases_category,id'],
            'seller_id' => ['required'],
            'notes' => ['nullable'],
        ]);

        if ($request->hasFile('picture')) {
            $file = $request->picture;
            $path = "/assets/files/purchases";
            $file->move(public_path($path), now()->timestamp . '.' . $file->getClientOriginalExtension());

            $data['picture'] = now()->timestamp . '.' . $file->getClientOriginalExtension();
        }
        if ($data['date'] !== $purchase->date)
            $data['date'] = Custom::changDate($data['date']);

        $purchase->update($data);

        return redirect(route('purchases.list'))->with('created', $data['name']);
    }

    // categories
    public function purchases_categories_list()
    {
        $n = PurchasesCategory::where('deleted', 0)->count();
        $categories = PurchasesCategory::where('deleted', 0)->get();
        return view('dashboard.purchases.categories.list', ['n' => $n, 'categories' => $categories]);
    }

    public function purchases_categories_create()
    {
        return view('dashboard.purchases.categories.create');
    }

    public function purchases_categories_create_post()
    {
        $data = request()->validate([
            'name' => ['required', 'max:255', 'unique:purchases_category'],
            'notes' => ['nullable'],
        ]);
        PurchasesCategory::create($data);
        return redirect(route('purchases.category.create'))->with('created', $data['name']);
    }

    public function purchases_categories_delete(PurchasesCategory $purchases_category)
    {
//        $gk = PurchasesCategory::find(2)->get();
//        dd($gk);
        $purchases_category->update(['deleted' => 1]);
        return back()->with('deleted', $purchases_category->name);
    }

    public function purchases_categories_trash()
    {
        $n = PurchasesCategory::where('deleted', 1)->count();
        $categories = PurchasesCategory::where('deleted', 1)->get();
        return view('dashboard.purchases.categories.trash', ['n' => $n, 'categories' => $categories]);
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
        $n = Seller::where('deleted', 0)->count();
        $sellers = Seller::where('deleted', 0)->get();
        return view('dashboard.purchases.sellers.list', ['n' => $n, 'sellers' => $sellers]);
    }

    public function sellers_create()
    {
        return view('dashboard.purchases.sellers.create');
    }

    public function sellers_edit(Seller $seller)
    {
        return view('dashboard.purchases.sellers.edit', compact('seller'));
    }

    public function sellers_edit_post(Request $request, Seller $seller)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11',
            'address' => 'nullable|string',
            'note' => 'nullable|string'
        ]);

        $seller->update($validated);

        return redirect()->route('purchases.sellers.list')
            ->with('success', "فروشنده {$seller->name} با موفقیت ویرایش شد");
    }

    public function sellers_create_post()
    {
        $data = request()->validate([
            'name' => ['required', 'max:255', 'unique:sellers'],
            'number' => ['nullable', 'integer'],
            'phone' => ['nullable', 'integer'],
            'address' => ['nullable', 'max:255'],
            'notes' => ['nullable'],
        ]);
        Seller::create($data);
        return redirect(route('purchases.sellers.create'))->with('created', $data['name']);
    }

    public function sellers_delete(Seller $seller)
    {
        $seller->update(['deleted' => 1]);
        return redirect(route('purchases.sellers.list'))->with('deleted' , $seller->name);
    }

    public function sellers_trash()
    {
        $sellers = Seller::where('deleted', 1)->get();
        $n = Seller::where('deleted', 1)->count();
        return view('dashboard.purchases.sellers.trash' , ['sellers' => $sellers , 'n' => $n]);
    }

    public function sellers_trash_delete(Seller $seller)
    {
        $name = $seller->name;
        $seller->delete();
        return redirect(route('purchases.sellers.trash'))->with('deleted' , $name);
    }

    public function sellers_trash_restore(Seller $seller)
    {
        $seller->update(['deleted' => 0]);
        return redirect(route('purchases.sellers.trash'))->with('restored' , $seller->name);
    }

    // end purchases
}
