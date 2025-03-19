<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountsController extends Controller
{
    // start accounts
    public function accounts_list()
    {
        $accounts = \App\Models\Accounts::where('deleted' , 0)->get();
        $n = AccountsController::where('deleted' , 0)->count();
        return view('dashboard.financial.accounts.list' , ['accounts' => $accounts , 'n' => $n]);
    }
    public function accounts_create()
    {
        return view('dashboard.financial.accounts.create');
    }
    public function accounts_create_post(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'max:255'],
            'number' => ['required', 'max:255' , Rule::unique('accounts')],
            'payment_label' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);

        AccountsController::create($data);

        return redirect(route('account.create'))->with('created', $data['label']);
    }
    public function accounts_edit(AccountsController $account)
    {
        return view('dashboard.financial.accounts.edit' , compact('account'));
    }
    public function accounts_edit_post(Request $request, AccountsController $account)
    {
        $data = $request->validate([
            'label' => ['required', 'max:255'],
            'number' => ['required', 'max:255' , Rule::unique('accounts')->ignore($account->id)],
            'payment_label' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);

        $account->update($data);

        return redirect(route('accounts.list'))->with('edited', $data['label']);
    }
    public function accounts_delete(AccountsController $account)
    {
        $account->update(['deleted' => 1]);
        return redirect(route('accounts.list'))->with('deleted' , $account->label);
    }
    public function accounts_trash_list()
    {
        $n = AccountsController::where('deleted' , 1)->count();
        $accounts = AccountsController::where('deleted' , 1)->get();
        return view('dashboard.financial.accounts.trash' , ['accounts' => $accounts , 'n' => $n]);
    }
    public function accounts_trash_delete(AccountsController $account)
    {
        $label = $account->label;
        $account->delete();
        return redirect(route('accounts.trash'))->with('deleted' , $label);
    }
    public function accounts_trash_restore(AccountsController $account)
    {
        $account->update(['deleted' => 0]);
        return redirect(route('accounts.trash'))->with('restored' , $account->label);
    }
    // end accounts
}
