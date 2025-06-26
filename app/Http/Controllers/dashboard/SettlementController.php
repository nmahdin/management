<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Settlement;
use App\Models\Partner;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettlementController extends Controller
{
    public function index()
    {
        $settlements = Settlement::with('partner', 'user', 'order')->latest()->paginate(20);
        return view('dashboard.settlements.index', compact('settlements'));
    }

    public function create(Request $request)
    {
        $partners = Partner::orderBy('name')->get();
        $orders = Order::orderByDesc('id')->take(20)->get();
        // پارامترهای پیش‌فرض برای تسویه (مثلاً از صفحه شریک یا بدهی خاص)
        $selectedPartner = $request->get('partner_id');
        $selectedAmount = $request->get('amount');
        $selectedOrder = $request->get('order_id');
        return view('dashboard.settlements.create', compact('partners', 'orders', 'selectedPartner', 'selectedAmount', 'selectedOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:debt,settlement',
            'method' => 'nullable|string|max:50',
            'reference' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        Settlement::create([
            'partner_id' => $request->partner_id,
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'method' => $request->method,
            'reference' => $request->reference,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'settled_at' => $request->type === 'settlement' ? now() : null,
        ]);

        return redirect()->route('settlements.index')->with('success', 'ثبت موفق بود.');
    }
    public function show($id)
    {
        $settlement = \App\Models\Settlement::with('partner', 'order')->findOrFail($id);
        return view('dashboard.settlements.show', compact('settlement'));
    }

}
