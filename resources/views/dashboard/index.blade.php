<x-admin.main title="داشبورد مدیریت">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">

                {{-- کارت‌های خلاصه --}}
                <div class="row g-3">
                    <div class="col-md-2"><x-dashboard.stat-card title="شریک‌ها" :value="$partnersCount" icon="ni-users" color="primary"/></div>
                    <div class="col-md-2"><x-dashboard.stat-card title="محصولات" :value="$productsCount" icon="ni-box" color="success"/></div>
                    <div class="col-md-2"><x-dashboard.stat-card title="موجودی کل" :value="$totalInventory" icon="ni-archive" color="info"/></div>
                    <div class="col-md-2"><x-dashboard.stat-card title="بستانکاری" :value="$totalCredit" icon="ni-wallet" color="warning"/></div>
                    <div class="col-md-2"><x-dashboard.stat-card title="سود کل" :value="$totalProfit" icon="ni-coins" color="danger"/></div>
                    <div class="col-md-2"><x-dashboard.stat-card title="تسویه‌ها" :value="$totalSettled" icon="ni-check-circle" color="secondary"/></div>
                </div>

                {{-- نمودارها --}}
                <div class="row g-3 mt-4">
                    <div class="col-md-8">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6>نمودار سود ماهانه</h6>
                                <canvas id="chartProfit"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6>سهم شریک‌ها از سود</h6>
                                <canvas id="chartPartners"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- آخرین تراکنش‌ها --}}
                <div class="card card-bordered mt-4">
                    <div class="card-inner">
                        <h6>آخرین تراکنش‌های مالی</h6>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>تاریخ</th>
                                <th>شریک</th>
                                <th>نوع</th>
                                <th>مبلغ</th>
                                <th>توضیح</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentTransactions as $tx)
                                <tr>
                                    <td>{{ jdate($tx->date)->format('Y/m/d') }}</td>
                                    <td>{{ $tx->partner->name ?? '-' }}</td>
                                    <td>{{ $tx->type == 'credit' ? 'بستانکاری' : 'تسویه' }}</td>
                                    <td>{{ number_format($tx->amount) }}</td>
                                    <td>{{ $tx->description }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @slot('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // داده‌های نمودارها را از کنترلر به صورت json ارسال کنید
            new Chart(document.getElementById('chartProfit'), {
                type: 'line',
                data: @json($chartProfitData),
                options: { /* تنظیمات */ }
            });
            new Chart(document.getElementById('chartPartners'), {
                type: 'doughnut',
                data: @json($chartPartnersData),
                options: { /* تنظیمات */ }
            });
        </script>
    @endslot

</x-admin.main>
