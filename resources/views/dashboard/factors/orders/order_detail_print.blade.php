@extends('layouts.print_invoice')

@section('content')
    <div class="invoice-container">
        {{-- سربرگ فاکتور --}}
        <div class="invoice-header">
            <div class="header-left">
                <img src="{{ asset('/assets/images/logo_honaresadaf.png') }}" alt="لوگو فروشگاه">
            </div>
            <div class="header-center">
                <h1>فاکتور فروش هنر صدف</h1>
                <p>آدرس: [آدرس فروشگاه شما]</p>
                <p>تلفن: [شماره تماس فروشگاه شما]</p>
            </div>
            <div class="header-right">
                <p><strong>شماره سفارش:</strong> #{{ $order->id }}</p>
                <p><strong>تاریخ فاکتور:</strong> {{ jdate($order->order_date)->format('Y/m/d') }}</p>
                <p><strong>تاریخ پرینت:</strong> <span class="print-date-js"></span></p>
                <p><strong>پیوست:</strong> <span class="attachment-info" style="color: #e6e6e6">___________</span></p>
            </div>
        </div>

        {{-- باکس اطلاعات مشتری و کاربر ثبت کننده (کنار هم) --}}
        <div class="info-boxes-row">
            <div class="info-box">
                <h6>اطلاعات مشتری:</h6>
                <ul class="list-plain">
                    <li><strong>نام مشتری:</strong> {{ $order->customer->name ?? 'نامشخص' }}</li>
                    <li><strong>شماره تماس:</strong> {{ $order->customer->number ?? 'ندارد' }}</li>
                    <li><strong>آدرس:</strong> {{ $order->customer->address ?? 'ندارد' }}</li>
                </ul>
            </div>
            <div class="info-box">
                <h6>اطلاعات ثبت:</h6>
                <ul class="list-plain">
                    <li><strong>ثبت کننده سفارش:</strong> {{ $order->user->name ?? 'نامشخص' }}</li>
                    <li><strong>تاریخ ثبت سیستم:</strong> {{ jdate($order->created_at)->format('Y/m/d H:i') }}</li>
                    <li><strong>پرینت کننده:</strong> {{ Auth::user()->name ?? 'ناشناس' }}</li>
                </ul>
            </div>
        </div>

        <hr>

        {{-- بخش محصولات سفارش --}}
        <div class="printable-section">
            <h5 class="section-title">محصولات سفارش:</h5>
            <table class="invoice-items-table">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام محصول</th>
                    <th>تعداد</th>
                    <th>قیمت واحد (تومان)</th>
                    <th>قیمت کل (تومان)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->pivot->quantity }}</td>
                        <td>{{ number_format($item->pivot->unit_price) }}</td>
                        <td>{{ number_format($item->pivot->total_price) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4" class="text-start">جمع کل:</td>
                    <td class="text-start bg-secondary-dim">{{ number_format($order->amount) }} تومان</td>
                </tr>
                </tfoot>
            </table>
        </div>

        @if($order->note)
            <div style="margin-top: 20px; border: 1px solid #eee; padding: 10px;" class="printable-section">
                <h6 style="margin-bottom: 5px;">توضیحات سفارش:</h6>
                <p>{{ $order->note }}</p>
            </div>
        @endif

        {{-- بخش پرداخت‌ها (اختیاری) --}}
        @if($order->transactions->count())
            <div class="printable-section">
                <h5 class="section-title">جزئیات پرداخت‌ها:</h5>
                <table class="invoice-payments-table">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>مبلغ (تومان)</th>
                        <th>وضعیت</th>
                        <th>تاریخ</th>
                        <th>توضیحات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->transactions as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ number_format($payment->amount) }}</td>
                            <td>
                                @if($payment->status == 'paid')
                                    پرداخت شده
                                @elseif($payment->status == 'unpaid')
                                    پرداخت نشده
                                @else
                                    مشخص نشده
                                @endif
                            </td>
                            <td>{{ jdate($payment->date)->format('Y/m/d') }}</td>
                            <td>{{ $payment->description ?? 'ندارد' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" class="text-start">جمع پرداخت‌ها:</td>
                        <td colspan="3" class="text-start">{{ number_format($order->transactions->sum('amount')) }} تومان</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-start">مانده پرداخت:</td>
                        <td colspan="3" class="text-start {{ $order->amount - $order->transactions->sum('amount') > 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($order->amount - $order->transactions->sum('amount')) }} تومان
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        @endif

        {{-- جای مهر و امضا --}}
        <div class="signatures-section">
            <div class="signature-box">
                <p>مهر و امضای فروشگاه</p>
            </div>
            <div class="signature-box">
                <p>امضای مشتری</p>
            </div>
        </div>

        <div class="footer">
            <p>این فاکتور با نرم‌افزار <b>صدف پرداز</b> تولید شده است.</p>
        </div>
    </div>
@endsection
