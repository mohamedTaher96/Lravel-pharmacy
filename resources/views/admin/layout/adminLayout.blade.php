<!DOCTYPE html>
<html lang="en">
<head >
    @include('admin/layout/partials.head')
    @yield('style')
    <style>
        .edit
        {
            width: 50px;
            height: 50px;
        }
        .sidebar_img
        {
            width: 65px;
            height: 65px;
        }
    </style>
</head>
<body class="skin-blue sidebar-mini" dir="rtl">
    <div class="wrapper">
     @include('admin/layout/partials.nav') 
     @include('admin/layout/partials.sidebar') 
    <div class="content-wrapper"> @yield('content')  </div>
    <footer > @include('admin/layout/partials.footer') </footer>
    </div>
    @include('admin/layout/partials.script')
    @yield('script')
</body>
</html>