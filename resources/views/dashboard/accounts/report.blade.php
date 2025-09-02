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
                                <a href="{{ route('accounts.report.download', ['account' => $account->id, 'format' => 'csv'] + request()->all()) }}" class="btn btn-outline-primary">دانلود CSV</a>
                                <a href="{{ route('accounts.report.download', ['account' => $account->id, 'format' => 'pdf'] + request()->all()) }}" class="btn btn-outline-secondary">دانلود PDF</a>
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
                        <form action="{{ route('accounts.report', ['id' => $account->id]) }}" method="GET" class="row g-3">
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
                                    <a href="{{ route('accounts.report', ['id' => $account->id]) }}" class="btn btn-outline-secondary">پاک‌سازی</a>
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

                <!-- Chart placeholder -->
                <div class="card mb-3">
                    <div class="card-inner">
                        <h6>نمودار وارده/خارجی (روزانه)</h6>
                        <div id="account-report-chart" style="height:300px;">
                            <pre style="display:none" id="chart-data-json">{!! json_encode($chartData ?? []) !!}</pre>
                        </div>
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
                                    <td class="fw-bold">{{ number_format($finalBalance ?? ($openingBalance ?? 0) + ($inputs ?? 0) - ($outputs ?? 0)) }}</td>
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
        <script src="/assets/js/persian-date.js"></script>
        <script src="/assets/js/persian-datepicker.js"></script>
        <script>
            (function () {
                const chartDataEl = document.getElementById('chart-data-json');
                if (!chartDataEl) return;
                const data = JSON.parse(chartDataEl.textContent || '[]');

                // placeholder for Chart.js integration
                // data format: [{date: '2025-01-01', input: 1000, output: 500}, ...]
                // you can initialize Chart.js here using data
                console.log('account report chart data', data);
            })();
        </script>
    @endslot

    @slot('style')
        <link rel="stylesheet" href="/assets/css/persian-datepicker.css"/>
    @endslot

</x-admin.main>
