<x-admin.main title="گزارش حساب">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">

                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">گزارش حساب: {{ $account->label }} ({{ $account->number }})</h3>
                            <div class="nk-block-des text-soft">
                                <p>تعداد تراکنش‌های فیلترشده: {{ $n ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="d-flex gap-2">
                                <a href="{{ route('accounts.report.download', array_merge(request()->all(), ['account' => $account->id, 'format' => 'csv'])) }}" class="btn btn-outline-primary">دانلود CSV</a>
                                <a href="{{ route('accounts.report.download', array_merge(request()->all(), ['account' => $account->id, 'format' => 'pdf'])) }}" class="btn btn-outline-secondary">دانلود PDF</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- alert components (project standard) -->
                <x-admin.templates.successAlert/>
                <x-admin.templates.warningAlert/>
                <x-admin.templates.dangerAlert/>

                <!-- Filters -->
                <div class="card mb-3">
                    <div class="card-inner">
                        <form action="{{ route('accounts.report', ['account' => $account->id]) }}" method="GET" class="row g-3">
                            <div class="col-lg-3">
                                <label class="form-label">تاریخ شروع (Jalali)</label>
                                <input type="text" name="start_date" class="form-control" value="{{ old('start_date', $startDate ?? request('start_date')) }}" placeholder="YYYY/MM/DD">
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label">تاریخ پایان (Jalali)</label>
                                <input type="text" name="end_date" class="form-control" value="{{ old('end_date', $endDate ?? request('end_date')) }}" placeholder="YYYY/MM/DD">
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">نوع تراکنش</label>
                                <select name="type" class="form-select">
                                    <option value="any" {{ (request('type','any')=='any' ? 'selected':'') }}>هر دو</option>
                                    <option value="input" {{ (request('type')=='input' ? 'selected':'') }}>واریز (input)</option>
                                    <option value="output" {{ (request('type')=='output' ? 'selected':'') }}>برداشت (output)</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">وضعیت</label>
                                <select name="status" class="form-select">
                                    <option value="any" {{ (request('status','any')=='any' ? 'selected':'') }}>هر وضعیت</option>
                                    <option value="paid" {{ (request('status')=='paid' ? 'selected':'') }}>پرداخت‌شده</option>
                                    <option value="unpaid" {{ (request('status')=='unpaid' ? 'selected':'') }}>پرداخت‌نشده</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">روش پرداخت</label>
                                <select name="payment_way" class="form-select">
                                    <option value="any" {{ (request('payment_way','any')=='any' ? 'selected':'') }}>همه</option>
                                    <option value="cash" {{ request('payment_way')=='cash' ? 'selected':'' }}>نقدی</option>
                                    <option value="cart" {{ request('payment_way')=='cart' ? 'selected':'' }}>کارت به کارت</option>
                                    <option value="online" {{ request('payment_way')=='online' ? 'selected':'' }}>آنلاین</option>
                                    <option value="pos" {{ request('payment_way')=='pos' ? 'selected':'' }}>POS</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="form-label">مبلغ از</label>
                                <input type="number" name="amount_min" class="form-control" value="{{ request('amount_min') }}">
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label">مبلغ تا</label>
                                <input type="number" name="amount_max" class="form-control" value="{{ request('amount_max') }}">
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">جستجو در توضیحات یا شماره پیگیری</label>
                                <input type="text" name="q" class="form-control" value="{{ request('q') }}">
                            </div>

                            <div class="col-lg-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">اعمال فیلتر</button>
                                    <a href="{{ route('accounts.report', ['account' => $account->id]) }}" class="btn btn-outline-secondary">پاک‌سازی</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Summary -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6>مانده ابتدای بازه</h6>
                                <div class="fs-18 fw-bold">{{ number_format($openingBalance ?? 0) }} تومان</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6>مجموع واریزها</h6>
                                <div class="fs-18 fw-bold text-success">{{ number_format($inputs ?? 0) }} تومان</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6>مجموع برداشت‌ها</h6>
                                <div class="fs-18 fw-bold text-danger">{{ number_format($outputs ?? 0) }} تومان</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart card -->
                <div class="card mb-3">
                    <div class="card-inner">
                        <h6>نمودار وارده/خارجی (روزانه)</h6>
                        <div class="chartjs-wrap">
                            <canvas id="accountReportChart" style="height:320px;"></canvas>
                        </div>

                        <!-- JSON data prepared server-side, but include Jalali labels here for nicer display -->
                        @php
                            $chartForJs = [];
                            if(!empty($chartData)) {
                                foreach($chartData as $row) {
                                    // $row expected: ['date' => 'YYYY-MM-DD', 'input' => int, 'output' => int]
                                    $label = $row['date'];
                                    try {
                                        $jalali = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d', $row['date'])->format('Y/m/d');
                                        $label = $jalali;
                                    } catch (\Throwable $e) {
                                        // fallback to original date
                                    }
                                    $chartForJs[] = [
                                        'date' => $row['date'],
                                        'label' => $label,
                                        'input' => (int) $row['input'],
                                        'output' => (int) $row['output'],
                                    ];
                                }
                            }
                        @endphp
                        <pre id="chart-data-json" style="display:none;">{!! json_encode($chartForJs, JSON_UNESCAPED_UNICODE) !!}</pre>
                    </div>
                </div>

                <!-- Transactions table -->
                <div class="card">
                    <div class="card-inner">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>تاریخ</th>
                                    <th>نوع</th>
                                    <th>مبلغ</th>
                                    <th>مانده</th>
                                    <th>روش پرداخت</th>
                                    <th>شماره مرجع</th>
                                    <th>شرح</th>
                                    <th>وضعیت</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($transactions) && $transactions->count())
                                    @foreach($transactions as $tx)
                                        <tr>
                                            <td>{{ ($transactions->currentPage()-1) * $transactions->perPage() + $loop->iteration }}</td>
                                            <td>
                                                @if($tx->date)
                                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($tx->date)->format('Y/m/d H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $tx->type }}</td>
                                            <td>{{ number_format($tx->amount) }}</td>
                                            <td class="{{ ($tx->running_balance ?? 0) > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ number_format($tx->running_balance ?? 0) }}
                                            </td>
                                            <td>{{ $tx->payment_way }}</td>
                                            <td>{{ $tx->tracking_number }}</td>
                                            <td>{{ $tx->notes }}</td>
                                            <td>{{ $tx->status }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">هیچ تراکنشی پیدا نشد.</td>
                                    </tr>
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">جمع واریزها:</td>
                                    <td class="fw-bold text-success">{{ number_format($inputs ?? 0) }}</td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">جمع برداشت‌ها:</td>
                                    <td class="fw-bold text-danger">{{ number_format($outputs ?? 0) }}</td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">مانده انتهای بازه:</td>
                                    <td class="fw-bold">{{ number_format($finalBalance ?? (($openingBalance ?? 0) + ($inputs ?? 0) - ($outputs ?? 0))) }}</td>
                                    <td colspan="5"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <p class="text-muted mb-0">نمایش {{ $transactions->firstItem() ?? 0 }} تا {{ $transactions->lastItem() ?? 0 }} از {{ $transactions->total() ?? 0 }}</p>
                            </div>
                            <div>
                                @if(isset($transactions))
                                    {{ $transactions->withQueryString()->links() }}
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @slot('script')
        {{-- Chart.js CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        <script>
            (function () {
                const pre = document.getElementById('chart-data-json');
                if (!pre) return;
                let data = [];
                try {
                    data = JSON.parse(pre.textContent || '[]');
                } catch (e) {
                    console.error('Invalid chart data JSON', e);
                    return;
                }

                // prepare labels and datasets
                const labels = data.map(d => d.label || d.date);
                const inputs = data.map(d => Number(d.input || 0));
                const outputs = data.map(d => Number(d.output || 0));

                // if no data, show a small placeholder message
                if (!labels.length) {
                    const chartWrap = document.getElementById('accountReportChart');
                    if (chartWrap) {
                        const ctxParent = chartWrap.parentElement;
                        const msg = document.createElement('div');
                        msg.className = 'text-center text-muted';
                        msg.style.padding = '40px 0';
                        msg.innerText = 'داده‌ای برای نمودار وجود ندارد.';
                        ctxParent.appendChild(msg);
                    }
                    return;
                }

                // create chart
                const ctx = document.getElementById('accountReportChart').getContext('2d');

                // maintain global reference to destroy if re-rendered (e.g., via ajax)
                if (window._accountReportChart instanceof Chart) {
                    window._accountReportChart.destroy();
                }

                window._accountReportChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'واریز (input)',
                                data: inputs,
                                borderColor: '#28a745',
                                backgroundColor: 'rgba(40,167,69,0.12)',
                                tension: 0.25,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                fill: true,
                            },
                            {
                                label: 'برداشت (output)',
                                data: outputs,
                                borderColor: '#dc3545',
                                backgroundColor: 'rgba(220,53,69,0.12)',
                                tension: 0.25,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: { boxWidth: 12, padding: 12 }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw ?? 0;
                                        return context.dataset.label + ': ' + value.toLocaleString() + ' تومان';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: { maxRotation: 0, autoSkip: true },
                                grid: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) { return Number(value).toLocaleString(); }
                                }
                            }
                        }
                    }
                });
            })();
        </script>

        {{-- persian datepicker assets if used elsewhere --}}
        <script src="/assets/js/persian-date.js"></script>
        <script src="/assets/js/persian-datepicker.js"></script>
    @endslot

    @slot('style')
        <link rel="stylesheet" href="/assets/css/persian-datepicker.css"/>
    @endslot

</x-admin.main>
