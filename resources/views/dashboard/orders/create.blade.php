<x-admin.main title="افزودن سفارش جدید">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">افزودن سفارش جدید</h3>
                            <div class="nk-block-des text-soft">
                                <p>لطفاً اطلاعات سفارش جدید را وارد کنید.</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="{{ route('orders.list') }}" class="btn btn-dark btn-dim">
                                                <em class="icon ni ni-arrow-left"></em>
                                                <span class="fw-normal">بازگشت به لیست سفارشات</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <form action="{{ route('orders.store') }}" method="post">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="title">عنوان سفارش</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('title') error @enderror" id="title" name="title" value="{{ old('title') }}">
                                                @error('title')
                                                    <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_id">مشتری</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" id="customer_id" name="customer_id">
                                                    @foreach(\App\Models\Customer::all() as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="type_id">نوع سفارش</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" id="type_id" name="type_id">
                                                    @foreach(\App\Models\Type::all() as $type)
                                                        <option value="{{ $type->id }}">{{ $type->label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price">مبلغ (تومان)</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('price') error @enderror" id="price" name="price" value="{{ old('price') }}">
                                                @error('price')
                                                    <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="notes">یادداشت</label>
                                            <textarea class="form-control form-control-sm" name="notes" id="notes" placeholder="یادداشت یا نکته‌ای در مورد سفارش">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary btn-dim">ثبت سفارش</button>
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
    @endslot

</x-admin.main>
