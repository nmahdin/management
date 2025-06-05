<x-admin.main title="ویرایش تراکنش">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">ویرایش تراکنش #{{ $transaction->id }}</h3>
                            <div class="nk-block-des text-soft">
                                <p>ویرایش اطلاعات تراکنش</p>
                            </div>
                        </div>
                    </div>
                </div>

                <x-admin.templates.successAlert/>
                <x-admin.templates.warningAlert/>
                <x-admin.templates.dangerAlert/>

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="name">نام</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" value="{{ old('name', $transaction->name) }}">
                                                @error('name')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="type">نوع تراکنش</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2 @error('type') error @enderror" name="type" id="type" data-search="on">
                                                    <option value="input" @if(old('type', $transaction->type) == 'input') selected @endif>ورودی</option>
                                                    <option value="output" @if(old('type', $transaction->type) == 'output') selected @endif>خروجی</option>
                                                </select>
                                                @error('type')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="date">تاریخ</label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-calendar-alt"></em>
                                                </div>
                                                <input type="text" class="form-control persiandate @error('date') error @enderror" id="date" name="date" value="{{ old('date', App\helper\services\Custom::reDateP($transaction->date)) }}">
                                                @error('date')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="amount">مبلغ</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('amount') error @enderror" id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}">
                                                @error('amount')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="pay_id">پرداخت کننده</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2 @error('pay_id') error @enderror" name="pay_id" id="pay_id" data-search="on">
                                                    <option value="">انتخاب پرداخت کننده</option>
                                                    @foreach($customers as $customer)
                                                        <option value="customer-{{ $customer->id }}" @if(old('pay_id', $transaction->pay_id) == 'customer-' . $customer->id) selected @endif>مشتری: {{ $customer->name }}</option>
                                                    @endforeach
                                                    @foreach($sellers as $seller)
                                                        <option value="seller-{{ $seller->id }}" @if(old('pay_id', $transaction->pay_id) == 'seller-' . $seller->id) selected @endif>فروشنده: {{ $seller->name }}</option>
                                                    @endforeach
                                                    <option value="other" @if(strpos(old('pay_id', $transaction->pay_id), 'other-') === 0) selected @endif>متن دلخواه</option>
                                                </select>
                                                @error('pay_id')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                                @if(strpos(old('pay_id', $transaction->pay_id), 'other-') === 0)
                                                    <input type="text" class="form-control mt-2" name="pay_id_other" value="{{ substr(old('pay_id', $transaction->pay_id), 6) }}" placeholder="متن دلخواه">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="tracking_number">شماره پیگیری</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('tracking_number') error @enderror" id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $transaction->tracking_number) }}">
                                                @error('tracking_number')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        @if($accounts->count())
                                            <label class="form-label" for="account_payment_way">حساب مالی و روش پرداخت</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2 @error('account_payment_way') error @enderror" id="account_payment_way" name="account_payment_way">
                                                    <option value="">انتخاب حساب و روش پرداخت</option>
                                                    @foreach($accounts as $account)
                                                        @if(is_array(json_decode($account->payment_ways, true)))
                                                            @foreach(json_decode($account->payment_ways, true) as $payment_way)
                                                                <option value="{{ $account->id }}_{{ $payment_way }}" @if(old('account_payment_way', $transaction->account_id . '_' . $transaction->payment_way) == $account->id . '_' . $payment_way) selected @endif>
                                                                    {{ $account->label }} - {{ __('payment.' . $payment_way) }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('account_payment_way')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @else
                                            <label class="form-label">ابتدا حساب مالی اضافه کنید!</label>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="category">دسته بندی</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('category') error @enderror" id="category" name="category" value="{{ old('category', $transaction->category) }}">
                                                @error('category')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="label_id">برچسب تراکنش</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2 @error('label_id') error @enderror" name="label_id" id="label_id" data-search="on">
                                                    <option value="">انتخاب برچسب</option>
                                                    @foreach($transactionLabels as $label)
                                                        <option value="{{ $label->id }}" @if(old('label_id', $transaction->label_id) == $label->id) selected @endif>{{ $label->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('label_id')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">وضعیت</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-radio">
                                                        <input type="radio" class="custom-control-input" id="status_paid" name="status" value="paid" @if(old('status', $transaction->status) == 'paid') checked @endif>
                                                        <label class="custom-control-label" for="status_paid">پرداخت شده</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-radio">
                                                        <input type="radio" class="custom-control-input" id="status_unpaid" name="status" value="unpaid" @if(old('status', $transaction->status) == 'unpaid') checked @endif>
                                                        <label class="custom-control-label" for="status_unpaid">پرداخت نشده</label>
                                                    </div>
                                                </li>
                                            </ul>
                                            @error('status')
                                            <span class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">سفارش/خرید مرتبط</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2 @error('relation_id') error @enderror" name="relation_id" id="relation_id" data-search="on" data-placeholder="انتخاب سفارش یا خرید">
                                                    <option value="">انتخاب سفارش یا خرید</option>
                                                    @foreach($orders as $order)
                                                        <option value="order-{{ $order->id }}"
                                                                @if(old('relation_id', ($transaction->source_type == 'orders' && $transaction->source_id == $order->id) ? 'order-' . $order->id : null) == 'order' .'-' . $order->id) selected @endif>
                                                            سفارش #{{ $order->id }}
                                                        </option>
                                                    @endforeach
                                                    @foreach($purchases as $purchase)
                                                        <option value="purchase-{{ $purchase->id }}"
                                                                @if(old('relation_id', ($transaction->source_type == 'purchases' && $transaction->source_id == $purchase->id) ? 'purchase-' . $purchase->id : null) == 'purchase' .'-'. $purchase->id ) selected @endif>
                                                            خرید #{{ $purchase->id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('relation_id')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="file">فایل</label>
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input @error('file') error @enderror" id="file" name="file">
                                                    <label class="form-file-label" for="file">انتخاب فایل</label>
                                                </div>
                                                @error('file')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="notes">یادداشت ها</label>
                                            <textarea class="form-control form-control-sm @error('notes') error @enderror" name="notes" id="notes" placeholder="یادداشت ها">{{ old('notes', $transaction->notes) }}</textarea>
                                            @error('notes')
                                            <span class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary">ذخیره تغییرات</button>
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
        <script>
            $(document).ready(function() {
                $('.persiandate').persianDatepicker({
                    format: 'YYYY/MM/DD',
                    altField: '#date_alt',
                    observer: true,
                    initialValue: false,
                });

                $('#pay_id').change(function() {
                    if ($(this).val() === 'other') {
                        $(this).after('<input type="text" class="form-control mt-2" name="pay_id_other" placeholder="متن دلخواه">');
                    } else {
                        $(this).next('input[name="pay_id_other"]').remove();
                    }
                });
            });
        </script>
    @endslot

    @slot('style')
        <link rel="stylesheet" href="/assets/css/persian-datepicker.css" />
    @endslot

</x-admin.main>
