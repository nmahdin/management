<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/dashlite.rtl.css" />
    <link rel="stylesheet" href="/assets/css/fonta/all.css" />
    <link rel="stylesheet" href="/assets/css/fonta/sharp-light.css" />
    <link rel="stylesheet" href="/assets/css/fonta/sharp-thin.css" />
    <title>پرینت جزئیات تراکنش #{{ $transaction->id }}</title>

    <style>
        /* Definition of YekanBakhFaNum font */
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
            padding: 1mm;
            direction: rtl;
            text-align: right;
            font-size: 10pt;
            box-sizing: border-box;
            background: #ffff;
        }
        .print-container {
            width: 100%;
            max-width: 800px;
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

        /* Header */
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

        /* Transaction Details */
        .transaction-details {
            width: 100%;
            margin-bottom: 20px;
            font-size: 10pt;
            page-break-inside: avoid;
        }
        .transaction-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .transaction-details th, .transaction-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        .transaction-details th {
            background-color: #f2f2f2;
        }

        /* Signature Section */
        .signatures-section {
            display: flex;
            justify-content: space-around;
            width: 100%;
            padding: 5px 0;
            box-sizing: border-box;
            background-color: #fff;
            margin-top: 40px;
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

        /* Footer */
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

        /* Print Rules */
        @media print {
            @page {
                size: A4 portrait;
            }
            body {
                margin: 1mm !important;
                padding: 0 !important;
            }
            .print-container {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
            }
            .print-header, .footer, .signatures-section {
                position: static !important;
                margin: 10px 0 0 0 !important;
                padding: initial !important;
                top: auto !important;
                bottom: auto !important;
                left: auto !important;
                right: auto !important;
                width: auto !important;
                z-index: auto !important;
                border: initial !important;
                box-shadow: none !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            /* Hide UI elements */
            .nk-sidebar, .nk-header, .toggle-wrap, .nk-block-tools, .btn-toolbar,
            #printInvoiceBtn, .nk-block-head-content:has(a.toggle), .dropdown, .alert,
            .nk-block-between:has(a.toggle), .nk-block-head-content .nk-block-title + .nk-block-des {
                display: none !important;
            }
        }
    </style>
</head>
<body onload="window.print()">
<div class="print-container">
    {{-- Print Header --}}
    <div class="print-header">
        <div class="header-left">
            <img src="{{ asset('/assets/images/logo_honaresadaf.png') }}" alt="لوگو فروشگاه">
        </div>
        <div class="header-center">
            <h1>جزئیات تراکنش</h1>
            <p>تاریخ پرینت: <span class="print-date-js"></span></p>
            <p>کاربر پرینت کننده: {{ Auth::user()->name ?? 'ناشناس' }}</p>
        </div>
        <div class="header-right">
            <p class="fw-bold">فروشگاه هنر صدف</p>
        </div>
    </div>

    <hr>

    {{-- Transaction Details in Table --}}
    <div class="transaction-details">
        <table>
            <tbody>
            <tr>
                <th>شناسه تراکنش:</th>
                <td>#{{ $transaction->id }}</td>
            </tr>
            <tr>
                <th>نوع تراکنش:</th>
                <td>{{ __("payment.$transaction->type") ?? 'نامشخص' }}</td>
            </tr>
            <tr>
                <th>نام:</th>
                <td>{{ $transaction->name ?? 'بی نام!' }}</td>
            </tr>
            <tr>
                <th>مربوط به:</th>
                <td>{{ __('payment.' . $transaction->source_type) . ' ' . "#$transaction->source_id" ?? 'هیچ' }}</td>
            </tr>
            <tr>
                <th>مبلغ:</th>
                <td>{{ number_format($transaction->amount) }} تومان</td>
            </tr>
            <tr>
                <th>تاریخ:</th>
                <td>{{ jdate($transaction->date)->format('Y/m/d') }}</td>
            </tr>
            <tr>
                <th>حساب:</th>
                <td>{{ $transaction->account->label ?? 'نامشخص' }}</td>
            </tr>
            <tr>
                <th>روش پرداخت:</th>
                <td>{{  __("payment.$transaction->payment_way") }}</td>
            </tr>
            <tr>
                <th>شماره پیگیری:</th>
                <td>{{ $transaction->tracking_number ?? 'ندارد.' }}</td>
            </tr>
            <tr>
                <th>ثبت کننده:</th>
                <td>{{ $transaction->user->name ?? 'نامشخص' }}</td>
            </tr>
            <tr>
                <th>تاریخ ثبت:</th>
                <td>{{ jdate($transaction->created_at)->format('Y/m/d , H:i') }}</td>
            </tr>
            @if($transaction->updated_at && $transaction->updated_at != $transaction->created_at)
                <tr>
                    <th>آخرین بروزرسانی:</th>
                    <td>{{ jdate($transaction->updated_at)->format('Y/m/d , H:i') }}</td>
                </tr>
            @endif
            <tr>
                <th>یادداشت‌ها:</th>
                <td>{{ $transaction->notes ?? 'برای این تراکنش یادداشتی ثبت نشده است.' }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    {{-- Attachment Information --}}
    @if($transaction->attached)
        <p><strong>پیوست:</strong> این تراکنش دارای پیوست است که در سیستم قابل مشاهده است.</p>
    @endif

    {{-- Signature Section --}}
    <div class="signatures-section">
        <div class="signature-box">
            <p>مهر فروشگاه</p>
        </div>
        <div class="signature-box">
            <p>امضای مسئول</p>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>این گزارش با نرم‌افزار <b>صدف پرداز</b> تولید شده است.</p>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        const printDateElements = document.querySelectorAll('.print-date-js');
        if (typeof jdate === 'function') {
            const now = new Date();
            const jalaaliDate = jdate(now).format('Y/m/d H:i');
            printDateElements.forEach(el => {
                el.textContent = jalaaliDate;
            });
        } else {
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
