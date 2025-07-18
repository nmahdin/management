<x-admin.main title="داشبورد شریک ها">
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">

                <div class="row g-4">
                    {{-- تعداد کل شریک‌ها --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-bordered text-center">
                            <div class="card-inner py-4">
                                <div class="fs-16px mb-1 text-muted">تعداد شریک‌ها</div>
                                <div class="fs-28px fw-bold">
                                    {{ \App\Models\Partner::count() }}
                                </div>
                                <a href="{{ route('partners.list') }}" class="btn btn-link mt-2">مشاهده</a>
                            </div>
                        </div>
                    </div>

                    {{-- مجموع بدهی تسویه‌نشده به شرکا --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-bordered text-center">
                            <div class="card-inner py-4">
                                <div class="fs-16px mb-1 text-muted">بدهی تسویه‌نشده به شرکا</div>
                                <div class="fs-20px fw-bold text-danger">
                                    {{
                                        number_format(
                                            \App\Models\Settlement::where('type', 'debt')->sum('amount') -
                                            \App\Models\Settlement::where('type', 'settlement')->sum('amount')
                                        )
                                    }} تومان
                                </div>
                                <a href="{{ route('settlements.index') }}" class="btn btn-link mt-2">تسویه‌ها</a>
                            </div>
                        </div>
                    </div>

                    {{-- مجموع تسویه‌های انجام شده --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-bordered text-center">
                            <div class="card-inner py-4">
                                <div class="fs-16px mb-1 text-muted">مجموع پرداختی به شرکا</div>
                                <div class="fs-20px fw-bold text-success">
                                    {{ number_format(\App\Models\Settlement::where('type', 'settlement')->sum('amount')) }} تومان
                                </div>
                                <a href="{{ route('settlements.index') }}" class="btn btn-link mt-2">جزئیات</a>
                            </div>
                        </div>
                    </div>

                    {{-- تعداد کل سفارش‌ها --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-bordered text-center">
                            <div class="card-inner py-4">
                                <div class="fs-16px mb-1 text-muted">سفارش‌ها</div>
                                <div class="fs-28px fw-bold">
                                    {{ \App\Models\Order::count() }}
                                </div>
                                <a href="{{ route('orders.list') }}" class="btn btn-link mt-2">مشاهده سفارش‌ها</a>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- آخرین تسویه‌های انجام شده --}}
                <div class="card card-bordered mt-5">
                    <div class="card-inner">
                        <div class="card-title mb-3">آخرین تسویه‌های ثبت‌شده</div>
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>شریک</th>
                                <th>مبلغ</th>
                                <th>تاریخ</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Models\Settlement::with('partner')->where('type', 'settlement')->latest()->take(5)->get() as $item)
                                <tr>
                                    <td>{{ $item->partner->name ?? '-' }}</td>
                                    <td>{{ number_format($item->amount) }} تومان</td>
                                    <td>{{ jdate($item->settled_at ?? $item->created_at)->format('Y/m/d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('settlements.show', $item->id) }}" class="btn btn-info btn-xs">جزئیات</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(\App\Models\Settlement::where('type', 'settlement')->count() == 0)
                                <tr>
                                    <td colspan="4" class="text-center">تسویه‌ای ثبت نشده است.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- آخرین بدهی‌های ثبت شده --}}
                <div class="card card-bordered mt-4">
                    <div class="card-inner">
                        <div class="card-title mb-3">آخرین بدهی‌های ثبت‌شده</div>
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>شریک</th>
                                <th>مبلغ</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Models\Settlement::with('partner')->where('type', 'debt')->latest()->take(5)->get() as $item)
                                @php
                                    $settled = \App\Models\Settlement::where('partner_id', $item->partner_id)
                                        ->where('order_id', $item->order_id)
                                        ->where('type', 'settlement')
                                        ->sum('amount');
                                    $isSettled = $settled >= $item->amount;
                                @endphp
                                <tr>
                                    <td>{{ $item->partner->name ?? '-' }}</td>
                                    <td>{{ number_format($item->amount) }} تومان</td>
                                    <td>{{ jdate($item->created_at)->format('Y/m/d H:i') }}</td>
                                    <td>
                                        @if($isSettled)
                                            <span class="badge bg-success">تسویه‌شده</span>
                                        @else
                                            <span class="badge bg-warning">تسویه نشده</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('settlements.show', $item->id) }}" class="btn btn-info btn-xs">جزئیات</a>
                                        @if(!$isSettled)
                                            <a href="{{ route('settlements.create', [
                                                    'partner_id' => $item->partner_id,
                                                    'amount' => $item->amount - $settled,
                                                    'order_id' => $item->order_id
                                                ]) }}" class="btn btn-success btn-xs">
                                                ثبت تسویه
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if(\App\Models\Settlement::where('type', 'debt')->count() == 0)
                                <tr>
                                    <td colspan="5" class="text-center">بدهی ثبت نشده است.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</x-admin.main>
