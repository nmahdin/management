<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
}
