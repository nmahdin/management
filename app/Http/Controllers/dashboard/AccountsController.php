<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'payment_label' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);

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
            'payment_label' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);

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
    // end accounts
}
