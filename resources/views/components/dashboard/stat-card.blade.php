@props([
    'title' => '',
    'value' => '',
    'icon' => 'ni-info',
    'color' => 'primary'
])
<div class="card card-bordered text-center">
    <div class="card-inner">
        <em class="icon ni {{ $icon }} text-{{ $color }} fs-30px mb-1"></em>
        <div class="fs-20px fw-bold mb-1">{{ $value }}</div>
        <div class="text-{{ $color }}">{{ $title }}</div>
    </div>
</div>
