<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    // start partners
    public function partners_list()
    {
        return view('dashboard.financial.partners.list' , ['partners' => Partner::where('deleted' , 0)->get() , 'n' => Partner::where('deleted' , 0)->count()]);
    }
    public function partners_create()
    {
        return view('dashboard.financial.partners.create');
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
        return view('dashboard.financial.partners.edit' , ['partner' => $partner]);
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
        return view('dashboard.financial.partners.trash' , ['partners' => Partner::where('deleted' , 1)->get() , 'n' => Partner::where('deleted' , 1)->count()]);
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
}
