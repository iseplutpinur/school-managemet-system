<?php
    // variable declaration
    $menus = [];


    $menus[] = [ 'title' => 'Dashboard', 'route' =>'dashboard', 'icon' => '<i data-feather="pie-chart"></i>'];
    $menus[] = [ 'title' => 'Manage User',
        'icon' => '<i data-feather="message-circle"></i>',
        'children' => [
            ['title' => 'View User', 'route' => 'user.view'],
            ['title' => 'Add User', 'route' => 'user.add'],
        ]
    ];

    $menus[] = [ 'title' => 'Mail Box',
        'icon' => '<i data-feather="mail"></i>',
        'children' => [
            ['title' => 'Inbox'],
            ['title' => 'Compose'],
            ['title' => 'Read'],
        ]
    ];


    $menus[] = [ 'title' => 'Components',
        'icon' => '<i data-feather="grid"></i>',
        'children' => [
            ['title' => 'Alerts'],
            ['title' => 'Badge'],
            ['title' => 'Buttons'],
            ['title' => 'Sliders'],
            ['title' => 'Dropdown'],
            ['title' => 'Modal'],
            ['title' => 'Nestable'],
            ['title' => 'Progress Bars'],
        ]
    ];

    // separator example
    $menus[] = [ 'title' => 'User Interface', 'separator' => false ];
    function sidebarMenu(Array $menus):string {
        function checkActive($route):bool {
            return request()->routeIs($route);
        }

        function filterMenu($menu):object{
            $title = isset($menu['title']) ? $menu['title'] : '';
            $icon = isset($menu['icon']) ? $menu['icon'] : '';
            $route = isset($menu['route']) ? $menu['route'] : '#';
            $active = checkActive($route);
            $active_class = $active ? 'active' : '';
            $route = $route == '#' ? '#' : route($route);

            return (object)[
                'title' => $title,
                'route' => $route,
                'icon' => $icon,
                'active' => $active,
                'active_class' => $active_class,
            ];
        }

        $menu_body = '';
        foreach ($menus as  $menu) {
            // 1 check separator
            $separator = isset($menu['separator']) ? $menu['separator'] : false;

            // 2 check children
            $children = isset($menu['children']) ? $menu['children'] : false;

            if ($separator) {
                $menu_body .= '<li class="header nav-small-cap">'. $menu['title'] . '</li>';
            }else if (is_array($children)) {
                $child_menu = '';
                $active = false;
                foreach ($children as  $child) {
                    $child_filter = filterMenu($child);
                    $child_menu .= '<li class="'.$child_filter->active_class.'"><a href="'.$child_filter->route.'"><i class="ti-more">'.$child_filter->title.'</i></a></li>';
                    if ($child_filter->active) $active = $child_filter->active;
                }
                $active_1 = $active ? ' menu-open active' : '';
                $active_2 = $active ? ' style="display: block;"' : '';
                $menu = filterMenu($menu);
                $menu_body .= '<li class="treeview '.$active_1.'"><a href="#">'.$menu->icon.'<span>'.$menu->title.'</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a><ul class="treeview-menu" '. $active_2 .'>'. $child_menu .'</ul></li>';

            }else{
                $menu = filterMenu($menu);
                $menu_body .= "<li class=\"$menu->active_class\"> <a href=\"$menu->route\"> $menu->icon <span>Dashboard</span> </a> </li>";
            }

        }

        $menu_head = '<ul class="sidebar-menu" data-widget="tree">';
        $menu_footer = '<li><a href="' . route('admin.logout') . '"><i data-feather="lock"></i><span>Log Out</span></a></li></ul>';

        return $menu_head.$menu_body.$menu_footer;
    }
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">

        <div class="user-profile">
            <div class="ulogo">
                <a href="index.html">
                    <!-- logo for regular state and mobile devices -->
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{ asset('backend/images/logo-dark.png') }}" alt="">
                        <h3><b>Sunny</b> Admin</h3>
                    </div>
                </a>
            </div>
        </div>

        <!-- sidebar menu-->
        {!! sidebarMenu($menus) !!}

    </section>

    <div class="sidebar-footer">
        <!-- item-->
        <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings"
            aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
        <!-- item-->
        <a href="mailbox_inbox.html" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i
                class="ti-email"></i></a>
        <!-- item-->
        <a href="{{ route('admin.logout') }}" class="link" data-toggle="tooltip" title=""
            data-original-title="Logout"><i class="ti-lock"></i></a>
    </div>
