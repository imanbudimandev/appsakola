<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Admin Dashboard - Appsakola</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="https://themewagon.github.io/pluto/images/fevicon.png" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="https://themewagon.github.io/pluto/css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="https://themewagon.github.io/pluto/style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="https://themewagon.github.io/pluto/css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="https://themewagon.github.io/pluto/css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="https://themewagon.github.io/pluto/css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="https://themewagon.github.io/pluto/css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="https://themewagon.github.io/pluto/css/custom.css" />
      <!-- fontawesome from CDN for icons if local missing -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
                        <a href="{{ route('admin.dashboard') }}"><img class="logo_icon img-responsive" src="{{ $siteLogo ? asset('storage/' . $siteLogo) : 'https://themewagon.github.io/pluto/images/logo/logo_icon.png' }}" alt="logo" onerror="this.src='https://via.placeholder.com/60x60?text=Logo'" style="max-height: 60px; object-fit: contain; padding: 5px;" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : 'https://themewagon.github.io/pluto/images/layout_img/user_img.jpg' }}" alt="#" onerror="this.src='https://via.placeholder.com/75x75?text=User'" style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;" /></div>
                        <div class="user_info">
                           <h6>{{ auth()->user()->name ?? 'Admin' }}</h6>
                           <p><span class="online_animation"></span> Online</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <h4>General</h4>
                  <ul class="list-unstyled components">
                     <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
                     </li>
                     <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.categories.index') }}"><i class="fa fa-object-group blue2_color"></i> <span>Categories</span></a>
                     </li>
                     <li class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index') }}"><i class="fa fa-diamond purple_color"></i> <span>Products</span></a>
                     </li>
                     <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.orders.index') }}"><i class="fa fa-table purple_color2"></i> <span>Orders</span></a>
                     </li>
                     <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}"><i class="fa fa-user orange_color"></i> <span>Users</span></a>
                     </li>
                     <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.index') }}"><i class="fa fa-cog yellow_color"></i> <span>Settings</span></a>
                     </li>
                     <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                        </form>
                        <a href="#" onclick="document.getElementById('logout-form').submit();"><i class="fa fa-sign-out red_color"></i> <span>Logout</span></a>
                     </li>
                  </ul>
               </div>
            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section" style="display: flex; align-items: center; justify-content: flex-start; height: 60px; padding-left: 20px;">
                           <a href="{{ route('admin.dashboard') }}" style="text-decoration: none;"><h4 class="text-white font-weight-bold mb-0" style="letter-spacing: 1px;">{{ \App\Models\Setting::get('site_name', 'Appsakola') }}</h4></a>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul>
                                 <li><a href="#"><i class="fa fa-bell-o"></i><span class="badge">0</span></a></li>
                                 <li><a href="#"><i class="fa fa-envelope-o"></i><span class="badge">0</span></a></li>
                              </ul>
                              <ul class="user_profile_dd">
                                 <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : 'https://themewagon.github.io/pluto/images/layout_img/user_img.jpg' }}" alt="#" onerror="this.src='https://via.placeholder.com/40x40?text=U'" style="width: 40px; height: 40px; object-fit: cover;" /><span class="name_user">{{ auth()->user()->name ?? 'Admin' }}</span></a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">My Profile</a>
                                       <a class="dropdown-item" href="{{ route('admin.settings.index') }}">Settings</a>
                                       <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>@yield('header')</h2>
                           </div>
                        </div>
                     </div>
                     <!-- session alert -->
                     @if(session('success'))
                        <div class="alert alert-success mt-2">
                           {{ session('success') }}
                        </div>
                     @endif
                     
                     <!-- content -->
                     @yield('content')
                  </div>
                  <!-- footer -->
                  <div class="container-fluid">
                     <div class="footer">
                        <p>Copyright © {{ date('Y') }} Designed by html.design. All rights reserved.<br><br>
                           Distributed By: <a href="https://themewagon.com/">ThemeWagon</a>
                        </p>
                     </div>
                  </div>
               </div>
               <!-- end dashboard inner -->
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="https://themewagon.github.io/pluto/js/jquery.min.js"></script>
      <script src="https://themewagon.github.io/pluto/js/popper.min.js"></script>
      <script src="https://themewagon.github.io/pluto/js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="https://themewagon.github.io/pluto/js/animate.js"></script>
      <!-- select country -->
      <script src="https://themewagon.github.io/pluto/js/bootstrap-select.js"></script>
      <!-- owl carousel -->
      <script src="https://themewagon.github.io/pluto/js/owl.carousel.js"></script> 
      <!-- chart js -->
      <script src="https://themewagon.github.io/pluto/js/Chart.min.js"></script>
      <script src="https://themewagon.github.io/pluto/js/Chart.bundle.min.js"></script>
      <script src="https://themewagon.github.io/pluto/js/utils.js"></script>
      <script src="https://themewagon.github.io/pluto/js/analyser.js"></script>
      <!-- nice scrollbar -->
      <script src="https://themewagon.github.io/pluto/js/perfect-scrollbar.min.js"></script>
      <script>
         if(typeof PerfectScrollbar !== 'undefined') {
             var ps = new PerfectScrollbar('#sidebar');
         }
      </script>
      <!-- custom js -->
      <script src="https://themewagon.github.io/pluto/js/custom.js"></script>
      @stack('scripts')
   </body>
</html>
