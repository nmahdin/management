<div class="nk-block-between">
    <div class="nk-block-head-content">
        <!--   --------------- title --------------     -->
        <h3 class="nk-block-title page-title">@if(isset($trash) && $trash) سطل زباله سفارشات @else لیست سفارشات @endif</h3>
        <div class="nk-block-des text-soft">
            <!--   --------------- توضیح صفحه --------------     -->
            @if($n !== 0)
                <p>در مجموع {{ $n }} سفارش @if(isset($trash) && $trash) در سطل زباله وجود دارد @else ثبت شده است @endif.</p>
            @endif
        </div>
    </div>
    <!-- .nk-block-head-content -->
    @if(!isset($trash) || !$trash)  {{-- Only include if not in trash view --}}
    <div class="nk-block-head-content">
        <div class="toggle-wrap nk-block-tools-toggle">
            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                    class="icon ni ni-more-v"></em></a>
            <div class="toggle-expand-content" data-content="pageMenu">
                <ul class="nk-block-tools g-3">
                    <!--   --------------- links --------------     -->
                    <li>
                        <a href="{{ route('products.list') }}"
                           class="btn btn-primary">
                            <em class="icon ni ni-plus"></em>
                            <span class="fw-normal">
                                                    ثبت سفارش جدید
                                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.trash') }}"
                           class="btn btn-danger btn-dim">
                            <em class="icon ni ni-trash"></em>
                            <span class="fw-normal">
                                                    سطل زباله
                                                </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endif
    <!-- .nk-block-head-content -->
</div>
