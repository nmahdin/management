@if(session('danger'))
    {{--    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">--}}
    <div class="alert alert-fill alert-danger alert-icon">
        <em class="icon ni ni-cross-c"></em>
        {{ session('danger') }}
    </div>
@endif
