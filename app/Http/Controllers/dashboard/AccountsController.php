<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class AccountsController extends Controller
{
    // start accounts
    public function accounts_list()
    {
        $accounts = Accounts::all();
        $n = Accounts::count();
        return view('dashboard.accounts.list' , ['accounts' => $accounts , 'n' => $n]);
    }
    public function accounts_create()
    {
        return view('dashboard.accounts.create');
    }
    public function accounts_create_post(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'max:255'],
            'number' => ['required', 'max:255' , Rule::unique('accounts')],
            'payment_ways' => ['required', 'array' , 'in:cash,cart,online,pos'],
            'note' => ['nullable'],
        ]);

        $data['payment_ways'] = json_encode($data['payment_ways']);
        Accounts::create($data);

        return back()->with('created', $data['label']);
    }
    public function accounts_edit($id)
    {
        $account = Accounts::findOrFail($id);
        return view('dashboard.accounts.edit' , compact('account'));
    }
    public function accounts_edit_post(Request $request, $id)
    {
        $account = Accounts::findOrFail($id);
        $data = $request->validate([
            'label' => ['required', 'max:255'],
            'number' => ['required', 'max:255' , Rule::unique('accounts')->ignore($account->id)],
            'payment_ways' => ['required', 'array' , 'in:cash,cart,online,pos'],
            'note' => ['nullable'],
        ]);

        $data['payment_ways'] = json_encode($data['payment_ways']);
        $account->update($data);

        return redirect(route('accounts.list'))->with('edited', $data['label']);
    }
    public function accounts_delete($id)
    {
        $account = Accounts::findOrFail($id);
        $account->delete();
        return redirect(route('accounts.list'))->with('deleted' , $account->label);
    }
    public function accounts_trash_list()
    {
        $n = Accounts::onlyTrashed()->count();
        $accounts = Accounts::onlyTrashed()->get();
        return view('dashboard.accounts.trash' , ['accounts' => $accounts , 'n' => $n]);
    }
    public function accounts_trash_delete($id)
    {
        $account = Accounts::onlyTrashed()->findOrFail($id);
        $account->forceDelete();
        return redirect(route('accounts.trash'))->with('deleted' , $account->label);
    }
    public function accounts_trash_restore($id)
    {
        $account = Accounts::onlyTrashed()->findOrFail($id);
        $account->restore();
        return redirect(route('accounts.trash'))->with('restored' , $account->label);
    }

    public function reports(Request $request)
    {
        $accounts = Account::all();

        return view('dashboard.accounts.index', compact('accounts'));
    }

    // نمایش گزارش یک حساب خاص با فیلتر زمانی و جدول تراکنش‌ها
    public function showReport(Request $request, Accounts $account)
    {
        // Convert jalali date to gregorian
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $gregorianStartDate = null;
        $gregorianEndDate = null;

        if ($startDate) {
            $gregorianStartDate = Jalalian::fromFormat('Y/m/d', $startDate)->toCarbon()->format('Y-m-d');
        }

        if ($endDate) {
            $gregorianEndDate = Jalalian::fromFormat('Y/m/d', $endDate)->toCarbon()->format('Y-m-d');
        }

        // Fetch transactions
        $transactions = Transaction::where('account_id', $account->id)
            ->when($gregorianStartDate, function ($query) use ($gregorianStartDate) {
                $query->where('date', '>=', $gregorianStartDate);
            })
            ->when($gregorianEndDate, function ($query) use ($gregorianEndDate) {
                $query->where('date', '<=', $gregorianEndDate);
            })
            ->orderByDesc('date')
            ->get();

        // Calculate inputs, outputs, and balance
        $inputs = $transactions->where('type', 'input')->sum('amount');
        $outputs = $transactions->where('type', 'output')->sum('amount');
        $balance = $inputs - $outputs;

        // Chart data
        $chartData = Transaction::where('account_id', $account->id)
            ->when($gregorianStartDate, function ($query) use ($gregorianStartDate) {
                $query->where('date', '>=', $gregorianStartDate);
            })
            ->when($gregorianEndDate, function ($query) use ($gregorianEndDate) {
                $query->where('date', '<=', $gregorianEndDate);
            })
            ->select(DB::raw('DATE(date) as date'),
                DB::raw('SUM(CASE WHEN type = "input" THEN amount ELSE 0 END) as input'),
                DB::raw('SUM(CASE WHEN type = "output" THEN amount ELSE 0 END) as output'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->map(function ($item) {
                return [
                    'input' => $item->input,
                    'output' => $item->output,
                ];
            });

        return view('dashboard.accounts.report', compact('account', 'transactions', 'inputs', 'outputs', 'balance', 'startDate', 'endDate', 'chartData'));
    }






    // end accounts
}
