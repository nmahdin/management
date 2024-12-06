<x-admin.main title="افزودن محصول">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">افزودن محصول</h3>
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
                @if(session('created'))
                <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                    <em class="icon ni ni-check-circle"></em>
                    محصول "{{session('created')}}" با موفقیت ایجاد شد.
                </div>
                @endif
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">اطلاعات محصول</h5>
                            </div>
                            <form action="{{ route('product.create') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="product_id">کد محصول</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('product_id') error @enderror" id="product_id" name="product_id" value="{{ old('product_id' , '') }}">
                                                @error('product_id')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="name">نام محصول</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" value="{{ old('name' , '') }}">
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
                                                <input type="text" class="form-control @error('color') error @enderror" id="color" name="color" value="{{ old('color' , '') }}">
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
                                                <select class="form-select js-select2" name="category_id"  data-search="on">
                                                    @foreach(\App\Models\Category::where('deleted' , 0)->get() as $category)
                                                        <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">مالک محصول</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" name="partner_id"  data-search="on">
                                                    <option value="-1" >مشترک</option>
                                                    @foreach(\App\Models\Partner::where('deleted' , 0)->get() as $partner)
                                                        <option value="{{ $partner->id }}" >{{ $partner->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">وضعیت محصول</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" name="status_id"  data-search="on">
                                                    @foreach(\App\Models\ProductStatus::where('deleted' , 0)->get() as $status)
                                                        <option value="{{ $status->id }}" >{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="label">برچسب</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('label') error @enderror" id="label" name="label" value="{{ old('label' , '') }}">
                                                @error('label')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="price_materials">قیمت مواد اولیه</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">تومان</span>
                                                </div>
                                                <input type="text" class="form-control @error('price_materials') error @enderror" id="price_materials" name="price_materials" value="{{ old('price_materials' , '') }}">
                                                @error('price_materials')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="salary">دسمزد</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">تومان</span>
                                                </div>
                                                <input type="text" class="form-control @error('salary') error @enderror" id="salary" name="salary" value="{{ old('salary' , '') }}">
                                                @error('salary')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="profit">سود</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">تومان</span>
                                                </div>
                                                <input type="text" class="form-control @error('profit') error @enderror" id="profit" name="profit" value="{{ old('profit' , '') }}">
                                                @error('profit')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="materials_profit">سود مواد اولیه</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">تومان</span>
                                                </div>
                                                <input type="text" class="form-control @error('materials_profit') error @enderror" id="materials_profit" name="materials_profit" value="{{ old('materials_profit' , '') }}">
                                                @error('materials_profit')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="additional_costs">هزینه های دیگر</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">تومان</span>
                                                </div>
                                                <input type="text" class="form-control @error('additional_costs') error @enderror" id="additional_costs" name="additional_costs" value="{{ old('additional_costs' , '') }}">
                                                @error('additional_costs')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="inventory">موجودی اولیه</label>
                                            <div class="form-control-wrap number-spinner-wrap">
                                                <button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                                <input type="number" class="form-control number-spinner @error('inventory') error @enderror" name="inventory" id="inventory" value="{{ old('inventory' , 0) }}">
                                                <button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                                @error('inventory')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="customFileLabel">آپلود تصویر محصول</label>
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input @error('picture') error @enderror" id="picture" name="picture">
                                                    @error('picture')
                                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                    @enderror
                                                    <label class="form-file-label" for="picture">انتخاب فایل</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="note">یادداشت</label>
                                            <textarea class="form-control form-control-sm" name="note" id="note" placeholder="یادداشت ، نکته یا یادآوری در مورد محصول">{{ old('notes' , '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary btn-dim"  data-bs-toggle="modal" data-bs-target="#modalCreate">ذخیره اطلاعات</button>
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


