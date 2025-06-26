<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // تعداد کل شریک‌ها
        $partnersCount = Partner::count();

        // تعداد کل محصولات
        $productsCount = Product::count();

        // مجموع موجودی محصولات
        $totalInventory = Product::sum('inventory');

        // مجموع بستانکاری همه شریک‌ها (فرض: partner_transactions جدول مربوطه است)
        $totalCredit = 0;
        if (class_exists('\App\Models\PartnerTransaction')) {
            $totalCredit = \App\Models\PartnerTransaction::where('type', 'credit')->sum('amount')
                - \App\Models\PartnerTransaction::where('type', 'debit')->sum('amount');
        }

        // مجموع سود کل فروشگاه
        $totalProfit = Product::sum('profit');

        // جمع تسویه‌ها (فرض: partner_transactions)
        $totalSettled = 0;
        if (class_exists('\App\Models\PartnerTransaction')) {
            $totalSettled = \App\Models\PartnerTransaction::where('type', 'debit')->sum('amount');
        }

        // آخرین تراکنش‌ها (5 مورد اخیر)
        $recentTransactions = [];
        if (class_exists('\App\Models\PartnerTransaction')) {
            $recentTransactions = \App\Models\PartnerTransaction::with('partner')->latest('date')->take(5)->get();
        }

        // محصولات کم موجودی (کمتر از 5)
        $lowInventoryProducts = Product::where('inventory', '<', 5)->get();

        // داده‌های نمودار سود ماهانه (مثال ساده)
        $profitByMonth = Product::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(profit) as profit")
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartProfitData = [
            'labels' => $profitByMonth->pluck('month')->map(function($m){
                // تبدیل ماه میلادی به شمسی در صورت نیاز
                try {
                    return \Morilog\Jalali\Jalalian::fromFormat('Y-m', $m)->format('Y/m');
                } catch (\Exception $e) {
                    return $m;
                }
            }),
            'datasets' => [[
                'label' => 'سود ماهانه',
                'backgroundColor' => 'rgba(40,167,69,0.7)',
                'data' => $profitByMonth->pluck('profit'),
            ]]
        ];

        // داده‌های نمودار سهم شریک‌ها از سود
        $partnerProfits = [];
        if (class_exists('\App\Models\PartnerTransaction')) {
            $partnerProfits = \App\Models\PartnerTransaction::select(
                'partner_id',
                DB::raw('SUM(CASE WHEN type = "credit" THEN amount ELSE 0 END) as credit')
            )
                ->groupBy('partner_id')
                ->with('partner')
                ->get()
                ->filter(fn($p) => $p->credit > 0);
        }

        $chartPartnersData = [
            'labels' => $partnerProfits ? $partnerProfits->pluck('partner.name') : [],
            'datasets' => [[
                'label' => 'سهم شریک‌ها',
                'backgroundColor' => ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#28a745', '#dc3545'],
                'data' => $partnerProfits ? $partnerProfits->pluck('credit') : [],
            ]]
        ];

        return view('dashboard.index', compact(
            'partnersCount',
            'productsCount',
            'totalInventory',
            'totalCredit',
            'totalProfit',
            'totalSettled',
            'recentTransactions',
            'lowInventoryProducts',
            'chartProfitData',
            'chartPartnersData'
        ));
    }
}
