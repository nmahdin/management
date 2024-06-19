<!DOCTYPE html>
<html lang="fa" class="js">
<div class="js-preloader">
    <div class="loading-animation tri-ring"></div>
</div>
<head>
    <meta charset="utf-8" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="/assets/images/favicon.png" />
    <!-- Page Title  -->
    <title>{{ $title }} | هنر صدف</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="/assets/css/dashlite.rtl.css" />
    <link id="skin-default" rel="stylesheet" href="/assets/css/theme.css" />
</head>

<body class="has-rtl nk-body ui-rounder has-sidebar" dir="rtl">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main">
        <!-- sidebar @s -->
        <div class="nk-sidebar nk-sidebar-fixed is-light" data-content="sidebarMenu">
            <div class="nk-sidebar-element nk-sidebar-head">
                <div class="nk-sidebar-brand">
                    <a href="html/index.html" class="logo-link nk-sidebar-logo">
                        <img class="logo-light logo-img" src="/assets/images/logo.png" srcset="/assets/images/logo2x.png 2x" alt="لوگو" />
                        <img class="logo-dark logo-img" src="/assets/images/logo-dark.png" srcset="/assets/images/logo-dark2x.png 2x" alt="لوگوی تاریک" />
                        <img class="logo-small logo-img logo-img-small" src="/assets/images/logo-small.png" srcset="/assets/images/logo-small2x.png 2x" alt="لوگوی کوچک" />
                    </a>
                </div>
                <div class="nk-menu-trigger me-n2">
                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
            <!-- .nk-sidebar-element -->
            <x-admin.app.sidebar/>
            <!-- .nk-sidebar-element -->
        </div>
        <!-- sidebar @e -->
        <!-- wrap @s -->
        <div class="nk-wrap">
            <!-- main header @s -->
            <x-admin.app.header/>
            <!-- main header @e -->
            <!-- content @s -->
            {{ $slot }}
            <!-- content @e -->
            <!-- footer @s -->
            <x-admin.app.footer/>
            <!-- footer @e -->
        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->

<!-- .modal -->
<!-- JavaScript -->
<script src="/assets/js/bundle.js"></script>
<script src="/assets/js/scripts.js"></script>
<script src="/assets/js/charts/gd-campaign.js"></script>
{{ $script ?? '' }}
</body>

</html>
