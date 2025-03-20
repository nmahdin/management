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
        return view('dashboard.partners.list' , ['partners' => Partner::all() , 'n' => Partner::count()]);
    }
    public function partners_create()
    {
        return view('dashboard.partners.create');
    }
    public function partners_create_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);
        Partner::create($data);
        return back()->with('created', $data['name']);
    }
    public function partners_edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('dashboard.partners.edit' , ['partner' => $partner]);
    }
    public function partners_edit_post($id , Request $request)
    {
        $partner = Partner::findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'note' => ['nullable'],
        ]);
        $partner->update($data);
        return redirect(route('partners.list'))->with('edited', $data['name']);
    }
    public function partners_delete($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();
        return back()->with('deleted' , $partner->name);
    }
    public function partners_trash_list()
    {
        return view('dashboard.partners.trash' , ['partners' => Partner::onlyTrashed()->get() , 'n' => Partner::onlyTrashed()->count()]);
    }
    public function partners_trash_delete($id)
    {
        $partner = Partner::onlyTrashed()->findOrFail($id);
        $partner->forceDelete();
        return back()->with('deleted' , $partner->name);
    }
    public function partners_trash_restore($id)
    {
        $partner = Partner::onlyTrashed()->findOrFail($id);
        $partner->restore();
        return back()->with('restored' , $partner->name);
    }
    // end partners
}
