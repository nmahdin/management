<x-admin.main title="جزئیات شریک {{ $partner->name }}">
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">

                {{-- اطلاعات پایه شریک --}}
                <div class="card card-bordered mb-3">
                    <div class="card-inner">
                        <h5>اطلاعات شریک</h5>
                        <ul class="list-unstyled">
                            <li><strong>نام:</strong> {{ $partner->name }}</li>
                            <li><strong>شماره تماس:</strong> {{ $partner->phone ?? '-' }}</li>
                            <li><strong>آدرس:</strong> {{ $partner->address ?? '-' }}</li>
                            <li><strong>یادداشت:</strong> {{ $partner->note ?? '-' }}</li>
                            <li><strong>تاریخ عضویت:</strong> {{ jdate($partner->created_at)->format('Y/m/d') }}</li>
                        </ul>
                    </div>
                </div>

                {{-- وضعیت حساب --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="card card-bordered text-center">
                            <div class="card-inner">
                                <div class="fs-18px text-danger mb-1">مجموع بدهی (تسویه نشده)</div>
                                <div class="fs-20px fw-bold">{{ number_format($balance) }} تومان</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('settlements.create', ['partner_id' => $partner->id]) }}" class="btn btn-success mt-4">
                            ثبت تسویه جدید
                        </a>
                    </div>
                </div>

                {{-- بدهی‌ها --}}
                <div class="card card-bordered mb-3">
                    <div class="card-inner">
                        <h5>بدهی‌های ثبت شده</h5>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>سفارش</th>
                                <th>مبلغ</th>
                                <th>توضیح</th>
                                <th>تاریخ ثبت</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($debts as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.detail' , $item->order->id) }}">
                                            @if($item->order)
                                                #{{ $item->order->id }}
                                            @else
                                                -
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{ number_format($item->amount) }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ jdate($item->created_at)->format('Y/m/d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">بدهی ثبت نشده است.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- تسویه‌ها --}}
                <div class="card card-bordered mb-3">
                    <div class="card-inner">
                        <h5>تسویه‌های انجام‌شده</h5>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>مبلغ</th>
                                <th>روش</th>
                                <th>شماره پیگیری</th>
                                <th>تاریخ</th>
                                <th>توضیح</th>
                                <th>سفارش</th>
                                <th>ثبت‌کننده</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($settlements as $settlement)
                                <tr>
                                    <td>{{ number_format($settlement->amount) }}</td>
                                    <td>{{ $settlement->method }}</td>
                                    <td>{{ $settlement->reference }}</td>
                                    <td>{{ jdate($settlement->settled_at ?? $settlement->created_at)->format('Y/m/d H:i') }}</td>
                                    <td>{{ $settlement->description }}</td>
                                    <td>
                                        @if($settlement->order)
                                            #{{ $settlement->order->id }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $settlement->user?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">تسویه‌ای برای شریک ثبت نشده است.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin.main>
