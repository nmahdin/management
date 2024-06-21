<x-admin.main title="لیست محصولات">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">لیست محصولات</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                @if($n !== 0)
                                    <p>در مجموج {{ $n }} محصول وجود دارد.</p>
                                @endif
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
                                            <a href="{{ route('product.create') }}" class="dropdown-toggle btn btn-dark btn-dim " data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                                <em class="icon ni ni-plus"></em>
                                                <span>
                                                    افزودن محصول
                                                </span>
                                            </a>
                                            <form id="form12" action="{{ route('product.create') }}" class="d-none"></form>
                                        </li>
                                        <li>
                                            <a href="{{ route('products.trash') }}" class="dropdown-toggle btn btn-light btn-dim" data-bs-toggle="modal" data-bs-target="#modalTrash"
                                               onclick="event.preventDefault(); document.getElementById('form13').submit();">
                                                <em class="icon ni ni-trash"></em>
                                                <span>
                                                    سطل زباله
                                                </span>
                                            </a>
                                            <form id="form13" action="{{ route('products.trash') }}" class="d-none"></form>
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
                    محصول "{{session('deleted')}}" با موفقیت به
                    <a href="{{ route('products.trash') }}" class="text-success" data-bs-toggle="modal" data-bs-target="#modalTrash"
                       onclick="event.preventDefault(); document.getElementById('form13').submit();">
                        <u>سطل زباله</u>
                    </a>
                    منتقل شد.
                </div>
                @endif
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ محصولی وجود ندارد!
                    </div>
                @endif
                @if($n !== 0)
                    <div class="nk-block nk-block-lg">
                        <div class="card card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                    <thead>
                                    <tr class="nk-tb-item nk-tb-head">
                                        <th class="nk-tb-col nk-tb-col-check">
                                        <span>
                                            انتخاب
                                        </span>
                                        </th>
                                        <th class="nk-tb-col"><span class="">کد محصول</span></th>
                                        <th class="nk-tb-col tb-col-lg"><span class="">نام محصول</span></th>
                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">دسته بندی</span></th>
                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">قیمت محصول</span></th>
                                        <th class="nk-tb-col tb-col-sm"><span class="sub-text">موجودی</span></th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr class="nk-tb-item">
                                            <td class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="s{{ $product->id }}" />
                                                    <label class="custom-control-label" for="s{{ $product->id }}"></label>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-sm" data-order="35040.34">
                                                <span class="fw-light"><a href="{{ route('product.detail' , ['product' => $product]) }}">{{ $product->product_id }}</a></span>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead"><a href="{{ route('product.detail' , ['product' => $product]) }}">{{ $product->name }}</a><span class="dot dot-success d-md-none ms-1"></span></span>
                                                        <span>{{ $product->color }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-sm">
                                                <span class="badge badge-dim bg-dark fw-light">{{ $product->category->label ?? 'بدون دسته بندی' }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="badge badge-dim bg-info badge-sm" style="font-size: 15px; border-radius: 7px">{{ $product->total_price }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-sm">
                                                <span>{{ $product->inventory }}</span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li class="nk-tb-action-hidden">
                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="ویرایش">
                                                            <em class="icon ni ni-edit-alt-fill"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action-hidden">
                                                        <a href="{{ route('product.delete' , ['product' => $product->id]) }}" onclick="event.preventDefault(); document.getElementById('delete_pro{{$product->id}}').submit();"
                                                           class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="حذف">
                                                            <em class="icon ni ni-trash-fill"></em>
                                                        </a>
                                                        <form id="delete_pro{{$product->id}}" method="post" action="{{ route('product.delete' , ['product' => $product->id]) }}" class="d-none">@csrf @method('delete')</form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- .nk-tb-item  -->
                                    </tbody>
                                </table>
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
    @endslot

</x-admin.main>


