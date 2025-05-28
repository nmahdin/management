<x-admin.main title="افزودن پرداخت جدید">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">پرداخت مبلغ برای سفارش</h3>
                        </div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-fill alert-danger alert-icon bg-danger-dim text-danger">
                        <em class="icon ni ni-check-circle"></em>
                        پرداخت ثبت نشد!
                    </div>
                @endif



                @if(session('success'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">اطلاعات پرداخت</h5>
                            </div>
                            <form action="{{ route('payments.create') }}" method="post">
                                @csrf
                                <div class="row g-4">
                                    @if(isset($orders))
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="order_id">سفارش مربوطه</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" id="order_id"
                                                            name="order_id">
                                                        @foreach($orders as $order)
                                                            <option value="{{ $order->id }}">سفارش
                                                                #{{ $order->id }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('order_id')
                                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="order_id">سفارش مربوطه</label>
                                                <input type="text" name="order_id" id="order_id" class="form-control"
                                                       value="{{ $order->id }}" readonly>
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($amount))
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="amount">مبلغ پرداختی (تومان)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" value="{{ $amount }}"
                                                           class="form-control @error('amount') error @enderror"
                                                           id="amount"
                                                           name="amount">
                                                    @error('amount')
                                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="amount">مبلغ پرداختی (تومان)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" value="{{ old('amount' , '') }}"
                                                           class="form-control @error('amount') error @enderror"
                                                           id="amount"
                                                           name="amount">
                                                    @error('amount')
                                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="tracking_number">شماره پیگیری</label>
                                            <div class="form-control-wrap">
                                                <input type="number" value="{{ old('tracking_number' , '') }}"
                                                       class="form-control @error('tracking_number') error @enderror"
                                                       id="tracking_number"
                                                       name="tracking_number">
                                                @error('tracking_number')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="date">تاریخ</label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-calendar-alt"></em>
                                                </div>
                                                <input type="text" name="date" id="date" value="{{ old('date' , '') }}"
                                                       class="form-control persiandate @error('date') error @enderror"/>
                                                @error('date')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="form-note">فرمت تاریخ <code>روز/ماه/سال</code></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            @if($accounts->count())
                                                <label class="form-label" for="account_payment_way">حساب مالی و روش پرداخت</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" id="account_payment_way" name="account_payment_way">
                                                        @foreach($accounts as $account)
                                                            @foreach(json_decode($account->payment_ways, true) as $payment_way)
                                                                <option value="{{ $account->id }}_{{ $payment_way }}">
                                                                    {{ $account->label }} - {{ __('payment.' . $payment_way) }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                    @error('account_payment_way')
                                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            @else
                                                <label class="form-label">ابتدا حساب مالی اضافه کنید!</label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="status">وضعیت</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" id="status" name="status">
                                                    <option value="paid">پرداخت شده</option>
                                                    <option value="unpaid">پرداخت نشده</option>
                                                </select>
                                                @error('status')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            @if(\App\Models\TransactionLabel::count())
                                                <label class="form-label" for="label_id">برچسب تراکنش</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" id="label_id" name="label_id">
                                                        @foreach(\App\Models\TransactionLabel::all() as $label)
                                                            <option value="{{ $label->id }}">{{ $label->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('label_id')
                                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            @else
                                                <label class="form-label">ابتدا برچسب تراکنش اضافه کنید!</label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="note">یادداشت</label>
                                            <textarea class="form-control form-control-sm" name="note" id="note"
                                                      placeholder="یادداشت یا نکته یا یادآوری در مورد مشتری">{{ old('note' , '') }}</textarea>
                                            @error('note')
                                            <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between">
                                                <button type="submit" class="btn btn-lg btn-primary btn-dim fw-normal">
                                                    پرداخت سفارش
                                                </button>
                                                <a href="{{ route('cart.list') }}"
                                                   class="btn btn-lg btn-danger btn-dim fw-normal">
                                                    لغو پرداخت
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
        <script src="/assets/js/persian-date.js"></script>
        <script src="/assets/js/persian-datepicker.js"></script>
    @endslot

    @slot('style')
        <link rel="stylesheet" href="/assets/css/persian-datepicker.css"/>
    @endslot


</x-admin.main>