</aside>
<!-- Control Sidebar -->
<aside class="control-sidebar">

    <div class="rpanel-title"><span class="pull-right btn btn-circle btn-danger" data-toggle="control-sidebar"><i
                class="fa fa-times text-white"></i></span> </div>
    <!-- Create the tabs -->
    <ul class="nav nav-tabs control-sidebar-tabs">
        <li class="nav-item"><a href="#control-sidebar-home-tab" data-toggle="tab" class="active">Chat</a></li>
        <li class="nav-item"><a href="#control-sidebar-settings-tab" data-toggle="tab">Todo</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <div class="flexbox">
                <a href="javascript:void(0)" class="text-grey"><i class="ti-minus"></i></a>
                <p>Users</p>
                <a href="javascript:void(0)" class="text-right text-grey"><i class="ti-plus"></i></a>
            </div>
            <div class="lookup lookup-sm lookup-right d-none d-lg-block">
                <input type="text" name="s" placeholder="Search" class="w-p100">
            </div>
            <div class="media-list media-list-hover mt-20">
                <div class="media py-10 px-0">
                    <a class="avatar avatar-lg status-success" href="#">
                        <img src="{{ asset('backend/images/avatar/1.jpg') }}" alt="...">
                    </a>
                    <div class="media-body">
                        <p class="font-size-16">
                            <a class="hover-primary" href="#"><strong>Tyler</strong></a>
                        </p>
                        <p>Praesent tristique diam...</p>
                        <span>Just now</span>
                    </div>
                </div>

                <div class="media py-10 px-0">
                    <a class="avatar avatar-lg status-danger" href="#">
                        <img src="{{ asset('backend/images/avatar/2.jpg') }}" alt="...">
                    </a>
                    <div class="media-body">
                        <p class="font-size-16">
                            <a class="hover-primary" href="#"><strong>Luke</strong></a>
                        </p>
                        <p>Cras tempor diam ...</p>
                        <span>33 min ago</span>
                    </div>
                </div>

                <div class="media py-10 px-0">
                    <a class="avatar avatar-lg status-warning" href="#">
                        <img src="{{ asset('backend/images/avatar/3.jpg') }}" alt="...">
                    </a>
                    <div class="media-body">
                        <p class="font-size-16">
                            <a class="hover-primary" href="#"><strong>Evan</strong></a>
                        </p>
                        <p>In posuere tortor vel...</p>
                        <span>42 min ago</span>
                    </div>
                </div>

                <div class="media py-10 px-0">
                    <a class="avatar avatar-lg status-primary" href="#">
                        <img src="{{ asset('backend/images/avatar/4.jpg') }}" alt="...">
                    </a>
                    <div class="media-body">
                        <p class="font-size-16">
                            <a class="hover-primary" href="#"><strong>Evan</strong></a>
                        </p>
                        <p>In posuere tortor vel...</p>
                        <span>42 min ago</span>
                    </div>
                </div>

                <div class="media py-10 px-0">
                    <a class="avatar avatar-lg status-success" href="#">
                        <img src="{{ asset('backend/images/avatar/1.jpg') }}" alt="...">
                    </a>
                    <div class="media-body">
                        <p class="font-size-16">
                            <a class="hover-primary" href="#"><strong>Tyler</strong></a>
                        </p>
                        <p>Praesent tristique diam...</p>
                        <span>Just now</span>
                    </div>
                </div>

                <div class="media py-10 px-0">
                    <a class="avatar avatar-lg status-danger" href="#">
                        <img src="{{ asset('backend/images/avatar/2.jpg') }}" alt="...">
                    </a>
                    <div class="media-body">
                        <p class="font-size-16">
                            <a class="hover-primary" href="#"><strong>Luke</strong></a>
                        </p>
                        <p>Cras tempor diam ...</p>
                        <span>33 min ago</span>
                    </div>
                </div>

                <div class="media py-10 px-0">
                    <a class="avatar avatar-lg status-warning" href="#">
                        <img src="{{ asset('backend/images/avatar/3.jpg') }}" alt="...">
                    </a>
                    <div class="media-body">
                        <p class="font-size-16">
                            <a class="hover-primary" href="#"><strong>Evan</strong></a>
                        </p>
                        <p>In posuere tortor vel...</p>
                        <span>42 min ago</span>
                    </div>
                </div>

                <div class="media py-10 px-0">
                    <a class="avatar avatar-lg status-primary" href="#">
                        <img src="{{ asset('backend/images/avatar/4.jpg') }}" alt="...">
                    </a>
                    <div class="media-body">
                        <p class="font-size-16">
                            <a class="hover-primary" href="#"><strong>Evan</strong></a>
                        </p>
                        <p>In posuere tortor vel...</p>
                        <span>42 min ago</span>
                    </div>
                </div>

            </div>

        </div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <div class="flexbox">
                <a href="javascript:void(0)" class="text-grey"><i class="ti-minus"></i></a>
                <p>Todo List</p>
                <a href="javascript:void(0)" class="text-right text-grey"><i class="ti-plus"></i></a>
            </div>
            <ul class="todo-list mt-20">
                <li class="py-15 px-5 by-1">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_1" class="filled-in">
                    <label for="basic_checkbox_1" class="mb-0 h-15"></label>
                    <!-- todo text -->
                    <span class="text-line">Nulla vitae purus</span>
                    <!-- Emphasis label -->
                    <small class="badge bg-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_2" class="filled-in">
                    <label for="basic_checkbox_2" class="mb-0 h-15"></label>
                    <span class="text-line">Phasellus interdum</span>
                    <small class="badge bg-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5 by-1">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_3" class="filled-in">
                    <label for="basic_checkbox_3" class="mb-0 h-15"></label>
                    <span class="text-line">Quisque sodales</span>
                    <small class="badge bg-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_4" class="filled-in">
                    <label for="basic_checkbox_4" class="mb-0 h-15"></label>
                    <span class="text-line">Proin nec mi porta</span>
                    <small class="badge bg-success"><i class="fa fa-clock-o"></i> 3 days</small>
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5 by-1">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_5" class="filled-in">
                    <label for="basic_checkbox_5" class="mb-0 h-15"></label>
                    <span class="text-line">Maecenas scelerisque</span>
                    <small class="badge bg-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_6" class="filled-in">
                    <label for="basic_checkbox_6" class="mb-0 h-15"></label>
                    <span class="text-line">Vivamus nec orci</span>
                    <small class="badge bg-info"><i class="fa fa-clock-o"></i> 1 month</small>
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5 by-1">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_7" class="filled-in">
                    <label for="basic_checkbox_7" class="mb-0 h-15"></label>
                    <!-- todo text -->
                    <span class="text-line">Nulla vitae purus</span>
                    <!-- Emphasis label -->
                    <small class="badge bg-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_8" class="filled-in">
                    <label for="basic_checkbox_8" class="mb-0 h-15"></label>
                    <span class="text-line">Phasellus interdum</span>
                    <small class="badge bg-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5 by-1">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_9" class="filled-in">
                    <label for="basic_checkbox_9" class="mb-0 h-15"></label>
                    <span class="text-line">Quisque sodales</span>
                    <small class="badge bg-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
                <li class="py-15 px-5">
                    <!-- checkbox -->
                    <input type="checkbox" id="basic_checkbox_10" class="filled-in">
                    <label for="basic_checkbox_10" class="mb-0 h-15"></label>
                    <span class="text-line">Proin nec mi porta</span>
                    <small class="badge bg-success"><i class="fa fa-clock-o"></i> 3 days</small>
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
