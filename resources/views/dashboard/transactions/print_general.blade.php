<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/dashlite.rtl.css" />

    <link rel="stylesheet" href="/assets/css/fonta/all.css" />
    <link rel="stylesheet" href="/assets/css/fonta/sharp-light.css" />
    <link rel="stylesheet" href="/assets/css/fonta/sharp-thin.css" />
    <title>پرینت لیست تراکنش‌ها</title>

    <style>
        /* تعریف فونت YekanBakhFaNum */
        @font-face {
            font-family: YekanBakhFaNum;
            font-style: normal;
            font-weight: normal;
            src: url("/assets/fonts/woff/YekanBakhFaNum-Regular.woff") format("woff"),
            url("/assets/fonts/woff2/YekanBakhFaNum-Regular.woff2") format("woff2"),
            url("/assets/fonts/ttf/YekanBakhFaNum-Regular.ttf") format("truetype"),
            url("/assets/fonts/otf/YekanBakhFaNum-Regular.otf") format("opentype");
        }
        @font-face {
            font-family: YekanBakhFaNum;
            font-style: normal;
            font-weight: bold;
            src: url("/assets/fonts/woff/YekanBakhFaNum-Bold.woff") format("woff"),
            url("/assets/fonts/woff2/YekanBakhFaNum-Bold.woff2") format("woff2"),
            url("/assets/fonts/ttf/YekanBakhFaNum-Bold.ttf") format("truetype"),
            url("/assets/fonts/otf/YekanBakhFaNum-Bold.otf") format("opentype");
        }

        body {
            font-family: 'YekanBakhFaNum', sans-serif !important;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 1mm; /* حاشیه‌های کلی محتوا از هر چهار طرف */
            direction: rtl;
            text-align: right;
            font-size: 10pt;
            box-sizing: border-box;
            background: #ffff;
        }
        .print-container {
            width: 100%;
            max-width: 800px; /* این مقدار در @media print ممکن است نادیده گرفته شود */
            margin: 0 auto;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'YekanBakhFaNum', Arial, sans-serif !important;
            margin-top: 0;
            margin-bottom: 10px;
        }
        hr {
            border-top: 1px dashed #ccc;
            margin: 20px 0;
        }

        /* سربرگ */
        .print-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 5px 0 10px 10px;
            box-sizing: border-box;
            width: 100%;
            flex-shrink: 0;
            background-color: #fff;
            margin-bottom: 15px;
            page-break-after: avoid;
        }
        .header-left { flex: 0 0 150px; text-align: right; }
        .header-center { flex: 1; text-align: center; margin: 0 20px; }
        .header-right { flex: 0 0 200px; text-align: left; }
        .print-header h1 {
            font-size: 20pt !important;
            margin-bottom: 5px !important;
        }
        .print-header p {
            font-size: 10pt !important;
            margin: 0 !important;
        }
        .header-left img {
            max-height: 70px !important;
            width: auto;
            display: block;
        }


        /* استایل‌های جدول تراکنش‌ها */
        .transactions-table {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            font-size: 9pt;
            page-break-inside: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .transactions-table th, .transactions-table td {
            border: none;
            padding: 8px 10px !important;
            text-align: right !important;
            vertical-align: middle;
            white-space: normal;
        }
        .transactions-table th {
            font-weight: bold;
            background-color: #f2f2f2;
            border-bottom: 1px solid #ddd;
        }
        .transactions-table tbody td {
            border-bottom: 1px solid #eee;
            border-left: 1px solid #eee;
        }
        .transactions-table tbody td:last-child {
            border-left: none;
        }
        .transactions-table tbody tr:last-child td {
            border-bottom: none;
        }

        .transactions-table thead {
            display: table-header-group;
        }
        .transactions-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        .transactions-table tfoot {
            font-weight: bold;
            display: table-footer-group;
            background-color: #e9e9e9;
            border-top: 1px solid #ddd;
        }
        .transactions-table tfoot td {
            text-align: left !important;
            padding: 10px !important;
        }
        .transactions-table tfoot td:first-child {
            text-align: right !important;
        }

        /* آیکون‌ها برای نوع تراکنش */
        .nk-tnx-type { display: flex; align-items: center; }
        .nk-tnx-type-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 5px;
            /* اگر می‌خواهید پس‌زمینه داشته باشند، اینجا اضافه کنید. در حال حاضر transparent است. */
            /* background-color: #e0ffe0;*/
        }
        .nk-tnx-type-icon em {
            font-size: 14px;
            /* رنگ آیکون مستقیماً از text-success/danger گرفته شود */
        }
        .text-success { color: #28a745 !important; }
        .text-danger { color: #dc3545 !important; }

        /* استایل‌های وضعیت تراکنش (بدون پس‌زمینه و با آیکون) */
        .transaction-status {
            display: flex;
            align-items: center;
            font-weight: bold;
        }
        .transaction-status em {
            font-family: "Nioicon" !important; /* مشخص کردن فونت برای آیکون‌ها */
            font-size: 1.1em;
            margin-left: 5px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .status-paid { color: #28a745; }
        .status-paid em { color: #28a745; }
        .status-unpaid { color: #dc3545; }
        .status-unpaid em { color: #dc3545; }

        /* بخش مهر و امضا */
        .signatures-section {
            display: flex;
            justify-content: space-around;
            width: 100%;
            padding: 5px 0;
            box-sizing: border-box;
            background-color: #fff;
            margin-top: 40px; /* مارجین برای نمایش عادی */
            page-break-inside: avoid;
        }
        .signature-box {
            flex: 0 0 45%;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            color: #7c7c7c;
            background-color: #ffffff;
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            box-shadow: none !important;
        }
        .signature-box p {
            margin: 0;
            font-size: 10pt;
        }

        /* فوتر */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 2px 0;
            box-sizing: border-box;
            border-top: 1px solid #eee;
            background-color: #fff;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        /* قوانین پرینت */
        @media print {
            @page {
                size: A4 portrait;
            }
            body {
                margin: 1mm !important; /* افزایش مارجین به 1 میلی‌متر از هر طرف */
                padding: 0 !important;
            }
            .print-container {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
            }
            .print-header, .footer {
                position: static !important;
                margin: initial !important;
                padding: initial !important;
                top: auto !important;
                bottom: auto !important;
                left: auto !important;
                right: auto !important;
                width: auto !important;
                z-index: auto !important;
                border: initial !important;
                box-shadow: none !important;
            }
            /* اصلاح مارجین مهر و امضا در حالت پرینت */
            .signatures-section {
                position: static !important;
                margin-top: 6mm !important; /* افزایش مارجین بالا در حالت پرینت */
                margin-bottom: 5mm !important; /* افزایش مارجین پایین در حالت پرینت */
                padding: initial !important;
                top: auto !important;
                bottom: auto !important;
                left: auto !important;
                right: auto !important;
                width: auto !important;
                z-index: auto !important;
                border: initial !important;
                box-shadow: none !important;
                /* اطمینان از اینکه رنگ‌ها پرینت شوند */
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            /* مخفی کردن عناصر UI اضافی در پرینت */
            .nk-sidebar, .nk-header, .toggle-wrap, .nk-block-tools, .btn-toolbar,
            #printInvoiceBtn, .nk-block-head-content:has(a.toggle), .dropdown, .alert,
            .nk-block-between:has(a.toggle), .nk-block-head-content .nk-block-title + .nk-block-des {
                display: none !important;
            }
            /* اطمینان از نمایش رنگ پس‌زمینه و آیکون‌ها */
            .transactions-table th, .nk-tnx-type-icon, .transaction-status em {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .transactions-table th { background-color: #f2f2f2 !important; }
            .nk-tnx-type-icon { background-color: transparent !important; }
            /* برای اطمینان از نمایش آیکون‌ها در پرینت */
            .icon {
                font-family: "Nioicon" !important;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .badge {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                color: #fff !important;
            }
        }
    </style>

</head>
<body onload="window.print()">
<div class="print-container">
    {{-- سربرگ پرینت --}}
    <div class="print-header">
        <div class="header-left">
            <img src="{{ asset('/assets/images/logo_honaresadaf.png') }}" alt="لوگو فروشگاه">
        </div>
        <div class="header-center">
            <h1>لیست تراکنش‌ها</h1>
            @if(request()->query())
                <div style="font-size: 9pt; margin-top: 5px; text-align: center;">
                    <strong>فیلترها:</strong>
                    <ul style="list-style: none; padding: 0; margin: 0; display: inline-block;">
                        @php
                            $filters = [
                                'type' => ['input' => 'ورودی', 'output' => 'خروجی'],
                                'status' => ['paid' => 'پرداخت شده', 'unpaid' => 'پرداخت نشده'],
                                'account' => function($accountId) {
                                    $account = \App\Models\Accounts::find($accountId);
                                    return $account ? $account->label : 'نامشخص';
                                },
                                'payment_method' => ['card' => 'کارت به کارت', 'cash' => 'نقدی', 'online' => 'درگاه پرداخت', 'pos' => 'دستگاه پز'],
                                'amount_from' => 'مبلغ از',
                                'amount_to' => 'مبلغ تا',
                                'date_from' => 'تاریخ از',
                                'date_to' => 'تاریخ تا',
                                'include_deleted' => 'شامل حذف شده‌ها'
                            ];
                            $appliedFilters = [];
                            foreach(request()->query() as $key => $value) {
                                if (!empty($value) && !in_array($key, ['per_page', 'sort'])) {
                                    $displayValue = $value;
                                    $displayKey = $key;

                                    if (isset($filters[$key])) {
                                        if (is_array($filters[$key]) && isset($filters[$key][$value])) {
                                            $displayValue = $filters[$key][$value];
                                            // Translate the key for display if needed
                                            if ($key === 'type') $displayKey = 'نوع';
                                            if ($key === 'status') $displayKey = 'وضعیت';
                                            if ($key === 'payment_method') $displayKey = 'روش پرداخت';
                                        } elseif (is_callable($filters[$key])) {
                                            $displayValue = $filters[$key]($value);
                                            if ($key === 'account') $displayKey = 'حساب مقصد';
                                        } elseif (is_string($filters[$key])) {
                                            $displayKey = $filters[$key]; // Use the predefined string as key
                                        }
                                    }

                                    // Special handling for 'include_deleted' checkbox
                                    if ($key === 'include_deleted' && $value === 'on') {
                                        $displayValue = 'بله';
                                        $displayKey = 'شامل حذف شده‌ها';
                                    }

                                    // Handle 'any' value for select boxes
                                    if ($value === 'any') {
                                        continue; // Don't display 'any' filter
                                    }

                                    $appliedFilters[] = "$displayKey: $displayValue";
                                }
                            }
                        @endphp
                        @if(!empty($appliedFilters))
                            @foreach($appliedFilters as $filterText)
                                <li style="display: inline-block; margin-left: 10px;">{{ $filterText }}</li>
                            @endforeach
                        @else
                            <li style="display: inline-block;">فیلتری اعمال نشده است.</li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
        <div class="header-right">
            <p class="fw-bold">فروشگاه هنر صدف</p>
            <p>تاریخ پرینت: <span class="print-date-js"></span></p>
            <p>کاربر پرینت کننده: <span>{{ Auth::user()->name ?? 'ناشناس' }}</span></p>
        </div>
    </div>

    <hr>

    {{-- جدول لیست تراکنش‌ها --}}
    <div class="printable-section">
        <table class="transactions-table">
            <thead>
            <tr>
                <th>ردیف</th>
                <th>جزئیات</th>
                <th>حساب بانکی</th>
                <th>مربوط به ...</th>
                <th class="text-end">مقدار</th>
                <th class="text-end">تاریخ</th>
                <th>وضعیت</th>
            </tr>
            </thead>
            <tbody>
            @forelse($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="nk-tnx-type">
                            @if($transaction->type == 'input')
                                <div class="nk-tnx-type-icon text-success">
                                    <em class="icon ni ni-arrow-down-left"></em>
                                </div>
                            @elseif($transaction->type == 'output')
                                <div class="nk-tnx-type-icon text-danger">
                                    <em class="icon ni ni-arrow-up-right"></em>
                                </div>
                            @endif
                            <div class="nk-tnx-type-text">
                                <span class="tb-lead" style="display: block;">{{ $transaction->name }}</span>
                                <span class="tb-date" style="font-size: 8pt; color: #777;">({{ jdate($transaction->date)->ago() }})</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="tb-lead-sub" style="display: block;">{{ $transaction->account->label ?? 'نامشخص' }}</span>
                        <span class="tb-sub" style="font-size: 8pt; color: #777;">{{ __('payment.'. $transaction->payment_way) }}</span>
                    </td>
                    <td>
                                <span class="tb-lead-sub">
                                    {{ __('payment.' . $transaction->source_type) . ' ' . "#$transaction->source_id" }}
                                </span>
                    </td>
                    <td class="text-end">
                        <span class="tb-amount">{{ number_format($transaction->amount) }} <span>تومان</span></span>
                    </td>
                    <td class="text-end">
                        <span class="tb-amount">{{ jdate($transaction->date)->format('Y/m/d') }}</span>
                        <span class="tb-amount-sm" style="display: block; font-size: 8pt; color: #777;">{{ jdate($transaction->date)->format('%B') }}</span>
                    </td>
                    <td>
                        <div class="transaction-status fw-normal">
                            @if($transaction->status == 'paid')
                                <em class="icon ni ni-check-circle-fill status-paid fs-20px"></em> پرداخت شده
                            @elseif($transaction->status == 'unpaid')
                                <em class="icon ni ni-cross-circle-fill status-unpaid fs-20px"></em> پرداخت نشده
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">هیچ تراکنشی یافت نشد.</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4" class="text-start">جمع کل تراکنش‌ها:</td>
                <td colspan="3" class="text-start">{{ number_format($transactions->sum('amount')) }} تومان</td>
            </tr>
            </tfoot>
        </table>
    </div>

    {{-- بخش مهر و امضا --}}
    <div class="signatures-section">
        <div class="signature-box">
            <p>مهر فروشگاه</p>
        </div>
        <div class="signature-box">
            <p>امضای مسئول</p>
        </div>
    </div>

    {{-- فوتر --}}
    <div class="footer">
        <p>این گزارش با نرم‌افزار <b>صدف پرداز</b> تولید شده است.</p>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        const printDateElements = document.querySelectorAll('.print-date-js');
        if (typeof jdate === 'function') {
            const now = new Date();
            // فرمت jdate را برای نمایش ساعت نیز تغییر می‌دهیم
            const jalaaliDate = jdate(now).format('Y/m/d H:i');
            printDateElements.forEach(el => {
                el.textContent = jalaaliDate;
            });
        } else {
            // Fallback برای تاریخ میلادی همراه با ساعت
            const now = new Date();
            const gregorianDate = now.toLocaleDateString('fa-IR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
            printDateElements.forEach(el => {
                el.textContent = gregorianDate;
            });
        }
        window.print();
    });
</script>
</body>
</html>
