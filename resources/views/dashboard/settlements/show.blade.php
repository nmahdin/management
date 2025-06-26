<x-admin.main title="جزئیات تسویه">
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <ul class="list-unstyled">
                            <li><strong>شریک:</strong> {{ $settlement->partner->name ?? '-' }}</li>
                            <li><strong>نوع:</strong>
                                @if($settlement->type == 'debt')
                                    بدهی
                                @else
                                    تسویه
                                @endif
                            </li>
                            <li><strong>مبلغ:</strong> {{ number_format($settlement->amount) }} تومان</li>
                            <li><strong>تاریخ:</strong> {{ jdate($settlement->created_at)->format('Y/m/d H:i') }}</li>
                            <li><strong>سفارش:</strong>
                                @if($settlement->order)
                                    #{{ $settlement->order->id }}
                                @else
                                    -
                                @endif
                            </li>
                            <li><strong>توضیح:</strong> {{ $settlement->description ?? '-' }}</li>
                        </ul>
                        <a href="{{ route('settlements.index') }}" class="btn btn-secondary">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.main>
