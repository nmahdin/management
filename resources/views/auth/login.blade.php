<!DOCTYPE html>
<html lang="fa" class="js">
<head>
    <meta charset="utf-8" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="/images/favicon.png" />
    <!-- Page Title  -->
    <title>ورود | صدف پرداز</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="/assets/css/dashlite.rtl.css" />
    <link id="skin-default" rel="stylesheet" href="/assets/css/theme.css" />
</head>

<body class="has-rtl nk-body ui-rounder npc-general pg-auth" dir="rtl">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content">
                <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                    <div class="card">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">ورود</h4>
                                    <div class="nk-block-des">
                                        <p>با استفاده از ایمیل و رمز عبور خود به پنل صدف پرداز دسترسی پیدا کنید.</p>
                                    </div>
                                </div>
                            </div>
                            @if($errors->any())
                                <ul>
                                    @foreach($errors as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                            @endif
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="email">ایمیل یا نام کاربری</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="نشانی ایمیل یا نام کاربری خود را وارد کنید" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">رمز عبور</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="رمز عبور خود را وارد کنید" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block">ورود</button>
                                </div>
                            </form>
                            <div class="form-note-s2 text-center pt-4">در پلتفرم ما جدید هستید؟ <a href="{{ route('register') }}">یک حساب کاربری ایجاد کنید</a></div>
                        </div>
                    </div>
                </div>
                <div class="nk-footer nk-auth-footer-full">
                    <div class="container wide-lg">
                        <div class="row g-3">
                            <div class="col-lg-6 order-lg-last">
                                <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">نسخه آزمایشی x.x.x</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <div class="nk-block-content text-center text-lg-left">
                                    <p class="text-soft">© تمام حقوق محفوظ است.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="/assets/js/bundle.js"></script>
<script src="/assets/js/scripts.js"></script>
<!-- select region modal -->
<!-- .modal -->
</body>
</html>
