<x-admin.main title="ثبت تسویه / بدهی">
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <form action="{{ route('settlements.store') }}" method="post">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">شریک</label>
                                    <select name="partner_id" class="form-control" required>
                                        <option value="">انتخاب کنید</option>
                                        @foreach($partners as $partner)
                                            <option value="{{ $partner->id }}"
                                                {{ $selectedPartner == $partner->id ? 'selected' : '' }}>
                                                {{ $partner->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">مبلغ</label>
                                    <input type="number" name="amount" class="form-control" required
                                           value="{{ $selectedAmount }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">نوع</label>
                                    <select name="type" class="form-control" required>
                                        <option value="debt">بدهی (طلب شریک)</option>
                                        <option value="settlement" {{ old('type') == 'settlement' ? 'selected' : '' }}>تسویه (پرداخت)</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">روش پرداخت</label>
                                    <input type="text" name="method" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">شماره پیگیری</label>
                                    <input type="text" name="reference" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">سفارش (اختیاری)</label>
                                    <select name="order_id" class="form-control">
                                        <option value="">ندارد</option>
                                        @foreach($orders as $order)
                                            <option value="{{ $order->id }}"
                                                {{ $selectedOrder == $order->id ? 'selected' : '' }}>
                                                #{{ $order->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label">توضیح</label>
                                    <input type="text" name="description" class="form-control">
                                </div>
                                <div class="col-md-12 text-end">
                                    <button class="btn btn-success" type="submit">ثبت</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.main>
