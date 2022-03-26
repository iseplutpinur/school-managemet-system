<?php
$page_attr = (object)[
    'title' => isset($page_attr['title']) ? $page_attr['title']: '',
    'description' => isset($page_attr['description']) ? $page_attr['description']: '',
    'author' => isset($page_attr['author']) ? $page_attr['author']: '',
    'navigation' => isset($page_attr['navigation']) ? $page_attr['navigation'] : false,
    'breadcrumbs' => isset($page_attr['breadcrumbs']) ? (is_array($page_attr['breadcrumbs']) ? $page_attr['breadcrumbs'] : false) : false,
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $page_attr->description }}">
    <meta name="author" content="{{ $page_attr->author }}">
    <link rel="icon" href="{{ asset('backend/images/favicon.ico') }}">

    <title>{{ $page_attr->title == '' ? '' : $page_attr->title . ' | ' . env('APP_NAME') }}</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/skin_color.css') }}">
    @yield('stylesheet')
</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">

        @include('admin.body.header')

        @include('admin.body.sidebar', ['page_attr_navigation' => $page_attr->navigation])

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                @if ($page_attr->breadcrumbs)
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="page-title">{{ $page_attr->title }}</h3>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                                                title="Go To Dashboard"><i class="mdi mdi-home-outline"></i></a>
                                        </li>
                                        @foreach ($page_attr->breadcrumbs as $breadcrumb)
                                        @if (isset($breadcrumb['name']))
                                        <li class="breadcrumb-item" aria-current="{{ $page_attr->title }}">
                                            @if (isset($breadcrumb['url']))
                                            <a href="{{ $breadcrumb['url'] }}"
                                                title="Page To {{ $breadcrumb['name'] }}">{{ $breadcrumb['name'] }}</a>
                                            @else
                                            {{ $breadcrumb['name'] }}
                                            @endif
                                        </li>
                                        @endif
                                        @endforeach

                                        <li class="breadcrumb-item active" aria-current="{{ $page_attr->title }}">
                                            {{ $page_attr->title }}</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section>
                <!-- /.content -->

            </div>
        </div>
        <!-- /.content-wrapper -->

        @include('admin.body.footer')


    </div>
    <!-- ./wrapper -->


    <!-- Vendor JS -->
    <script src="{{ asset('backend/js/vendors.min.js') }}"></script>
    <script src="{{ asset('backend/assets/icons/feather-icons/feather.min.js') }}"></script>

    <!-- Sunny Admin App -->
    <script src="{{ asset('backend/js/template.js') }}"></script>
    @yield('javascript')
</body>

</html>
