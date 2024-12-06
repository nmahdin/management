<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Financial extends Controller
{
    // start Transactions
    public function transactions_general()
    {

    }
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
    // end Transactions

   // start orders
    public function orders_list()
    {

    }
    public function orders_create()
{

}
    public function orders_create_post()
    {

    }
    public function orders_edit()
    {

    }
    public function orders_edit_post()
    {

    }
    public function orders_delete()
{

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

}
    public function orders_type_create()
    {
        return view('admin.financial.factors.types.create');
    }
    public function orders_type_create_post(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'max:255'],
            'notes' => [],
        ]);

        Type::create($data);

        return redirect(route('orders.type.create'))->with('created', $data['label']);
    }
    public function orders_type_edit()
    {

    }
    public function orders_type_edit_post()
{

}
    public function orders_type_delete()
    {

    }
    public function orders_types_trash_list()
    {

    }
    public function orders_type_trash_delete()
    {

    }
    public function orders_type_trash_restore()
    {

    }
    // statuses
    public function orders_statuses_list()
    {

    }
    public function orders_statuses_create()
    {
        return view('admin.financial.factors.statuses.create');
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
    public function orders_statuses_edit()
    {

    }
    public function orders_statuses_edit_post()
    {

    }
    public function orders_statuses_delete()
    {

    }
    public function orders_statuses_trash_list()
    {

    }
    public function orders_statuses_trash_delete()
    {

    }
    public function orders_statuses_trash_restore()
    {

    }
    // end orders

    // start partners
    public function partners_list()
    {
        return view('admin.financial.partners.list' , ['partners' => Partner::where('deleted' , 0)->get() , 'n' => Partner::where('deleted' , 0)->count()]);
    }
    public function partners_create()
    {
        return view('admin.financial.partners.create');
    }
    public function partners_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);
        Partner::create($data);
        return redirect(route('partners.create'))->with('created', $data['name']);
    }
    public function partners_edit(Partner $partner)
    {
        return view('admin.financial.partners.edit' , ['partner' => $partner]);
    }
    public function partners_edit_post(Partner $partner , Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);
        $partner->update($data);
        return redirect(route('partners.list'))->with('edited', $data['name']);
    }
    public function partners_delete(Partner  $partner)
    {
        $partner->update(['deleted' => 1]);
        return redirect(route('partners.list'))->with('deleted' , $partner->name);
    }
    public function partners_trash_list()
    {
        return view('admin.financial.partners.trash' , ['partners' => Partner::where('deleted' , 1)->get() , 'n' => Partner::where('deleted' , 1)->count()]);
    }
    public function partners_trash_delete(Partner  $partner)
    {
        $name =  $partner->name;
        $partner->delete();
        return redirect(route('partners.trash'))->with('deleted' , $name);
    }
    public function partners_trash_restore(Partner  $partner)
    {
        $partner->update(['deleted' => 0]);
        return redirect(route('partners.trash'))->with('restored' , $partner->name);
    }
    // end partners

    // start accounts
    public function accounts_list()
    {
        $accounts = Accounts::where('deleted' , 0)->get();
        $n = Accounts::where('deleted' , 0)->count();
        return view('admin.financial.accounts.list' , ['accounts' => $accounts , 'n' => $n]);
    }
    public function accounts_create()
    {
        return view('admin.financial.accounts.create');
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

        return redirect(route('account.create'))->with('created', $data['label']);
    }
    public function accounts_edit(Accounts $account)
    {
        return view('admin.financial.accounts.edit' , compact('account'));
    }
    public function accounts_edit_post(Request $request, Accounts $account)
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
    public function accounts_delete(Accounts $account)
    {
        $account->update(['deleted' => 1]);
        return redirect(route('accounts.list'))->with('deleted' , $account->label);
    }
    public function accounts_trash_list()
    {
        $n = Accounts::where('deleted' , 1)->count();
        $accounts = Accounts::where('deleted' , 1)->get();
        return view('admin.financial.accounts.trash' , ['accounts' => $accounts , 'n' => $n]);
    }
    public function accounts_trash_delete(Accounts $account)
    {
        $label = $account->label;
        $account->delete();
        return redirect(route('accounts.trash'))->with('deleted' , $label);
    }
    public function accounts_trash_restore(Accounts $account)
    {
        $account->update(['deleted' => 0]);
        return redirect(route('accounts.trash'))->with('restored' , $account->label);
    }
    // end accounts
}
