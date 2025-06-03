@if($status == 'completed')
    <span class="badge badge-dim bg-success">
        تکمیل شده
    </span>
@elseif($status == 'unpaid')
    <span class="badge badge-dim bg-warning">
        پرداخت نشده
    </span>
@elseif($status == 'paid')
    <span class="badge badge-dim bg-info">
        پرداخت شده
    </span>
@elseif($status == 'canceled')
    <span class="badge badge-dim bg-danger">
        لغو شده
    </span>
@else
    <span class="badge badge-dim bg-light">
        {{ $status }}
    </span>
@endif
