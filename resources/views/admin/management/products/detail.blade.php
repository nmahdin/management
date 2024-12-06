<x-admin.main title="جزئیات محصول">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">جزئیات محصول</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
{{--                                <p></p>--}}
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <!--   --------------- links --------------     -->
                                        <li>
                                            <a href="{{ route('product.edit' , $product->id) }}" class="dropdown-toggle btn btn-secondary " data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form13').submit();">
                                                <em class="icon ni ni-pen-fill"></em>
                                                {{--                                                <em class="icon ni ni-plus"></em>--}}
                                                <span class="fw-normal">
                                                    ویرایش محصول
                                                </span>
                                            </a>
                                            <form id="form13" action="{{ route('product.edit' , $product->id) }}" class="d-none"></form>
                                        </li>
                                        <li>
                                            <a href="{{ route('products.list') }}" class="dropdown-toggle btn btn-dark btn-dim" data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
{{--                                                <em class="icon ni ni-plus"></em>--}}
                                                <span class="fw-normal">
                                                    لیست محصولات
                                                </span>
                                            </a>
                                            <form id="form12" action="{{ route('products.list') }}" class="d-none"></form>
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
                @if(session('edited'))
                <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                    <em class="icon ni ni-check-circle"></em>
                    محصول "{{session('edited')}}" با موفقیت ویرایش شد.
                </div>
                @endif
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <div class="row pb-5">
                                <div class="col-lg-6">
                                    <div class="product-gallery me-xl-1 me-xxl-5">
                                        <div class="slider-init" id="sliderFor" data-slick='{"arrows": false, "fade": true, "asNavFor":"#sliderNav", "slidesToShow": 1, "slidesToScroll": 1}'>
                                            <div class="slider-item rounded">
                                                <img src="{{ $product->picture }}" class="rounded w-100" alt="" />
                                            </div>
                                        </div>
                                        <!-- .slider-init -->
                                        <div
                                            class="slider-init slider-nav"
                                            id="sliderNav"
                                            data-slick='{"arrows": false, "slidesToShow": 5, "slidesToScroll": 1, "asNavFor":"#sliderFor", "centerMode":true, "focusOnSelect": true,
                                "responsive":[ {"breakpoint": 1539,"settings":{"slidesToShow": 4}}, {"breakpoint": 768,"settings":{"slidesToShow": 3}}, {"breakpoint": 420,"settings":{"slidesToShow": 2}} ]
                            }'
                                        >
                                        </div>
                                        <!-- .slider-nav -->
                                    </div>
                                    <!-- .product-gallery -->
                                </div>
                                <!-- .col -->
                                <div class="col-lg-6">
                                    <div class="product-info mt-5 me-xxl-5">
                                        <h4 class="product-price text-primary"><span class="text-secondary">کد :</span>
                                            {{ $product->product_id }}</h4>
                                        <h2 class="product-title">{{ $product->name }}</h2>
                                        <!-- .product-rating -->
                                        <div class="product-excrept text-soft">
                                            <p class="lead">{{ $product->note }}</p>
                                        </div>
                                        <div class="product-meta">
                                            <ul class="d-flex g-3 gx-5">
                                                <li>
                                                    <div class="fs-14px text-muted">رنگ</div>
                                                    <div class="fs-16px fw-bold text-secondary">{{ $product->color }}</div>
                                                </li>
                                                <li>
                                                    <div class="fs-14px text-muted">دسته بندی</div>
                                                    <div class="fs-16px fw-bold text-secondary">{{ \App\Models\Category::find($product->category_id)->first()->name }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-meta">
                                            <ul class="d-flex g-3 gx-5">
                                                <li>
                                                    <div class="fs-14px text-muted">مالک محصول</div>
                                                    <div class="fs-16px fw-bold text-secondary">
                                                        @if($product->partner_id == -1)
                                                            مشترک
                                                        @else
                                                            {{ \App\Models\Partner::find($product->partner_id)->first()->name }}
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="fs-14px text-muted">وضعیت محصول</div>
                                                    <div class="fs-16px fw-bold text-secondary">{{ \App\Models\ProductStatus::find($product->status_id)->first()->name }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-meta">
                                            <ul class="d-flex g-3 gx-5">
                                                <li>
                                                    <div class="fs-14px text-muted">برچسب محصول</div>
                                                    <div class="fs-16px fw-bold text-secondary">{{ $product->label }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- .product-meta -->
                                        <div class="product-meta">
                                            <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">
                                                <li style="margin-top: 5px;">
                                                    <span class="text-4xl fw-normal bg-light" style="padding: 10px; border-radius: 7px;"><span>{{ number_format($product->total_price , 0, ',') }}</span>
                                                    </span>
                                                </li>
                                                <li>
                                                    <a href="{{ route('cart.add' , $product->id) }}" class="btn btn-primary"><span>افزودن به سبد خرید</span>
                                                        <em class="icon ni ni-cart-fill"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- .product-meta -->
                                    </div>
                                    <!-- .product-info -->
                                </div>
                                <!-- .col -->
                            </div>
                            <!-- .row -->

                            <!-- .row -->
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">عنوان</th>
                                    <th scope="col">مبلغ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>هزینه مواد اولیه</td>
                                    <td class="fs-19px">{{ number_format($product->price_materials , 0, ',') }} <span class="fw-normal fs-14px ">تومان</span></td>

                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>دسمزد</td>
                                    <td class="fs-19px">{{ number_format($product->salary , 0, ',') }} <span class="fw-normal fs-14px ">تومان</span></td>

                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>سود</td>
                                    <td class="fs-19px">{{ number_format($product->profit , 0, ',') }} <span class="fw-normal fs-14px ">تومان</span></td>

                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>سود مواد اولیه</td>
                                    <td class="fs-19px">{{ number_format($product->materials_profit , 0, ',') }} <span class="fw-normal fs-14px ">تومان</span></td>

                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>هزینه های دیگر</td>
                                    <td class="fs-19px">{{ number_format($product->additional_costs , 0, ',') }} <span class="fw-normal fs-14px ">تومان</span></td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- .card-preview -->
                </div>
                <!-- .nk-block -->
            </div>
        </div>
    </div>
    <x-admin.modal id="modalCreate" class="modal-body-md">در حال ایجاد محصول ...</x-admin.modal>
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
    @endslot

</x-admin.main>


