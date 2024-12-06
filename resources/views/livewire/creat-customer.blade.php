<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <!--   --------------- title --------------     -->
                <h3 class="nk-block-title page-title">افزودن مشتری</h3>
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
                                <a href="{{ route('customers.list') }}" class="dropdown-toggle btn btn-dark btn-dim" data-bs-toggle="modal" data-bs-target="#modalZoom"
                                   onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                    <em class="icon ni ni-forward-ios"></em>
                                    {{--                                                <em class="icon ni ni-plus"></em>--}}
                                    <span>
                                                    لیست مشتریان
                                                </span>
                                </a>
                                <form id="form12" action="{{ route('customers.list') }}" class="d-none"></form>
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
    <!-- alert -->
    @if(session('created'))
        <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
            <em class="icon ni ni-check-circle"></em>
            مشتری "{{session('created')}}" با موفقیت ایجاد شد.
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-fill alert-danger alert-icon bg-danger-dim text-danger">
            <em class="icon ni ni-check-circle"></em>
            مشتری ایجاد نشد!
        </div>
    @endif
    <div class="nk-block nk-block-lg">
        <div class="card card-preview">
            <div class="card-inner">
                <div class="card-head">
                    <h5 class="card-title">اطلاعات مشتری</h5>
                </div>
                <form wire:submit="save">
                    @csrf
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="name">نام و نام خانوادگی</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('name') error @enderror" id="name"  wire:model="name">
                                    @error('name')
                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="number">شماره موبایل</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('number') error @enderror" id="number" wire:model="number">
                                    @error('number')
                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="city">شهر</label>
                                <div class="form-control-wrap">
                                    <input type="text" value="تهران" class="form-control @error('city') error @enderror" id="city" wire:model="city">
                                    @error('city')
                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="birthday">تاریخ تولد</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('birthday') error @enderror" id="birthday" wire:model="birthday">
                                    @error('birthday')
                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="address">آدرس</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-sm @error('address') error @enderror" wire:model="address" id="address" placeholder="خیابان شریعتی، خیابان دولت، کوچه ... ، پلاک ... ، واحد ..."></textarea>
                                    @error('address')
                                    <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label ">راه های ارتباطی ارتباط</label>
                                <ul class="custom-control-group g-3 align-center">
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" value="phone" class="custom-control-input @error('com_ways') error @enderror" id="phone" wire:model="com_ways">
                                            <label class="custom-control-label" for="phone">تماس تلفی</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" value="telegram" class="custom-control-input" id="telegram"  wire:model="com_ways">
                                            <label class="custom-control-label" for="telegram">تلگرام</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" value="bale" class="custom-control-input" id="bale" wire:model="com_ways">
                                            <label class="custom-control-label" for="bale">بله</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" value="instagram" class="custom-control-input" id="instagram" wire:model="com_ways">
                                            <label class="custom-control-label" for="instagram">اینستاگرام</label>
                                            @error('com_ways')
                                            <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" value="eitaa" class="custom-control-input" id="eitaa" wire:model="com_ways">
                                            <label class="custom-control-label" for="eitaa">ایتا</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="notes">یادداشت</label>
                                <textarea class="form-control form-control-sm" wire:model="notes" id="notes" placeholder="یادداشت یا نکته یا یادآوری در مورد مشتری"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary btn-dim">ذخیره اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- .card-preview -->
    </div>
    <!-- .nk-block -->

    <div wire:loading class="modal fade zoom  modal-s show" tabindex="-1" id="modalZoom" aria-hidden="true">
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
</div>
