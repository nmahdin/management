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
                                                <span>
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
                                                <th scope="col">اقدام</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(App\helper\Cart\Cart::all() as $cart)
                                                @php
                                                    $product = $cart['Product'];
                                                @endphp
                                                <tr>
                                                    <th scope="row">{{$product->id }}</th>
                                                    <td>{{ $product->name }} - رنگ: {{ $product->color }}</td>
                                                    <td>{{ number_format("$product->total_price") }}</td>
                                                    <td>{{ $cart['qnty'] }}</td>
                                                    <td>
                                                        <a href="#"
                                                           onclick="event.preventDefault(); document.getElementById('delete_pro{{$cart['id']}}').submit();"
                                                           class="btn btn-trigger btn-icon">
                                                            <em class="icon ni ni-trash-fill"></em>
                                                        </a>
                                                        <form id="delete_pro{{ $cart['id'] }}" method="post"
                                                              action="{{ route('cart.delete' ,  $cart['id']) }}"
                                                              class="d-none">@csrf @method('delete')</form>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- .col -->
                                </div>
                                <form action="{{ route('cart.enter') }}" method="post" id="cart">
                                    @csrf
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price">مبلغ قابل پرداخت سبد خرید:
                                                [{{ number_format($total) }}]</label>
                                            <div class="form-control-wrap">
                                                <input type="text" data-msg="الزامی"
                                                       class="form-control form-control-lg required" id="price"
                                                       value="{{ $total }}" name="price" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="type_id">دسته بندی فروش</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" id="type_id" name="type_id">
                                                    @foreach(\App\Models\Type::all() as $type)
                                                        <option
                                                            value="{{ $type->id }}">{{ $type->label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">ایجاد مشتری</label>
                                        <div class="row g-4">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="name">نام و نام
                                                        خانوادگی</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text"
                                                               class="form-control @error('name') error @enderror"
                                                               id="name" name="name">
                                                        @error('name')
                                                        <span id="fv-full-name-error"
                                                              class="invalid">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="number">شماره
                                                        موبایل</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text"
                                                               class="form-control @error('number') error @enderror"
                                                               id="number" name="number">
                                                        @error('number')
                                                        <span id="fv-full-name-error"
                                                              class="invalid">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="notes">یادداشت</label>
                                                    <textarea class="form-control form-control-sm"
                                                              name="notes" id="notes"
                                                              placeholder="یادداشت یا نکته یا یادآوری در مورد مشتری"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" name="customer_id"
                                                    data-search="on">
                                                <option value="0">جست و جوی مشتری</option >
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
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCart"> ثبت و ادامه</button>
                                        </div>
                                    </div>

                                    <div class="modal fade zoom" tabindex="-1" id="modalCart" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">انتخاب روش پرداخت</h5>
                                                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="بستن">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        @foreach(\App\Models\Accounts::all() as $account)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="{{ $account->id }}" value="{{ $account->id }}" name="payments" class="custom-control-input">
                                                                <label class="custom-control-label" for="{{ $account->id }}" >{{ $account->payment_label }}</label>
                                                            </div>
                                                            <br>
                                                        @endforeach

                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lg btn-primary btn-dim">ثبت سفارش</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!-- .card-preview -->
                    </div>
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

</x-admin.main>


