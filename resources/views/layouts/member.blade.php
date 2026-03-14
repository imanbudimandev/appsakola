<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>@yield('title', 'Member Dashboard - Appsakola')</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/css/custom.css" />
      <!-- fontawesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
      <style>
         .midde_cont {
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 60px);
         }
         .midde_cont > .container-fluid:first-child {
            flex: 1;
         }
         .footer {
            margin-top: auto;
            background: #fff;
            padding: 20px 30px;
            width: 100%;
         }
      </style>
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
                        <a href="{{ route('landing') }}">
                           <img class="logo_icon img-responsive"
                              src="{{ $siteLogo ? asset('storage/' . $siteLogo) : 'https://cdn.jsdelivr.net/gh/themewagon/pluto@master/images/logo/logo_icon.png' }}"
                              alt="logo"
                              onerror="this.src='https://via.placeholder.com/60x60?text=Logo'"
                              style="max-height: 60px; object-fit: contain; padding: 5px;" />
                        </a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img">
                           <div style="width:75px;height:75px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#4f46e5);display:flex;align-items:center;justify-content:center;color:white;font-size:28px;font-weight:bold;margin:0 auto;">
                              {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 1)) }}
                           </div>
                        </div>
                        <div class="user_info">
                           <h6>{{ auth()->user()->name ?? 'Member' }}</h6>
                           <p><span class="online_animation"></span> Member</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <h4>Member Menu</h4>
                  <ul class="list-unstyled components">
                     <li class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('member.dashboard') }}">
                           <i class="fa fa-home yellow_color"></i> <span>My Library</span>
                        </a>
                     </li>
                     <li class="{{ request()->routeIs('member.orders.*') ? 'active' : '' }}">
                        <a href="{{ route('member.orders.index') }}">
                           <i class="fa fa-shopping-bag purple_color"></i> <span>Riwayat Pembelian</span>
                        </a>
                     </li>
                     <li class="{{ request()->routeIs('member.products') ? 'active' : '' }}">
                        <a href="{{ route('member.products') }}">
                           <i class="fa fa-search blue2_color"></i> <span>Cari Produk</span>
                        </a>
                     </li>
                     <li>
                        <form method="POST" action="{{ route('logout') }}" id="member-logout-form">
                           @csrf
                        </form>
                        <a href="#" onclick="document.getElementById('member-logout-form').submit();">
                           <i class="fa fa-sign-out red_color"></i> <span>Logout</span>
                        </a>
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
                        <div class="logo_section" style="display: flex; align-items: center; height: 60px; padding-left: 20px;">
                           <a href="{{ route('landing') }}" style="text-decoration: none;">
                              <h4 class="text-white font-weight-bold mb-0" style="letter-spacing: 1px;">{{ \App\Models\Setting::get('site_name', 'Appsakola') }}</h4>
                           </a>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul class="user_profile_dd">
                                 <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                       <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#4f46e5);display:inline-flex;align-items:center;justify-content:center;color:white;font-weight:bold;font-size:14px;">
                                          {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 1)) }}
                                       </div>
                                       <span class="name_user">{{ auth()->user()->name ?? 'Member' }}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="{{ route('member.dashboard') }}">My Library</a>
                                       <a class="dropdown-item" href="{{ route('member.orders.index') }}">Riwayat Pembelian</a>
                                       <div class="dropdown-divider"></div>
                                       <a class="dropdown-item" href="#" onclick="document.getElementById('member-logout-form').submit();">
                                          <span>Logout</span> <i class="fa fa-sign-out"></i>
                                       </a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- end topbar -->

               <!-- content area -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>@yield('header', 'Dashboard')</h2>
                           </div>
                        </div>
                     </div>

                     @if(session('success'))
                        <div class="alert alert-success alert-dismissible mt-2">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                     @endif

                     @if($errors->any())
                        <div class="alert alert-danger alert-dismissible mt-2">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <i class="fa fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
                        </div>
                     @endif

                     @yield('content')
                  </div>

                  <!-- footer -->
                  <div class="container-fluid">
                     <div class="footer">
                        <p>{!! \App\Models\Setting::get('site_footer', 'Copyright © ' . date('Y') . ' Appsakola. All rights reserved.') !!}</p>
                     </div>
                  </div>
               </div>
               <!-- end content area -->
            </div>
         </div>
      </div>

      <!-- jQuery -->
      <script src="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/js/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/js/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/js/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/js/animate.js"></script>
      <script src="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/js/bootstrap-select.js"></script>
      <script src="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/js/perfect-scrollbar.min.js"></script>
      <script>
         if(typeof PerfectScrollbar !== 'undefined') {
             var ps = new PerfectScrollbar('#sidebar');
         }
      </script>
      <script src="https://cdn.jsdelivr.net/gh/themewagon/pluto@master/js/custom.js"></script>
      @stack('scripts')
   </body>
</html>
