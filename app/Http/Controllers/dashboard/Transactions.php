<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\TransactionLabel;
use Illuminate\Http\Request;

class Transactions extends Controller
{
    public function transactions_general(Request $request)
    {
        // تعداد نمایش در هر صفحه (پیش‌فرض 20)
        $perPage = $request->get('per_page', 20);

        // مرتب‌سازی (پیش‌فرض نزولی)
        $sort = $request->get('sort', 'desc');

        // دریافت فیلترهای داینامیک
        $type = $request->get('type', 'any'); // ورودی/خروجی
        $status = $request->get('status', 'any'); // پرداخت شده/پرداخت نشده
        $account = $request->get('account', 'any'); // حساب مقصد
        $dateFrom = $request->get('date_from', null); // تاریخ شروع
        $dateTo = $request->get('date_to', null); // تاریخ پایان
        $amountFrom = $request->get('amount_from', null); // مبلغ حداقل
        $amountTo = $request->get('amount_to', null); // مبلغ حداکثر
        $paymentMethod = $request->get('payment_method', 'any'); // روش پرداخت
        $includeDeleted = $request->has('include_deleted'); // حذف شده‌ها

        // اعمال فیلترها به کوئری
        $query = Transaction::query();

        if ($type !== 'any') {
            $query->where('type', $type);
        }
        if ($status !== 'any') {
            $query->where('status', $status);
        }
        if ($account !== 'any') {
            $query->where('account_id', $account);
        }
        if ($dateFrom && $dateTo) {
            $query->whereBetween('date', [$dateFrom, $dateTo]);
        }
        if ($amountFrom && $amountTo) {
            $query->whereBetween('amount', [$amountFrom, $amountTo]);
        }
        if ($paymentMethod !== 'any') {
            $query->where('payment_way', $paymentMethod);
        }
        if ($includeDeleted) {
            $query->withTrashed();
        }

        // مرتب‌سازی و صفحه‌بندی
        $transactions = $query->orderBy('date', $sort)->paginate($perPage);

        return view('dashboard.transactions.general', compact('transactions', 'perPage', 'sort', 'type', 'status', 'account', 'dateFrom', 'dateTo', 'amountFrom', 'amountTo', 'paymentMethod', 'includeDeleted'));
    }

    public function printTransactions(Request $request)
    {
        // دریافت تراکنش‌ها بر اساس فیلترهای احتمالی، مشابه general.blade.php
        // می‌توانید فیلترهای دقیقی که در general.blade.php دارید را اینجا کپی کنید
        // برای سادگی، فعلاً همه تراکنش‌ها را می‌گیریم یا بر اساس کوئری‌های موجود در request

        $query = Transaction::query();

        // مثال: اعمال فیلترهایی که در general.blade.php استفاده می‌کنید:
        if ($request->has('type') && $request->type != 'any') {
            $query->where('type', $request->type);
        }
        if ($request->has('status') && $request->status != 'any') {
            $query->where('status', $request->status);
        }
        if ($request->has('account') && $request->account != 'any') {
            $query->where('account_id', $request->account);
        }
        if ($request->has('payment_method') && $request->payment_method != 'any') {
            $query->where('payment_way', $request->payment_method);
        }
        if ($request->has('amount_from') && is_numeric($request->amount_from)) {
            $query->where('amount', '>=', $request->amount_from);
        }
        if ($request->has('amount_to') && is_numeric($request->amount_to)) {
            $query->where('amount', '<=', $request->amount_to);
        }
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        if ($request->has('include_deleted')) {
            $query->withTrashed();
        }

        $sort = $request->get('sort', 'desc');
        $query->orderBy('created_at', $sort);

        $transactions = $query->get(); // همه تراکنش‌های فیلتر شده را دریافت کنید

        return view('dashboard.transactions.print_general', compact('transactions'));
    }

    public function delete_transaction($id)
    {
        $trasaction = Transaction::find($id);
        $trasaction->delete();
        if ($trasaction->where('source_type', 'orders')) {
            if ($order = Order::find($trasaction->source_id)) {
                $sumTransactions = $order->transactions()->sum('amount');
                if ($order->amount > $sumTransactions) {
                    Order::find($trasaction->source_id)
                        ->update([
                            'status' => 'unpaid',
                        ]);
                }

            }

        }

        $massage = 'تراکنش با موفقیت حذف شد.';
        return back()->with('warning', $massage);

    }

