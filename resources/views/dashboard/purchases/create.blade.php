<x-admin.main title="افزودن خرید">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">افزودن خرید</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                {{--                                <p></p>--}}
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                        class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <!--   --------------- links --------------     -->
                                        <li>
                                            <a href="{{ route('purchases.list') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim" data-bs-toggle="modal"
                                               data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('list').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                {{--                                                <em class="icon ni ni-plus"></em>--}}
                                                <span class="fw-normal">
                                                    لیست خرید ها
                                                </span>
                                            </a>
                                            <form id="list" action="{{ route('purchases.list') }}"
                                                  class="d-none"></form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                    </div>
                    <!-- .nk-block-between -->
                </div>
                <!-- .nk-block-head -->
                @if(session('created'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        خرید "{{session('created')}}" با موفقیت ایجاد شد.
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-fill alert-danger alert-icon bg-danger-dim text-danger">
                        <em class="icon ni ni-info-fill"></em>
                        @foreach($errors->all() as $error)
                            <ul>
                                <li>{{ $error }}</li>
                            </ul>
                        @endforeach
                    </div>
                @endif
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">اطلاعات خرید</h5>
                            </div>
                            <form action="{{ route('purchases.create') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="code">کد کالا</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('code') error @enderror"
                                                       id="code" name="code" value="{{ old('code' , '') }}">
                                                @error('code')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="name">نام کالا</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') error @enderror"
                                                       id="name" name="name" value="{{ old('name' , '') }}">
                                                @error('name')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label" for="color">رنگ</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('color') error @enderror"
                                                       id="color" name="color" value="{{ old('color' , '') }}">
                                                @error('color')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label">دسته بندی</label>
                                            <div class="form-control-wrap">
                                                @if(\App\Models\PurchasesCategory::count() != 0)
                                                    <select
                                                        class="form-select js-select2 @error('category_id') error @enderror"
                                                        name="category_id" data-search="on">
                                                        @foreach(\App\Models\PurchasesCategory::all() as $category)
                                                            <option
                                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <p>ابتدا برای خرید ها دسته بندی اضافه کنید.</p>
                                                @endif

                                                @error('category_id')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="seller_id">فروشنده کالا</label>
                                            <div class="form-control-wrap">
                                                @if(\App\Models\Seller::count() != 0)
                                                    <select
                                                        class="form-select js-select2 @error('seller_id') error @enderror"
                                                        name="seller_id" id="seller_id" data-search="on">
                                                        <option value="-1">نا مشخص</option>
                                                        @foreach(\App\Models\Seller::all() as $seller)
                                                            <option
                                                                value="{{ $seller->id }}">{{ $seller->name }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <p>ابتدا برای خرید ها فروشنده اضافه کنید.</p>
                                                @endif

                                                @error('seller_id')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
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
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="amount">مقدار</label>
                                            <div class="form-control-wrap number-spinner-wrap">
                                                <button type="button"
                                                        class="btn btn-icon btn-outline-light number-spinner-btn number-minus"
                                                        data-number="minus"><em class="icon ni ni-minus"></em></button>
                                                <input type="text" class="form-control number-spinner" name="amount"
                                                       id="amount" value="{{ old('amount' , 1) }}">
                                                <button type="button"
                                                        class="btn btn-icon btn-outline-light number-spinner-btn number-plus"
                                                        data-number="plus"><em class="icon ni ni-plus"></em></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="unit">واحد</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('unit') error @enderror"
                                                       id="unit" name="unit" value="{{ old('unit' , '') }}">
                                                @error('unit')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="unit_price">قیمت واحد</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">تومان</span>
                                                </div>
                                                <input type="text"
                                                       class="form-control @error('unit_price') error @enderror"
                                                       id="unit_price" name="unit_price"
                                                       value="{{ old('unit_price' , '') }}">
                                                @error('unit_price')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="total_price">قیمت کل</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">تومان</span>
                                                </div>
                                                <input type="text"
                                                       class="form-control @error('total_price') error @enderror"
                                                       id="total_price" name="total_price"
                                                       value="{{ old('total_price' , '') }}">
                                                @error('total_price')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="customFileLabel">آپلود عکس یا فایل و ... برای
                                                پیوست کردن آن</label>
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file"
                                                           class="form-file-input @error('picture') error @enderror"
                                                           id="picture" name="picture">
                                                    <label class="form-file-label" for="picture">انتخاب فایل</label>
                                                    @error('picture')
                                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="notes">یادداشت خرید</label>
                                            <textarea class="form-control form-control-sm" name="notes" id="notes"
                                                      placeholder="یادداشت ، نکته یا یادآوری در مورد خرید">{{ old('notes' , '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary btn-dim"
                                                    data-bs-toggle="modal" data-bs-target="#modalCreate">ذخیره اطلاعات
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- .card-preview -->
                </div>
                <!-- .nk-block -->
            </div>
        </div>
    </div>
    <x-admin.modal id="modalCreate" class="modal-body-md">در حال ایجاد خرید جدید ...</x-admin.modal>
    <div class="modal fade zoom  modal-sm" tabindex="-1" id="modalZoom" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="spinner-border text-gray" style="margin-bottom: -12px; font-size: 10px;" role="status">
                    </span>
                    <span class="m-2">
                        درحال بارگذاری ...
                    </span>
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


