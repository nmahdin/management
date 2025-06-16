<x-admin.main title="گزارش حساب {{ $account->label }}">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">گزارش حساب "{{ $account->label }}"</h3>
                            <div class="nk-block-des text-soft">
                                <p>نمایش گردش حساب، ورودی‌ها، خروجی‌ها و مانده حساب</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('accounts.list') }}" class="btn btn-secondary btn-dim">
                                <em class="icon ni ni-arrow-left"></em>
                                <span class="fw-normal">بازگشت به لیست حساب‌ها</span>
                            </a>
                        </div>
                    </div>
                </div>

                <x-admin.templates.successAlert/>
                <x-admin.templates.warningAlert/>
                <x-admin.templates.dangerAlert/>

                <div class="nk-block">
                    {{-- فرم فیلتر تاریخ --}}
                    <form method="get" class="row g-3 align-items-center mb-4">
                        <div class="col-md-4">
                            <label class="form-label">از تاریخ</label>
                            <input type="text" id="start_date" name="start_date" class="form-control jalali-datepicker" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">تا تاریخ</label>
                            <input type="text" id="end_date" name="end_date" class="form-control jalali-datepicker" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-4 mt-4">
                            <button type="submit" class="btn btn-primary">اعمال فیلتر</button>
                        </div>
                    </form>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card card-bordered">
                                <div class="card-inner text-center">
                                    <div class="fs-18px text-success mb-1">ورودی‌ها</div>
                                    <div class="fs-20px fw-bold">{{ number_format($inputs) }} <span class="small">تومان</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-bordered">
                                <div class="card-inner text-center">
                                    <div class="fs-18px text-danger mb-1">خروجی‌ها</div>
                                    <div class="fs-20px fw-bold">{{ number_format($outputs) }} <span class="small">تومان</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-bordered">
                                <div class="card-inner text-center">
                                    <div class="fs-18px text-primary mb-1">مانده حساب</div>
                                    <div class="fs-20px fw-bold">{{ number_format($balance) }} <span class="small">تومان</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- جدول تراکنش‌ها --}}
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h5 class="mb-3">لیست تراکنش‌ها</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>تاریخ</th>
                                        <th>نوع</th>
                                        <th>مبلغ</th>
                                        <th>شرح</th>
                                        <th>ثبت‌کننده</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($transactions as $tx)
                                        <tr>
                                            <td>{{ jdate($tx->date)->format('Y/m/d') }}</td>
                                            <td>
                                                @if($tx->type == 'input')
                                                    <span class="badge bg-success">ورودی</span>
                                                @else
                                                    <span class="badge bg-danger">خروجی</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($tx->amount) }}</td>
                                            <td>{{ $tx->notes }}</td>
                                            <td>{{ $tx->user->name ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">تراکنشی یافت نشد.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- نمودار ساده --}}
                    <div class="card card-bordered mt-4">
                        <div class="card-inner">
                            <h5 class="mb-3">نمودار گردش حساب در بازه انتخابی</h5>
                            <canvas id="accountChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @slot('script')
        <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@latest/dist/css/persian-datepicker.min.css"/>
        <script src="https://unpkg.com/persian-datepicker@latest/dist/js/persian-datepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function() {
                $(".jalali-datepicker").persianDatepicker({
                    format: 'YYYY/MM/DD',
                    altField: $(this).attr("id") === "start_date" ? "#start_date_alt" : "#end_date_alt",
                    initialValueType: 'persian',
                    altFormat: 'YYYY-MM-DD',
                    observer: true,
                    modelType: 'gregorian',
                    autoClose: true,
                });
            });

            const ctx = document.getElementById('accountChart').getContext('2d');
            const chartLabels = {!! json_encode(array_map(function($k){ return \Morilog\Jalali\Jalalian::fromFormat('Y-m-d', $k)->format('Y/m/d'); }, array_keys($chartData->toArray()))) !!};
            const chartInputs = {!! json_encode(array_values($chartData->pluck('input')->toArray())) !!};
            const chartOutputs = {!! json_encode(array_values($chartData->pluck('output')->toArray())) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [
                        { label: 'ورودی', data: chartInputs, backgroundColor: 'rgba(40,167,69,0.6)' },
                        { label: 'خروجی', data: chartOutputs, backgroundColor: 'rgba(220,53,69,0.6)' }
                    ]
                },
                options: {
                    scales: { y: { beginAtZero: true } }
                }
            });
        </script>
    @endslot

</x-admin.main>
