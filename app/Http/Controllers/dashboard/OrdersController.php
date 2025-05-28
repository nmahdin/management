<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use App\Models\Transaction;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{

    // start orders
    public function orders_list()
    {
        $orders = Order::with(['customer', 'type', 'user'])
            ->orderBy('created_at' , 'asc')
            ->get();

        return view('dashboard.factors.orders.list', [
            'orders' => $orders,
            'n' => $orders->count()
        ]);
    }

    public function orders_detail($id)
    {
        $order = Order::with(['customer', 'type', 'user', 'products'])
            ->findOrFail($id);

        return view('dashboard.factors.orders.detail', compact('order'));
    }

    public function updateStatus(Order $order, $status)
    {
        $order->status = $status;
        $order->save();

        return redirect()->back()->with('success', 'وضعیت سفارش با موفقیت تغییر کرد.');
    }

    public function orders_create()
    {
        return view('dashboard.orders.create');
    }
    public function orders_store(Request $request)
    {

    }
    public function orders_edit()
    {

    }
    public function orders_edit_post()
    {

    }
    public function orders_delete($id)
    {
        $order = Order::findOrFail($id);
        $masage = "سفارش شماره #$order->id با موفقیت حذف شد.";

        DB::beginTransaction();

        try {
            // بروزرسانی موجودی محصولات
            foreach ($order->products as $item) {
                $product = Product::find($item->id);
                $product->inventory += $item->pivot->quantity; // برگرداندن موجودی
                $product->save();
            }

            foreach ($order->transactions as $item) {
                $transaction = Transaction::find($item->id);
                $transaction->delete(); // حذف تراکنش ها
            }

            $order->delete();
            DB::commit();

            return redirect()->route('orders.list')
                ->with('warning', $masage);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['danger' => 'خطا در حذف سفارش: ' . $e->getMessage()]);
        }
    }

    public function printInvoice(Order $order)
    {
        // اینجا می‌توانید مطمئن شوید که کاربر دسترسی لازم برای پرینت این فاکتور را دارد
        // مثلاً با استفاده از policies یا gate
        // $this->authorize('view', $order);

        // ویو مخصوص پرینت را برگردانید
        return view('dashboard.factors.orders.order_detail_print', compact('order'));
    }




    public function orders_trash_list()
    {

    }
    public function orders_trash_delete()
    {

    }
    public function orders_trash_restore()
    {

    }
    // categories
    public function orders_types_list()
    {
        return view('dashboard.factors.types.list' , ['types' => Type::all() , 'n' => Type::count()]);
    }
    public function orders_type_create()
    {
        return view('dashboard.factors.types.create');
    }
    public function orders_type_create_post(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'max:255' , 'unique:types'],
            'note' => ['nullable'],
        ]);

        Type::create($data);

        return back()->with('created', $data['label']);
    }
    public function orders_type_edit($id)
    {
        $type = Type::findOrFail($id);
        return view('dashboard.factors.types.edit' , compact('type'));
    }
    public function orders_type_edit_post(Request $request, $id)
    {
        $type = Type::findOrFail($id);

        $data = $request->validate([
            'label' => ['required', 'max:255', 'unique:types,label,'.$id],
            'note' => ['nullable'],
        ]);

        $type->update($data);

        return redirect()->route('orders.types.list')->with('edited', $data['label']);
    }
    public function orders_type_delete($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return back()->with('deleted', $type->label);
    }
    public function orders_types_trash_list()
    {
        return view('dashboard.factors.types.trash', [
            'types' => Type::onlyTrashed()->get(),
            'n' => Type::onlyTrashed()->count()
        ]);
    }
    public function orders_type_trash_delete($id)
    {
        $type = Type::onlyTrashed()->findOrFail($id);
        $type->forceDelete();

        return back()->with('deleted', $type->label);
    }
    public function orders_type_trash_restore($id)
    {
        $type = Type::onlyTrashed()->findOrFail($id);
        $type->restore();

        return back()->with('restored', $type->label);
    }

    // statuses
    public function orders_statuses_list()
    {
        return view('dashboard.factors.statuses.list', [
            'statuses' => Status::all(),
            'n' => Status::count()
        ]);
    }

    public function orders_statuses_create()
    {
        return view('dashboard.factors.statuses.create');
    }

    public function orders_statuses_create_post(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'max:255'],
            'notes' => [],
        ]);

        Status::create($data);

        return redirect(route('orders.statuses.create'))->with('created', $data['label']);
    }

    public function orders_statuses_edit($id)
    {
        $status = Status::findOrFail($id);
        return view('dashboard.factors.statuses.edit', compact('status'));
    }

    public function orders_statuses_edit_post(Request $request, $id)
    {
        $status = Status::findOrFail($id);

        $data = $request->validate([
            'label' => ['required', 'max:255'],
            'notes' => ['nullable'],
        ]);

        $status->update($data);

        return back()->with('success', 'وضعیت سفارش با موفقیت ویرایش شد.');
    }

    public function orders_statuses_delete($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();

        return redirect()->route('orders.statuses.list')->with('deleted', 'وضعیت سفارش با موفقیت حذف شد.');
    }

    public function orders_statuses_trash_list()
    {
        return view('dashboard.factors.statuses.trash', [
            'statuses' => Status::onlyTrashed()->get(),
            'n' => Status::onlyTrashed()->count()
        ]);
    }

    public function orders_statuses_trash_delete($id)
    {
        $status = Status::onlyTrashed()->findOrFail($id);
        $status->forceDelete();

        return back()->with('deleted', 'وضعیت سفارش به طور کامل حذف شد.');
    }

    public function orders_statuses_trash_restore($id)
    {
        $status = Status::onlyTrashed()->findOrFail($id);
        $status->restore();

        return back()->with('restored', 'وضعیت سفارش با موفقیت بازیابی شد.');
    }
    // end orders
}
