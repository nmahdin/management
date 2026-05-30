<?php

namespace App\Http\Controllers\dashboard;

use App\helper\Cart\Cart;
use App\helper\services\Custom;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Order;
use App\Models\PartnerTransaction;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Settlement;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Main extends Controller
{
    public function index()
    {
        return view('dashboard.dashboards.main');
    }

    public function add_to_cart(Product $product)
    {
        if (!Cart::has($product)) {
            Cart::put(
                [
                    'price' => $product->total_price,
                ],
                $product,
            );
        } else {
            if (Cart::count($product) < $product->inventory) {
                Cart::update($product, 1);
            }
        }

        return redirect(route('cart.list'));
    }

    public function cart_list()
    {
        $n = Cart::all()->count();
        return view('dashboard.cart.list', ['n' => $n]);
    }

    public function cart_delete($id): \Illuminate\Http\RedirectResponse
    {
        $name = Cart::get($id)['Product']->name;
        Cart::delete($id);
        return back()->with('deleted', $name);
    }

    public function enter_order(Request $request)
    {
        if ($request->customer_id != 0) {
            $customer = Customer::findOrFail($request->customer_id);
        } else {
            $data = $request->validate([
                'name' => ['required', 'max:250'],
                'number' => ['min:8', 'max:12', Rule::unique('customers')],
                'city' => ['required', 'min:1', 'max:255'],
                'address' => ['max:250'],
                'com_ways' => ['required', 'array'],
                'birthday' => ['nullable'],
                'gender' => ['required', 'in:female,male'],
                'category_id' => ['nullable'],
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
            ]);
        }

        $cart = Cart::all();

        $totalAmount = 0;
        foreach ($request->all() as $key => $value) {
            if (is_numeric($key)) {
                $totalAmount += $value;
            }
        }

        $date = Custom::changDate($request->date);

        $cartItems = $cart;
        return view('dashboard.cart.enter', compact('customer', 'cartItems', 'date', 'totalAmount'));
    }

    public function payments_list()
    {
        $payments = Transaction::where('source_type', 'orders')->get();
        return view('dashboard.cart.payments.list', ['payments' => $payments, 'n' => $payments->count()]);
    }

    public function payments_create()
    {
        $accounts = Accounts::all();
        return view('dashboard.cart.payments.create', compact('accounts'));
    }

    public function payments_store(Request $request)
    {
        $data = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'amount' => ['required', 'numeric'],
            'date' => ['required'],
            'account_id' => ['required', 'exists:accounts,id'],
            'label_id' => ['required'],
            'tracking_number' => ['nullable'],
            'note' => ['nullable'],
            'status' => ['required', 'in:paid,unpaid'],
            'payment_way' => ['required'],
        ]);

        $accountId = $data['account_id'];
        $paymentWay = $data['payment_way'];

        $account = Accounts::find($accountId);
        $account->update([
            'inputs' => $account->inputs + $data['amount'],
            'count' => $account->count + 1,
        ]);

        Transaction::create([
            'name' => 'پرداخت مبلغ سفارش',
            'type' => 'input',
            'date' => $data['date'],
            'amount' => $data['amount'],
            'user_id' => Auth::user()->id,
            'tracking_number' => $data['tracking_number'],
            'payer_type' => Customer::class,
            'payer_id' => $data['customer_id'],
            'account_id' => $accountId,
            'payment_way' => $paymentWay,
            'label_id' => $data['label_id'],
            'category' => 'orders',
            'status' => $data['status'],
            'source_type' => 'orders',
            'source_id' => $data['order_id'],
            'notes' => $data['note'],
        ]);

        $order = Order::find($data['order_id']);

        $sumTransactions = $order->transactions()->where('status', 'paid')->sum('amount');
        if ($order->amount <= $sumTransactions) {
            Order::find($data['order_id'])->update(['status' => 'paid']);
        } else {
            Order::find($data['order_id'])->update(['status' => 'unpaid']);
        }

        return redirect(route('orders.detail', $data['order_id']))->with('success', 'پرداخت با موفقیت ثبت شد');
    }

    public function payments_paid($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'paid']);

        $price = number_format($transaction->amount, 0, '') . ' تومان';

        if ($transaction->where('source_type', 'orders')) {
            if ($order = Order::find($transaction->source_id)) {
                $sumTransactions = $order->transactions()->where('status', 'paid')->sum('amount');
                if ($order->amount <= $sumTransactions) {
                    Order::find($transaction->source_id)->update(['status' => 'paid']);
                } else {
                    Order::find($transaction->source_id)->update(['status' => 'unpaid']);
                }
            }
        }

        return back()->with('success', "تراکنش مربوطه به عنوان پرداخت شده علامت گذاری شد. مبلغ: $price");
    }

    public function payments_delete($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();

        if ($transaction->where('source_type', 'orders')) {
            if ($order = Order::find($transaction->source_id)) {
                $sumTransactions = $order->transactions()->sum('amount');
                if ($order->amount > $sumTransactions) {
                    Order::find($transaction->source_id)->update(['status' => 'unpaid']);
                }
            }
        }

        return back()->with('deleted', 'پرداخت با موفقیت حذف شد');
    }

    public function payments_edit($id)
    {
        $payment = Transaction::findOrFail($id);
        $accounts = Accounts::all();
        return view('dashboard.cart.payments.edit', compact('payment', 'accounts'));
    }

    public function payments_edit_post(Request $request, $id)
    {
        $payment = Transaction::findOrFail($id);

        $data = $request->validate([
            'amount' => ['required', 'numeric'],
            'date' => ['required'],
            'account_id' => ['required', 'exists:accounts,id'],
            'tracking_number' => ['nullable'],
            'note' => ['nullable'],
            'status' => ['required', 'in:paid,unpaid'],
            'payment_way' => ['required'],
        ]);

        $payment->update($data);

        return redirect(route('payments.list'))->with('edited', 'پرداخت با موفقیت ویرایش شد');
    }

    public function payments_restore($id)
    {
        $payment = Transaction::onlyTrashed()->findOrFail($id);
        $payment->restore();
        return back()->with('restored', 'پرداخت با موفقیت بازیابی شد');
    }

    public function payments_forceDelete($id)
    {
        $payment = Transaction::onlyTrashed()->findOrFail($id);
        $payment->forceDelete();
        return back()->with('deleted', 'پرداخت به طور کامل حذف شد');
    }

    public function users_all()
    {
        $users = User::all();
        return view('dashboard.users.all', ['users' => $users, 'n' => $users->count()]);
    }

    public function users_permissions()
    {
        $permissions = Permission::all();
        return view('dashboard.users.permissions', ['permissions' => $permissions, 'n' => $permissions->count()]);
    }

    public function users_roles()
    {
        $groups = Group::all();
        return view('dashboard.users.roles', ['groups' => $groups, 'n' => $groups->count()]);
    }

    public function users_roles_creat()
    {
        $permissions = Permission::all();
        return view('dashboard.users.create-role', compact('permissions'));
    }

    public function users_roles_creat_post(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
        ]);

        $group = Group::create(['label' => $data['label']]);

        if ($data['permissions']) {
            $group->permissions()->attach($data['permissions']);
        }

        return back()->with('created', 'نقش با موفقیت ایجاد شد');
    }
}
