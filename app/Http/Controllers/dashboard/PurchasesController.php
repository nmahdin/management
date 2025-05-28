<?php

namespace App\Http\Controllers\dashboard;

use App\helper\services\Custom;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\PurchasesCategory;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class PurchasesController extends Controller
{
    // start purchases
    public function purchases_list()
    {
        $n = Purchase::count();
        $purchases = Purchase::all();
        return view('dashboard.purchases.list', ['n' => $n, 'purchases' => $purchases]);
    }

    public function purchases_create()
    {
        $accounts = Accounts::all();
        return view('dashboard.purchases.create', compact('accounts'));
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

        $purchase = Purchase::create($data);


        return redirect()->route('purchases.payments.create', ['purchase_id' => $purchase->id, 'amount' => $data['total_price'], 'total_price' => $data['seller_id']])->with('created', $data['name']);
    }

    public function purchases_detail($id)
    {
        $purchase = Purchase::findOrFail($id);
        return view('dashboard.purchases.detail', ['purchase' => $purchase]);
    }

    public function purchases_delete_picture($id)
    {
        $purchase = Purchase::findOrFail($id);
//        dd(public_path('assets/files/purchases/'.$purchase->picture));
        if ($purchase->picture != null) {
            if (File::exists(public_path('/assets/files/purchases/' . $purchase->picture))) {
                File::delete(public_path('/assets/files/purchases/' . $purchase->picture));
                $purchase->update(['picture' => null]);
            }
            return back()->with('picture', 'عکس با موفقیت حذف شد.');
        }
        return back()->with('picture', 'عکس برای حذف وجود نداشت.');

    }

    public function purchases_delete($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();
        return back()->with('deleted', $purchase->name);
    }

    public function purchases_trash()
    {
        $purchases = Purchase::onlyTrashed()->get();
        $n = Purchase::onlyTrashed()->count();
        return view('dashboard.purchases.trash', ['purchases' => $purchases, 'n' => $n]);
    }

    public function purchases_trash_delete($id)
    {
        $purchase = Purchase::onlyTrashed()->findOrFail($id);
        $purchase->forceDelete();
        return back()->with('deleted', $purchase->name);
    }

    public function purchases_trash_restore($id)
    {
        $purchase = Purchase::onlyTrashed()->findOrFail($id);
        $purchase->restore();
        return back()->with('restored', $purchase->name);
    }

    public function purchases_edit($id)
    {
        return view('dashboard.purchases.edit', ['purchase' => Purchase::findOrFail($id)]);
    }

    public function purchases_edit_store(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
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
            if (File::exists(public_path('/assets/files/purchases/' . $purchase->picture))) {
                File::delete(public_path('/assets/files/purchases/' . $purchase->picture));
                $purchase->update(['picture' => null]);
            }

            $data['picture'] = now()->timestamp . '.' . $file->getClientOriginalExtension();
        }
        if ($data['date'] !== $purchase->date)
            $data['date'] = Custom::changDate($data['date']);

        $purchase->update($data);

        return redirect(route('purchases.list'))->with('created', $data['name']);
    }

    // payments
    public function purchases_payments_list()
    {

    }

    public function purchases_payments_create(Request $request)
    {
        $accounts = Accounts::all();
        if ($request->has('purchase_id')) {
            $purchase = Purchase::findOrFail($request->purchase_id);
            if ($request->has('amount')) {
                $amount = $request->amount;
                return view('dashboard.purchases.payments.create', compact('purchase', 'amount', 'accounts'));
            }

            return view('dashboard.purchases.payments.create', compact('purchase', 'accounts'));
        } else {
            $purchases = Purchase::all();
            if ($request->has('amount')) {
                $amount = $request->amount;
                return view('dashboard.purchases.payments.create', compact('purchases', 'amount', 'accounts'));
            }
            return view('dashboard.purchases.payments.create', compact('purchases', 'accounts'));
        }
    }

    public function purchases_payments_create_post(Request $request)
    {
        $data = $request->validate([
            'purchase_id' => ['required', 'exists:orders,id'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'max:255'],
            'status' => ['required', 'in:paid,unpaid'],
            'label_id' => ['required', 'exists:transactions_labels,id'],
            'account_payment_way' => ['required'],
            'tracking_number' => ['nullable', 'max:255'],
            'note' => ['nullable', 'max:522'],
        ]);

        // اطلاعات حساب و روش پرداخت را از رشته جدا کنید
        [$accountId, $paymentWay] = explode('_', $data['account_payment_way']);

        if (!Accounts::find($accountId)) {
            return back()->withErrors(['account_payment_way' => 'حساب انتخاب شده معتبر نیست.']);
        }

        if (!Purchase::find($data['purchase_id'])) {
            return back()->withErrors(['purchase_id' => 'خرید انتخاب شده معتبر نیست.']);
        }


        $data['date'] = Custom::changDate($request->date);
        $data['seller_id'] = Purchase::find($data['purchase_id'])->seller_id;

        $account = Accounts::find($accountId);
        $account->update([
            'outputs' => $account->outputs = +$data['amount'],
            'count' => $account->count = +1,
        ]);

        Transaction::create([
            'name' => 'پرداخت مبلغ خرید',
            'type' => 'output',
            'date' => $data['date'],
            'amount' => $data['amount'],
            'user_id' => Auth::user()->id,
            'tracking_number' => $data['tracking_number'],
            'pay_id' => $data['seller_id'],
            'account_id' => $accountId,
            'payment_way' => $paymentWay,
            'label_id' => $data['label_id'],
            'category' => 'purchases',
            'status' => $data['status'],
            'source_type' => 'purchases',
            'source_id' => $data['purchase_id'],
            'notes' => $data['note'],
        ]);

        return redirect(route('purchases.detail', $data['purchase_id']))->with('success', 'پرداخت با موفقیت ثبت شد.');
    }

    public function purchases_payments_edit($id)
    {

    }

    public function purchases_payments_update($id)
    {

    }

    public function purchases_payments_delete($id)
    {

    }

    public function purchases_payments_trash()
    {

    }

    public function purchases_payments_trash_delete($id)
    {

    }

    public function purchases_payments_trash_restore($id)
    {

    }

    public function purchases_payments_paid($id)
    {
        $trasaction = Transaction::findOrFail($id);
        $trasaction->update([
                'status' => 'paid',
            ]);
        $price = number_format($trasaction->amount , 0 , '' ) . ' ' .'تومان';
        return back()->with('success' , "تراکنش مربوطه به عنوان پرداخت شده علامت گذاری شد. مبلغ: $price");
    }

    // categories
    public function purchases_categories_list()
    {
        $n = PurchasesCategory::count();
        $categories = PurchasesCategory::all();
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
        return back()->with('created', $data['name']);
    }

    public function purchases_categories_edit($id)
    {
        return view('dashboard.purchases.categories.edit', ['category' => PurchasesCategory::findOrFail($id)]);
    }

    public function purchases_categories_update($id)
    {
        $purchases_category = PurchasesCategory::findOrFail($id);
        $data = request()->validate([
            'name' => ['required', 'max:255', Rule::unique('purchases_category')->ignore($purchases_category->name, 'name')],
            'notes' => ['nullable'],
        ]);
        $purchases_category->update($data);
        return redirect(route('purchases.categories.list'))->with('created', $data['name']);
    }

    public function purchases_categories_delete($id)
    {
        $purchases_category = PurchasesCategory::findOrFail($id);
        $purchases_category->delete();
        return back()->with('deleted', $purchases_category->name);
    }

    public function purchases_categories_trash()
    {
        $n = PurchasesCategory::onlyTrashed()->count();
        $categories = PurchasesCategory::onlyTrashed()->get();
        return view('dashboard.purchases.categories.trash', ['n' => $n, 'categories' => $categories]);
    }

    public function purchases_categories_trash_delete($id)
    {
        $purchases_category = PurchasesCategory::onlyTrashed()->findOrFail($id);
        $purchases_category->forceDelete();
        return back()->with('deleted', $purchases_category->name);
    }

    public function purchases_categories_trash_restore($id)
    {
        $purchases_category = PurchasesCategory::onlyTrashed()->findOrFail($id);
        $purchases_category->restore();
        return back()->with('restored', $purchases_category->name);
    }

    // sellers
    public function sellers_list()
    {
        $n = Seller::count();
        $sellers = Seller::all();
        return view('dashboard.purchases.sellers.list', ['n' => $n, 'sellers' => $sellers]);
    }

    public function sellers_create()
    {
        return view('dashboard.purchases.sellers.create');
    }

    public function sellers_edit($id)
    {
        $seller = Seller::findOrFail($id);
        return view('dashboard.purchases.sellers.edit', compact('seller'));
    }

    public function sellers_edit_post(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string',
            'note' => 'nullable|string'
        ]);

        $seller->update($validated);

        return redirect()->route('purchases.sellers.list')
            ->with('edited', $seller->name);
    }

    public function sellers_create_post()
    {
        $data = request()->validate([
            'name' => ['required', 'max:255', 'unique:sellers'],
            'number' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'max:255'],
            'notes' => ['nullable'],
        ]);
        Seller::create($data);
        return back()->with('created', $data['name']);
    }

    public function sellers_delete($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->delete();
        return redirect(route('purchases.sellers.list'))->with('deleted', $seller->name);
    }

    public function sellers_trash()
    {
        $sellers = Seller::onlyTrashed()->get();
        $n = Seller::onlyTrashed()->count();
        return view('dashboard.purchases.sellers.trash', ['sellers' => $sellers, 'n' => $n]);
    }

    public function sellers_trash_delete($id)
    {
        $seller = Seller::onlyTrashed()->findOrFail($id);
        $seller->forceDelete();
        return redirect(route('purchases.sellers.trash'))->with('deleted', $seller->name);
    }

    public function sellers_trash_restore($id)
    {
        $seller = Seller::onlyTrashed()->findOrFail($id);
        $seller->restore();
        return redirect(route('purchases.sellers.trash'))->with('restored', $seller->name);
    }

    // end purchases
}
