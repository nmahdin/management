<x-admin.main title="لیست سبد خرید">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">لیست سبد خرید</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                @if($n !== 0)
                                    <p>در مجموج {{ $n }} محصول در سبد خرید وجود دارد.</p>
                                @endif
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
                                            <a href="{{ route('products.list') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim " data-bs-toggle="modal"
                                               data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                                <em class="icon ni ni-plus"></em>
                                                <span class="fw-normal">
                                                    افزودن محصول
                                                </span>
                                                <form id="form12" action="{{ route('products.list') }}"
                                                      class="d-none"></form>
                                            </a>
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
                @if(session('deleted'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        محصول "{{session('deleted')}}" با موفقیت
                        از سبد خرید حذف شد.
                    </div>
                @endif
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ محصولی در سبد خرید وجود ندارد!
                    </div>
                @endif
                @if($n !== 0)
                    <form action="{{ route('cart.enter') }}" method="post" id="cart">
                        <div class="nk-block nk-block-lg">
                            <div class="card card-preview">
                                <div class="card-inner">
                                    @php
                                        $total = \App\helper\Cart\Cart::all()->sum(function ($cart){
                                            return $cart['price'] * $cart['qnty'];
                                        });
                                    @endphp

                                    <div class="row gy-3">
                                        <div class="col-md-12">

                                            <table class="table">
                                                <thead class="table-light">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">نام محصول</th>
                                                    <th scope="col">قیمت محصول</th>
                                                    <th scope="col">تعداد</th>
                                                    <th scope="col">مبلغ فروش</th>
                                                    <th scope="col">اقدام</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(App\helper\Cart\Cart::all() as $cart)
                                                    @php
                                                        $product = $cart['Product'];
                                                    @endphp
                                                    <tr style="padding: 10px;">
                                                        <th scope="row">{{$product->id }}</th>
                                                        <td>{{ $product->name }} - رنگ: {{ $product->color }}</td>
                                                        <td>{{ number_format("$product->total_price") }}</td>
                                                        <td>{{ $cart['qnty'] }}</td>
                                                        <td><input type="text"
                                                                   value="{{ old($product->id , $product->total_price*$cart['qnty']) }}"
                                                                   class="form-control" id="{{$product->id}}"
                                                                   name="{{$product->id}}"></td>
                                                        <td>
                                                            <a href="#"
                                                               onclick="event.preventDefault(); document.getElementById('delete_pro{{$cart['id']}}').submit();"
                                                               class="btn btn-trigger btn-icon">
                                                                <em class="icon ni ni-trash-fill"></em>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- .col -->
                                    </div>
                                </div>
                            </div>
                            <div class="card card-preview">
                                <div class="card-inner">


                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                @if(\App\Models\Type::count() != 0)
                                                    <label class="form-label" for="type_id">دسته بندی فروش</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-select js-select2" id="type_id"
                                                                name="type_id">
                                                            @foreach(\App\Models\Type::all() as $type)
                                                                <option
                                                                    value="{{ $type->id }}">{{ $type->label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <p>ابتدا برای فاکتور ها دسته فروش اضافه کنید.</p>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="date">تاریخ</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-right">
                                                        <em class="icon ni ni-calendar-alt"></em>
                                                    </div>
                                                    <input type="text" name="date" id="date" value="{{ old('date' , '') }}" class="form-control persiandate @error('date') error @enderror" />
                                                    @error('date')
                                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-note">فرمت تاریخ <code>روز/ماه/سال</code></div>
                                            </div>
                                        </div>


                                        <break></break>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="customer"
                                                           id="new_customer" required="">
                                                    <label class="custom-control-label" for="new_customer">ایجاد مشتری
                                                        جدید</label>
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">نام و نام خانوادگی</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" value="{{ old('name' , '') }}"
                                                                   class="form-control @error('name') error @enderror"
                                                                   id="name"
                                                                   name="name">
                                                            @error('name')
                                                            <span id="fv-full-name-error"
                                                                  class="invalid">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="number">شماره موبایل</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" value="{{ old('number' , '') }}"
                                                                   class="form-control @error('number') error @enderror"
                                                                   id="number"
                                                                   name="number">
                                                            @error('number')
                                                            <span id="fv-full-name-error"
                                                                  class="invalid">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="city">شهر</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" value="{{ old('city' , '') }}"
                                                                   class="form-control @error('city') error @enderror"
                                                                   id="city"
                                                                   name="city">
                                                            @error('city')
                                                            <span id="fv-full-name-error"
                                                                  class="invalid">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="birthday">تاریخ تولد</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" value="{{ old('birthday' , '') }}"
                                                                   class="form-control @error('birthday') error @enderror"
                                                                   id="birthday" name="birthday">
                                                            @error('birthday')
                                                            <span id="fv-full-name-error"
                                                                  class="invalid">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="gender">جنسیت</label>
                                                        <div class="form-control-wrap">
                                                            <ul class="custom-control-group g-3 align-center">
                                                                <li>
                                                                    <div
                                                                        class="custom-control custom-control-lg custom-radio checked">
                                                                        <input type="radio"
                                                                               class="custom-control-input @error('gender') error @enderror"
                                                                               name="gender" id="female" value="female">
                                                                        <label class="custom-control-label"
                                                                               for="female">خانم</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div
                                                                        class="custom-control custom-control-lg custom-radio checked">
                                                                        <input type="radio" class="custom-control-input"
                                                                               id="male"
                                                                               name="gender" value="male">
                                                                        <label class="custom-control-label" for="male">آقا</label>
                                                                    </div>
                                                                    @error('gender')
                                                                    <span id="fv-full-name-error"
                                                                          class="invalid">{{$message}}</span>
                                                                    @enderror
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(\App\Models\CustomerCategory::count() != 0)
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="category_id">دسته
                                                                بندی</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-select js-select2" id="category_id"
                                                                        name="category_id">
                                                                    @foreach(\App\Models\CustomerCategory::all() as $category)
                                                                        <option
                                                                            value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <p>ابتدا از بخش تنظیمات -> بخش دسته بندی مشتریان، یک دسته
                                                                بندی اضافه کنید</p>
                                                        </div>
                                                    </div>

                                                @endif

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address">آدرس</label>
                                                        <div class="form-control-wrap">
                                                <textarea
                                                    class="form-control form-control-sm @error('address') error @enderror"
                                                    value="{{ old('address' , '') }}" name="address" id="address"
                                                    placeholder="خیابان شریعتی، خیابان دولت، کوچه ... ، پلاک ... ، واحد ..."></textarea>
                                                            @error('address')
                                                            <span id="fv-full-name-error"
                                                                  class="invalid">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label ">راه های ارتباطی ارتباط</label>
                                                        <ul class="custom-control-group g-3 align-center">
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-checkbox">
                                                                    <input type="checkbox" value="phone"
                                                                           class="custom-control-input @error('com_ways') error @enderror"
                                                                           id="phone" name="com_ways[]">
                                                                    <label class="custom-control-label" for="phone">تماس
                                                                        تلفنی</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-checkbox">
                                                                    <input type="checkbox" value="telegram"
                                                                           class="custom-control-input" id="telegram"
                                                                           name="com_ways[]">
                                                                    <label class="custom-control-label"
                                                                           for="telegram">تلگرام</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-checkbox">
                                                                    <input type="checkbox" value="bale"
                                                                           class="custom-control-input"
                                                                           id="bale" name="com_ways[]">
                                                                    <label class="custom-control-label"
                                                                           for="bale">بله</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-checkbox">
                                                                    <input type="checkbox" value="instagram"
                                                                           class="custom-control-input" id="instagram"
                                                                           name="com_ways[]">
                                                                    <label class="custom-control-label"
                                                                           for="instagram">اینستاگرام</label>
                                                                    @error('com_ways')
                                                                    <span id="fv-full-name-error"
                                                                          class="invalid">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div
                                                                    class="custom-control custom-control-sm custom-checkbox">
                                                                    <input type="checkbox" value="eitaa"
                                                                           class="custom-control-input" id="eitaa"
                                                                           name="com_ways[]">
                                                                    <label class="custom-control-label"
                                                                           for="eitaa">ایتا</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="notes">یادداشت</label>
                                                        <textarea class="form-control form-control-sm" name="notes"
                                                                  id="notes"
                                                                  placeholder="یادداشت یا نکته یا یادآوری در مورد مشتری"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <break></break>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input type="radio" class="custom-control-input" name="customer"
                                                       id="select_customer" required="">
                                                <label class="custom-control-label" for="select_customer"> انتخاب
                                                    مشتری</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" name="customer_id"
                                                        data-search="on">
                                                    <option value="0">جست و جوی مشتری</option>
                                                    @foreach(\App\Models\Customer::all() as $customer)
                                                        <option
                                                            value="{{ $customer->id }}">{{ $customer->name }}
                                                            - {{ $customer->number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" name="action" value="pay" class="btn btn-dim btn-outline-primary btn-lg fw-normal ">
                                                        ثبت سفارش و پرداخت
                                                    </button>
                                                    <button type="submit" name="action" value="no_pay" class="btn btn-dim  btn-outline-secondary btn-lg fw-normal" style="margin-right: 10px">
                                                        ثبت سفارش بدون پرداخت
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

{{--                                        <div class="modal fade zoom" tabindex="-1" id="modalCart" aria-hidden="true"--}}
{{--                                             style="display: none;">--}}
{{--                                            <div class="modal-dialog" role="document">--}}
{{--                                                <div class="modal-content">--}}
{{--                                                    <div class="modal-header">--}}
{{--                                                        <h5 class="modal-title">انتخاب روش پرداخت</h5>--}}
{{--                                                        <a href="#" class="close" data-bs-dismiss="modal"--}}
{{--                                                           aria-label="بستن">--}}
{{--                                                            <em class="icon ni ni-cross"></em>--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-body">--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            @foreach(\App\Models\Accounts::all() as $account)--}}


{{--                                                                    <div class="custom-control custom-control-lg custom-radio">--}}
{{--                                                                        <input type="radio" class="custom-control-input" name="payments" VALUE="{{ $account->id }}" id="pay{{ $account->id }}">--}}
{{--                                                                        <label class="custom-control-label" for="pay{{ $account->id }}">{{ $account->payment_label }}</label>--}}
{{--                                                                    </div>--}}

{{--                                                                    <input type="radio" id="{{ $account->id }}"--}}
{{--                                                                           value="{{ $account->id }}" name="payments"--}}
{{--                                                                           class="custom-control-input">--}}
{{--                                                                    <label class="custom-control-label"--}}
{{--                                                                           for="{{ $account->id }}">{{ $account->payment_label }}</label>--}}

{{--                                                                <br>--}}
{{--                                                            @endforeach--}}

{{--                                                        </div>--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <button type="submit"--}}
{{--                                                                    class="btn btn-lg btn-primary btn-dim">ثبت سفارش--}}
{{--                                                            </button>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>


                                </div>
                            </div>
                            <!-- .card-preview -->
                        </div>
                    </form>
                    <form id="delete_pro{{ $cart['id'] }}" method="post"
                          action="{{ route('cart.delete' ,  $cart['id']) }}"
                          class="d-none">@csrf @method('delete')</form>
                @endif

                <!-- .nk-block -->
            </div>
        </div>
    </div>
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
    <x-admin.modal id="modalTrash" class="modal-body-md">در حال رفتن به صفحه محصولات حذف شده ...</x-admin.modal>


    @slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
        <script src="/assets/js/persian-date.js"></script>
        <script src="/assets/js/persian-datepicker.js"></script>
    @endslot

    @slot('style')
        <link rel="stylesheet" href="/assets/css/persian-datepicker.css" />
    @endslot

</x-admin.main>


