<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

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
        return view('dashboard.financial.factors.types.create');
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
        return view('dashboard.financial.factors.statuses.create');
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
}
