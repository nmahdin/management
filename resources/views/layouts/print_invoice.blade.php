<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>فاکتور سفارش #{{ $order->id ?? '' }}</title>

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

        /* استایل‌های عمومی برای صفحه پرینت */
        body {
            font-family: 'YekanBakhFaNum', sans-serif !important;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 10mm; /* حاشیه‌های کلی محتوا از هر چهار طرف */
            direction: rtl;
            text-align: right;
            font-size: 10pt;
            /* position: relative; دیگر نیاز نیست */
            box-sizing: border-box; /* برای اینکه padding به عرض و ارتفاع کلی اضافه نشود */
        }
        .invoice-container {
            width: 100%;
            max-width: 800px; /* حداکثر عرض محتوا */
            margin: 0 auto; /* محتوا را در وسط قرار می‌دهد */
        }
        hr {
            border-top: 1px dashed #ccc;
            margin: 20px 0;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'YekanBakhFaNum', Arial, sans-serif !important;
            margin-top: 0;
            margin-bottom: 10px;
        }
        p {
            margin: 5px 0;
        }
        ul.list-plain {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.list-plain li {
            margin-bottom: 5px;
        }

        /* سربرگ فاکتور - دیگر fixed نیست */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 5px 0 10px 10px; /* padding داخلی (چپ و راست را صفر کردیم تا به margin@page بچسبد) */
            box-sizing: border-box;
            width: 100%;
            flex-shrink: 0;
            /* height: 80px; دیگر نیازی به height ثابت نیست مگر اینکه بخواهید فضای آن دقیقاً اینقدر باشد */
            background-color: #fff;
            /* z-index دیگر نیاز نیست */
            margin-bottom: 15px;
        }
        .header-left { flex: 0 0 150px; text-align: right; }
        .header-center { flex: 1; text-align: center; margin: 0 20px; }
        .header-right { flex: 0 0 200px; text-align: left; }
        .invoice-header h1 {
            font-size: 20pt !important;
            margin-bottom: 5px !important;
        }
        .invoice-header p {
            font-size: 10pt !important;
            margin: 0 !important;
        }
        .header-left img {
            max-height: 70px !important;
            width: auto;
            display: block;
        }

        /* استایل‌های باکس اطلاعات مشتری و کاربر ثبت کننده */
        .info-boxes-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .info-box {
            flex: 1;
            padding: 10px;
            border: 1px solid #eee;
            margin-left: 10px;
            border-radius: 10px;
            color: #333;
            background-color: #f9f9f9;
        }
        .info-box:last-child {
            margin-left: 0;
        }
        .info-box h6 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 11pt;
            color: #555;
        }

        /* استایل‌های جدول */
        table {
            width: 100% !important;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9pt;
            page-break-inside: auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px !important;
            text-align: right !important;
            vertical-align: top;
            white-space: normal;
        }
        th {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        tfoot {
            font-weight: bold;
            display: table-footer-group;
        }
        tfoot tr:first-child {
            background-color: #d8d8d8;
            color: #3a3a3a;
        }
        tfoot tr:last-child {
            background-color: #d6d6d6;
            color: #3a3a3a;
        }
        tfoot td {
            text-align: left !important;
        }
        tfoot td:first-child {
            text-align: right !important;
        }
        .text-danger { color: #c33944 !important; }
        .text-success { color: #28a745 !important; }

        /* عنوان بخش ها */
        .section-title {
            margin-top: 30px;
            margin-bottom: 10px;
            page-break-after: avoid;
            page-break-inside: avoid;
        }
        .printable-section {
            page-break-inside: avoid;
            page-break-before: auto;
        }
        .force-new-page {
            page-break-before: always !important;
        }

        /* استایل‌های بخش امضاها - دیگر fixed نیست */
        .signatures-section {
            display: flex;
            justify-content: space-around;
            width: 100%;
            padding: 5px 0; /* padding داخلی (چپ و راست را صفر کردیم) */
            box-sizing: border-box;
            /* height: 120px; دیگر نیازی به height ثابت نیست */
            background-color: #fff;
            /* z-index دیگر نیاز نیست */
            margin-top: 30px; /* فاصله از محتوای بالای خود */
            page-break-inside: avoid; /* جلوگیری از شکستن در وسط صفحه */
        }
        .signature-box {
            flex: 0 0 45%;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            color: #7c7c7c;
            background-color: #ffffff;
            height: 100px; /* ارتفاع داخلی باکس امضا را تنظیم کردیم */
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            box-shadow: none !important;
        }
        .signature-box p {
            margin: 0;
            font-size: 10pt;
        }

        /* استایل‌های footer (متن "صدف پرداز") - دیگر fixed نیست */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 2px 0; /* padding داخلی (چپ و راست را صفر کردیم) */
            box-sizing: border-box;
            /* height: 25px; دیگر نیازی به height ثابت نیست */
            border-top: 1px solid #eee;
            background-color: #fff;
            /* z-index دیگر نیاز نیست */
            margin-top: 10px; /* فاصله از بخش امضا */
            page-break-inside: avoid; /* جلوگیری از شکستن در وسط صفحه */
        }


        /* ----- Print Specific Overrides ----- */
        @media print {
            /* مخفی کردن عناصر UI اضافی Nioboard */
            .nk-sidebar, .nk-header, .toggle-wrap, .nk-block-tools, .btn-toolbar,
            #printInvoiceBtn, .nk-block-head-content:has(a.toggle), .dropdown, .alert,
            .nk-block-between:has(a.toggle), .nk-block-head-content .nk-block-title + .nk-block-des {
                display: none !important;
            }

            /* تنظیمات عمومی برای محتوای اصلی در پرینت */
            .nk-content { padding: 0 !important; }
            .container-xl, .container-fluid {
                width: 100% !important;
                max-width: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /* تنظیمات flex برای چیدمان اصلی صفحه */
            .row.g-gs {
                display: flex;
                flex-wrap: wrap;
                margin: 0 !important;
                gap: 0 !important;
            }
            .col-lg-4, .col-xl-4, .col-xxl-3 {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                padding: 0 5mm !important;
            }
            .col-lg-8, .col-xl-8, .col-xxl-9 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
                padding: 0 5mm !important;
            }

            /* تنظیمات برای کارت‌ها و بلوک‌ها - حذف سایه و حاشیه اضافی Nioboard */
            .card, .nk-block {
                box-shadow: none !important;
                border: none !important;
                margin-bottom: 0 !important;
                padding: 0 !important;
            }
            .card-inner { padding: 5mm !important; }
            .user-card, .profile-stats, .overline-title, .lead-text, .sub-text {
                margin: 0 !important;
                padding: 0 !important;
            }
            .user-card-s2 .user-info {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
            .user-card-status { margin-top: 10px !important; }
            .badge {
                font-size: 8pt !important;
                padding: 3px 6px !important;
            }

            /* اطمینان از نمایش رنگ پس‌زمینه برای فوتر جدول و جاهای دیگر */
            tfoot td.bg-secondary-dim {
                background-color: #d8d8d8 !important;
                color: #3a3a3a !important;
            }
            tfoot td.text-success { color: #28a745 !important; }
            tfoot td.text-danger { color: #c33944 !important; }

            /* قوانین Page-Break برای جلوگیری از شکستن ناخواسته */
            section, .nk-block, .card {
                page-break-inside: avoid !important;
            }
            .info-boxes-row {
                page-break-before: auto;
                page-break-after: auto;
                page-break-inside: avoid;
            }
            .printable-section {
                page-break-inside: avoid !important;
                page-break-after: auto !important;
            }

            /* ----------------------------------------------- */
            /* قوانین حاشیه صفحه برای پرینت */
            /* ----------------------------------------------- */

            @page {
                /* تعریف حاشیه 10mm از هر طرف برای خود صفحه پرینت */
                margin: 10mm; /* این حاشیه به اطراف کل صفحه اعمال می‌شود */
                size: A4 portrait; /* اطمینان از اندازه و جهت صفحه */
            }

            /*
            چون دیگر عناصر fixed نیستند، padding-top و padding-bottom body
            صرفاً نقش حاشیه‌های داخلی را بازی می‌کنند و باید با margin@page هماهنگ باشند.
            */
            body {
                padding: 10mm !important; /* حاشیه‌های کلی محتوا از هر چهار طرف را به @page منتقل کردیم */
                box-sizing: border-box; /* اطمینان از اینکه padding در محاسبه عرض و ارتفاع لحاظ شود */
            }

            /* container اصلی محتوا - باید 100% عرض padding شده body را اشغال کند */
            .invoice-container {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important; /* حذف margin: 0 auto; برای پرینت */
            }

            /* این padding برای باکس‌های اطلاعات مشتری را حذف می‌کنیم چون padding-top کلی body آن را پوشش می‌دهد */
            .info-boxes-row {
                padding-top: 0 !important;
            }
        }
    </style>

    <style>
        @media print {
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
            body { margin: 0; }
            .no-break { page-break-inside: avoid; break-inside: avoid; }
        }
    </style>

</head>
<body onload="window.print()">
@yield('content')

<script>
    window.addEventListener('load', function() {
        const printDateElements = document.querySelectorAll('.print-date-js');
        const jalaaliDate = new Date().toLocaleDateString('fa-IR', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
        printDateElements.forEach(el => {
            el.textContent = jalaaliDate;
        });
    });
</script>

</tbody>
</table>

</body>
</html>
