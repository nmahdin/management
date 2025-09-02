<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;
use Illuminate\Pagination\LengthAwarePaginator;

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

        // ساده: اگر هر تراکنشی برای این حساب وجود داشته باشد، حذف را رد کن
        if ($account->transactions()->exists()) {
            return redirect()->route('accounts.list')
                ->with('error', 'این حساب دارای تراکنش است و امکان حذف آن وجود ندارد.');
        }

        // اگر می‌خواهید حتی تراکنش‌های soft-deleted را هم در نظر بگیرید از withTrashed استفاده کنید:
        // if ($account->transactions()->withTrashed()->exists()) { ... }

        $account->delete();

        return redirect()->route('accounts.list')
            ->with('success', "حساب \"{$account->label}\" با موفقیت حذف شد.");
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
//    public function showReport(Request $request, Accounts $account)
//    {
//        // Convert jalali date to gregorian
//        $startDate = $request->input('start_date');
//        $endDate = $request->input('end_date');
//
//        $gregorianStartDate = null;
//        $gregorianEndDate = null;
//
//        if ($startDate) {
//            $gregorianStartDate = Jalalian::fromFormat('Y/m/d', $startDate)->toCarbon()->format('Y-m-d');
//        }
//
//        if ($endDate) {
//            $gregorianEndDate = Jalalian::fromFormat('Y/m/d', $endDate)->toCarbon()->format('Y-m-d');
//        }
//
//        // Fetch transactions
//        $transactions = Transaction::where('account_id', $account->id)
//            ->when($gregorianStartDate, function ($query) use ($gregorianStartDate) {
//                $query->where('date', '>=', $gregorianStartDate);
//            })
//            ->when($gregorianEndDate, function ($query) use ($gregorianEndDate) {
//                $query->where('date', '<=', $gregorianEndDate);
//            })
//            ->orderByDesc('date')
//            ->get();
//
//        // Calculate inputs, outputs, and balance
//        $inputs = $transactions->where('type', 'input')->sum('amount');
//        $outputs = $transactions->where('type', 'output')->sum('amount');
//        $balance = $inputs - $outputs;
//
//        // Chart data
//        $chartData = Transaction::where('account_id', $account->id)
//            ->when($gregorianStartDate, function ($query) use ($gregorianStartDate) {
//                $query->where('date', '>=', $gregorianStartDate);
//            })
//            ->when($gregorianEndDate, function ($query) use ($gregorianEndDate) {
//                $query->where('date', '<=', $gregorianEndDate);
//            })
//            ->select(DB::raw('DATE(date) as date'),
//                DB::raw('SUM(CASE WHEN type = "input" THEN amount ELSE 0 END) as input'),
//                DB::raw('SUM(CASE WHEN type = "output" THEN amount ELSE 0 END) as output'))
//            ->groupBy('date')
//            ->orderBy('date')
//            ->get()
//            ->keyBy('date')
//            ->map(function ($item) {
//                return [
//                    'input' => $item->input,
//                    'output' => $item->output,
//                ];
//            });
//
//        return view('dashboard.accounts.report', compact('account', 'transactions', 'inputs', 'outputs', 'balance', 'startDate', 'endDate', 'chartData'));
//    }


    /**
     * Show report for a specific account with filters, summary, running balance and chart data.
     *
     * Expected query params:
     * - start_date, end_date (Jalali 'Y/m/d' from UI) or empty for all
     * - type (input/output/any)
     * - status (paid/unpaid/any)
     * - payment_way (e.g. cash,cart,online,pos or any)
     * - amount_min, amount_max
     * - q (search text for notes or tracking_number)
     * - per_page (pagination)
     */
    public function showReport(Request $request, Accounts $account)
    {
        // read and validate inputs (light validation here)
        $perPage = max(1, (int) $request->get('per_page', 15));
        $type = $request->get('type');
        $status = $request->get('status');
        $paymentWay = $request->get('payment_way');
        $amountMin = $request->get('amount_min');
        $amountMax = $request->get('amount_max');
        $q = $request->get('q');

        $startDateInput = $request->input('start_date'); // expected Jalali 'Y/m/d' or null
        $endDateInput = $request->input('end_date');

        // convert Jalali to Gregorian (Y-m-d) if provided
        $gregorianStartDate = null;
        $gregorianEndDate = null;
        try {
            if ($startDateInput) {
                $gregorianStartDate = Jalalian::fromFormat('Y/m/d', $startDateInput)->toCarbon()->format('Y-m-d');
            }
            if ($endDateInput) {
                $gregorianEndDate = Jalalian::fromFormat('Y/m/d', $endDateInput)->toCarbon()->format('Y-m-d');
            }
        } catch (\Throwable $e) {
            // اگر تبدیل خطا داد، فیلتر تاریخ نادیده گرفته می‌شود و یا می‌توانی خطا به کاربر نشان دهی
            $gregorianStartDate = null;
            $gregorianEndDate = null;
        }

        // پایهٔ کوئری برای تراکنش‌های مربوط به این حساب
        $baseQuery = Transaction::where('account_id', $account->id);

        // apply date range filters for the main query
        $baseQuery = $baseQuery
            ->when($gregorianStartDate, fn($q) => $q->where('date', '>=', $gregorianStartDate))
            ->when($gregorianEndDate, fn($q) => $q->where('date', '<=', $gregorianEndDate));

        // other filters
        $baseQuery = $baseQuery
            ->when($type && $type !== 'any', fn($q) => $q->where('type', $type))
            ->when($status && $status !== 'any', fn($q) => $q->where('status', $status))
            ->when($paymentWay && $paymentWay !== 'any', fn($q) => $q->where('payment_way', $paymentWay))
            ->when(is_numeric($amountMin), fn($q) => $q->where('amount', '>=', $amountMin))
            ->when(is_numeric($amountMax), fn($q) => $q->where('amount', '<=', $amountMax))
            ->when($q, fn($qbuilder) => $qbuilder->where(function ($qq) use ($q) {
                $qq->where('notes', 'like', "%{$q}%")
                    ->orWhere('tracking_number', 'like', "%{$q}%");
            }));

        // summary aggregates for the filtered range (DB-level sums)
        $inputsSum = (clone $baseQuery)->where('type', 'input')->sum('amount');
        $outputsSum = (clone $baseQuery)->where('type', 'output')->sum('amount');

        // compute opening balance: sums of all transactions before the start date (regardless of other filters like payment_way/type)
        $openingInputs = 0;
        $openingOutputs = 0;
        if ($gregorianStartDate) {
            $openingInputs = Transaction::where('account_id', $account->id)
                ->where('date', '<', $gregorianStartDate)
                ->where('type', 'input')
                ->sum('amount');

            $openingOutputs = Transaction::where('account_id', $account->id)
                ->where('date', '<', $gregorianStartDate)
                ->where('type', 'output')
                ->sum('amount');
        } else {
            // if no start date, opening balance = 0 (or you can compute all historic prior to earliest in result)
            $openingInputs = 0;
            $openingOutputs = 0;
        }
        $openingBalance = $openingInputs - $openingOutputs;

        // get full set of filtered transactions ordered ascending to compute running balance
        $allTransactions = (clone $baseQuery)
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // compute running balance per transaction (starting from openingBalance)
        $running = $openingBalance;
        $transactionsWithBalance = $allTransactions->map(function ($tx) use (&$running) {
            if ($tx->type === 'input') {
                $running += $tx->amount;
            } else {
                $running -= $tx->amount;
            }
            // attach running balance to each item (so view AND export can use it)
            $tx->running_balance = $running;
            return $tx;
        });

        // For UI: create a paginator from the collection (so we can paginate while computing running balances correctly)
        $currentPage = max(1, (int) $request->get('page', 1));
        $itemsForCurrentPage = $transactionsWithBalance->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator(
            $itemsForCurrentPage,
            $transactionsWithBalance->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // prepare chart data: group by date and aggregate input/output
        $chartRows = Transaction::where('account_id', $account->id)
            ->when($gregorianStartDate, fn($q) => $q->where('date', '>=', $gregorianStartDate))
            ->when($gregorianEndDate, fn($q) => $q->where('date', '<=', $gregorianEndDate))
            ->select(DB::raw('DATE(date) as date'),
                DB::raw('SUM(CASE WHEN type = "input" THEN amount ELSE 0 END) as input'),
                DB::raw('SUM(CASE WHEN type = "output" THEN amount ELSE 0 END) as output'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($r) => [
                'date' => $r->date,
                'input' => (int) $r->input,
                'output' => (int) $r->output,
            ]);

        // final balance at end of period:
        $finalBalance = $openingBalance + $inputsSum - $outputsSum;

        return view('dashboard.accounts.report', [
            'account' => $account,
            'transactions' => $paginator,
            'n' => $transactionsWithBalance->count(),
            'inputs' => $inputsSum,
            'outputs' => $outputsSum,
            'openingBalance' => $openingBalance,
            'finalBalance' => $finalBalance,
            'startDate' => $startDateInput,
            'endDate' => $endDateInput,
            'chartData' => $chartRows,
            // keep original filters to populate form
            'filters' => [
                'type' => $type,
                'status' => $status,
                'payment_way' => $paymentWay,
                'amount_min' => $amountMin,
                'amount_max' => $amountMax,
                'q' => $q,
                'per_page' => $perPage,
            ],
        ]);
    }

    /**
     * Download report for account as CSV or PDF.
     * Route in repo: accounts.report.download
     * Query param: format=csv|pdf (default csv)
     */
    public function downloadReport(Request $request, Accounts $account)
    {
        $format = $request->get('format', 'csv');

        // Reuse the same filter logic as showReport: replicate key filters
        $type = $request->get('type');
        $status = $request->get('status');
        $paymentWay = $request->get('payment_way');
        $amountMin = $request->get('amount_min');
        $amountMax = $request->get('amount_max');
        $q = $request->get('q');

        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        try {
            $gregorianStartDate = $startDateInput ? Jalalian::fromFormat('Y/m/d', $startDateInput)->toCarbon()->format('Y-m-d') : null;
            $gregorianEndDate = $endDateInput ? Jalalian::fromFormat('Y/m/d', $endDateInput)->toCarbon()->format('Y-m-d') : null;
        } catch (\Throwable $e) {
            $gregorianStartDate = null;
            $gregorianEndDate = null;
        }

        $query = Transaction::where('account_id', $account->id)
            ->when($gregorianStartDate, fn($q) => $q->where('date', '>=', $gregorianStartDate))
            ->when($gregorianEndDate, fn($q) => $q->where('date', '<=', $gregorianEndDate))
            ->when($type && $type !== 'any', fn($q) => $q->where('type', $type))
            ->when($status && $status !== 'any', fn($q) => $q->where('status', $status))
            ->when($paymentWay && $paymentWay !== 'any', fn($q) => $q->where('payment_way', $paymentWay))
            ->when(is_numeric($amountMin), fn($q) => $q->where('amount', '>=', $amountMin))
            ->when(is_numeric($amountMax), fn($q) => $q->where('amount', '<=', $amountMax))
            ->when($q, fn($qb) => $qb->where(function ($qq) use ($q) {
                $qq->where('notes', 'like', "%{$q}%")
                    ->orWhere('tracking_number', 'like', "%{$q}%");
            }))
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc');

        $allTransactions = $query->get();

        // compute opening balance
        $openingBalance = 0;
        if ($gregorianStartDate) {
            $openingInputs = Transaction::where('account_id', $account->id)
                ->where('date', '<', $gregorianStartDate)
                ->where('type', 'input')
                ->sum('amount');
            $openingOutputs = Transaction::where('account_id', $account->id)
                ->where('date', '<', $gregorianStartDate)
                ->where('type', 'output')
                ->sum('amount');
            $openingBalance = $openingInputs - $openingOutputs;
        }

        // compute running balance
        $running = $openingBalance;
        $rows = [];
        foreach ($allTransactions as $tx) {
            if ($tx->type === 'input') {
                $running += $tx->amount;
            } else {
                $running -= $tx->amount;
            }
            $rows[] = [
                'date' => $tx->date,
                'type' => $tx->type,
                'amount' => $tx->amount,
                'running_balance' => $running,
                'notes' => $tx->notes,
                'tracking_number' => $tx->tracking_number,
                'user_id' => $tx->user_id,
                'payment_way' => $tx->payment_way,
                'status' => $tx->status,
                'category' => $tx->category,
                'id' => $tx->id,
            ];
        }

        if ($format === 'csv') {
            $filename = 'account_report_' . $account->id . '_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($rows, $openingBalance) {
                $out = fopen('php://output', 'w');
                // BOM for Excel UTF-8
                fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));
                // Header row
                fputcsv($out, [
                    'Date',
                    'Type',
                    'Amount',
                    'Running Balance (start)',
                    'Tracking Number',
                    'Notes',
                    'Payment Way',
                    'Status',
                    'User ID',
                    'Category',
                    'Transaction ID',
                ]);

                // write opening balance as a separate row
                fputcsv($out, ['OPENING BALANCE', '', '', $openingBalance]);

                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r['date'],
                        $r['type'],
                        $r['amount'],
                        $r['running_balance'],
                        $r['tracking_number'],
                        $r['notes'],
                        $r['payment_way'],
                        $r['status'],
                        $r['user_id'],
                        $r['category'],
                        $r['id'],
                    ]);
                }
                fclose($out);
            };

            return Response::stream($callback, 200, $headers);
        }

        // attempt PDF if requested and library exists
        if ($format === 'pdf') {
            // If you have barryvdh/laravel-dompdf - use \PDF facade
            if (class_exists(\Barryvdh\DomPDF\Facade::class) || class_exists(\Dompdf\Dompdf::class) || app()->bound('dompdf')) {
                try {
                    $pdfView = view('dashboard.accounts.report_pdf', [
                        'account' => $account,
                        'rows' => $rows,
                        'openingBalance' => $openingBalance,
                        'generatedAt' => now(),
                    ])->render();

                    if (app()->bound('dompdf')) {
                        $pdf = app('dompdf.wrapper');
                        $pdf->loadHTML($pdfView);
                        return $pdf->download('account_report_' . $account->id . '.pdf');
                    } else {
                        // fallback using barryvdh facade if present
                        $pdf = \PDF::loadHTML($pdfView);
                        return $pdf->download('account_report_' . $account->id . '.pdf');
                    }
                } catch (\Throwable $e) {
                    // fallback to HTML download if PDF generation fails
                    return response($pdfView)
                        ->header('Content-Type', 'text/html')
                        ->header('Content-Disposition', 'attachment; filename="account_report_' . $account->id . '.html"');
                }
            }

            // no pdf library installed: return HTML file with appropriate headers
            $html = view('dashboard.accounts.report_pdf', [
                'account' => $account,
                'rows' => $rows,
                'openingBalance' => $openingBalance,
                'generatedAt' => now(),
            ])->render();

            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'attachment; filename="account_report_' . $account->id . '.html"');
        }

        // unsupported format
        return redirect()->back()->with('error', 'Unsupported export format.');
    }





    // end accounts
}