    public function transactionDetail($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('dashboard.transactions.detail', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $customers = Customer::all();
        $sellers = Seller::all();
        $accounts = Accounts::all();
        $transactionLabels = TransactionLabel::all();
        $orders = Order::all();
        $purchases = Purchase::all();

        return view('dashboard.transactions.edit', compact('transaction', 'customers', 'sellers', 'accounts', 'transactionLabels', 'orders', 'purchases'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:input,output',
            'date' => 'required|string',
            'amount' => 'required|numeric',
            'payer_information' => 'required|string',
            'tracking_number' => 'nullable|string',
            'account_payment_way' => 'nullable|string',
            'label_id' => 'required|exists:transactions_labels,id', // Required
            'status' => 'required|in:paid,unpaid',
            'notes' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'relation_id' => 'nullable|string',
            'category' => 'nullable|string', // Added
        ]);

        // Convert Persian date to Gregorian
        $date = \App\helper\services\Custom::changDate($request->date);

        $transactionData = [
            'name' => $request->name,
            'type' => $request->type,
            'date' => $date,
            'amount' => $request->amount,
            'payer_information' => $request->payer_information,
            'tracking_number' => $request->tracking_number,
            'user_id' => auth()->id(), // Assuming you want to set the user_id
            'payment_way' => null,
            'account_id' => null,
            'label_id' => $request->label_id,
            'status' => $request->status,
            'notes' => $request->notes,
            'category' => $request->category,
            'source_type' => null,
            'source_id' => null,
        ];

        // Handle account and payment way
        if ($request->account_payment_way) {
            $parts = explode('_', $request->account_payment_way);
            $transactionData['account_id'] = $parts[0];
            $transactionData['payment_way'] = $parts[1];
        }

        // Handle order/purchase relation
        if ($request->relation_id) {
            $relationParts = explode('-', $request->relation_id);
            if ($relationParts[0] == 'order') {
                $transactionData['source_type'] = 'orders';
                $transactionData['source_id'] = $relationParts[1];
            } elseif ($relationParts[0] == 'purchase') {
                $transactionData['source_type'] = 'purchases';
                $transactionData['source_id'] = $relationParts[1];
            }
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete the old file if it exists
            if ($transaction->attached) {
                // Delete the old file
                if (file_exists(public_path($transaction->attached))) {
                    unlink(public_path($transaction->attached));
                }
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->move(public_path('transactions'), $filename); // Store in public directory

            $transactionData['attached'] = 'transactions/' . $filename; // Save relative path
        }


        $transaction->update($transactionData);

        return redirect()->route('transactions.detail', $transaction->id)->with('success', 'تراکنش با موفقیت ویرایش شد.');
    }

    public function pay($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'paid']);
        return back()->with('success' , "تراکنش #$transaction->id با موفقیت به عنوان پرداخت شده علامت گذاری شد.");
    }




    public function new_transaction()
    {
        return view('dashboard.transactions.create');
    }

    public function store_transaction(Request $request)
    {
        $request->validate([
            'type' => 'required|in:input,output',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'account' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        Transaction::create($request->only('type', 'amount', 'date', 'account', 'payment_method', 'notes'));

        return redirect()->route('transactions.general')->with('success', 'تراکنش با موفقیت ثبت شد.');
    }




    // inputs
    public function transactions_inputs()
    {

    }
    public function transactions_inputs_new()
    {

    }
    public function transactions_inputs_new_post(Request $request)
    {

    }
    public function transactions_inputs_edit()
    {

    }
    public function transactions_inputs_edit_post()
    {

    }
    public function transactions_inputs_delete()
    {

    }
    public function transactions_inputs_trash_list()
    {

    }
    public function transactions_inputs_trash_delete()
    {

    }
    public function transactions_inputs_trash_restore()
    {

    }
    // outputs
    public function transactions_outputs()
    {

    }
    public function transactions_outputs_new()
    {

    }
    public function transactions_outputs_new_post(Request $request)
    {

    }
    public function transactions_outputs_delete()
    {

    }
    public function transactions_outputs_edit()
    {

    }
    public function transactions_outputs_edit_post()
    {

    }
    public function transactions_outputs_trash_list()
    {

    }
    public function transactions_outputs_trash_delete()
    {

    }
    public function transactions_outputs_trash_restore()
    {

    }
    // start labels
    public function labels_index()
    {
        $labels = TransactionLabel::paginate(10);
        $n = TransactionLabel::count();
        return view('dashboard.transactions.labels.list', compact('labels' , 'n'));
    }

    public function labels_new()
    {
        return view('dashboard.transactions.labels.create');
    }

    public function labels_new_post(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:transactions_labels,name',
            'notes' => 'nullable|string',
        ]);

        $label = TransactionLabel::create($request->only('name', 'notes'));
        return redirect()->back()->with('created', $label->name);
    }

    public function labels_edit(TransactionLabel $label)
    {
        return view('dashboard.transactions.labels.edit', compact('label'));
    }

    public function labels_edit_post(Request $request, TransactionLabel $label)
    {
        $request->validate([
            'name' => 'required|unique:transactions_labels,name,' . $label->id,
            'notes' => 'nullable|string',
        ]);

        $label->update($request->only('name', 'notes'));
        return redirect()->route('transactions.labels.index')->with('success', 'Label updated successfully.');
    }

    public function labels_delete(TransactionLabel $label)
    {
        $label->delete();
        return redirect()->back()->with('deleted', $label->name);
    }

    public function labels_trash_list()
    {
        $labels = TransactionLabel::onlyTrashed()->paginate(10);
        $n = TransactionLabel::onlyTrashed()->count();
        return view('dashboard.transactions.labels.trash', compact('labels' , 'n'));
    }

    public function labels_trash_restore($id)
    {
        $label = TransactionLabel::onlyTrashed()->findOrFail($id);
        $label->restore();
        return redirect()->back()->with('restored', $label->name);
    }

    public function labels_trash_delete($id)
    {
        $label = TransactionLabel::onlyTrashed()->findOrFail($id);
        $label->forceDelete();
        return redirect()->back()->with('deleted', $label->name);
    }

    public function print($id)
    {
        $transaction = Transaction::findOrFail($id);

        return view('dashboard.transactions.print_detail', compact('transaction'));
    }
}
