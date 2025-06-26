<x-admin.main title="تسویه‌ها">
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head-content mb-3 text-end">
                    <a href="{{ route('settlements.create') }}" class="btn btn-success">ثبت تسویه جدید</a>
                </div>
                <div class="card card-bordered">
                    <div class="card-inner">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>شریک</th>
                                <th>نوع</th>
                                <th>مبلغ</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($settlements as $settlement)
                                <tr>
                                    <td>{{ $settlement->partner->name ?? '-' }}</td>
                                    <td>
                                        @if($settlement->type == 'debt')
                                            <span class="badge bg-danger">بدهی</span>
                                        @else
                                            <span class="badge bg-success">تسویه</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($settlement->amount) }}</td>
                                    <td>{{ jdate($settlement->created_at)->format('Y/m/d') }}</td>
                                    <td>
                                        @if($settlement->type == 'debt')
                                            @php
                                                // مجموع تسویه های مربوط به این partner و order
                                                $settled = \App\Models\Settlement::where('partner_id', $settlement->partner_id)
                                                    ->where('order_id', $settlement->order_id)
                                                    ->where('type', 'settlement')
                                                    ->sum('amount');
                                            @endphp
                                            @if($settled >= $settlement->amount)
                                                <span class="badge bg-success">تسویه‌شده</span>
                                            @else
                                                <span class="badge bg-warning">تسویه نشده</span>
                                            @endif
                                        @else
                                            <span class="badge bg-success">تسویه</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('settlements.show', $settlement->id) }}" class="btn btn-info btn-sm">جزئیات</a>
                                        @if($settlement->type == 'debt' && $settled < $settlement->amount)
                                            <a href="{{ route('settlements.create', [
                                                    'partner_id' => $settlement->partner_id,
                                                    'amount' => $settlement->amount - $settled,
                                                    'order_id' => $settlement->order_id
                                                ]) }}" class="btn btn-success btn-sm">
                                                ثبت تسویه
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">تسویه‌ای ثبت نشده است.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $settlements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.main>
