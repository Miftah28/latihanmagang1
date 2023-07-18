 <!-- ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">

     <div class="d-flex align-items-center justify-content-between">
         <a href="{{route('home')}}" class="logo d-flex align-items-center">
             <img src="assets/img/logo.png" alt="">
             <span class="d-none d-lg-block">NiceAdmin</span>
         </a>
         <i class="bi bi-list toggle-sidebar-btn"></i>
     </div><!-- End Logo -->

     <nav class="header-nav ms-auto">
         <ul class="d-flex align-items-center">

             <li class="nav-item dropdown pe-3">
                 @php
                     if (auth()->user()->role == 'admin') {
                         $name = Auth::user()->admin->name;
                     } elseif (auth()->user()->role == 'admindaerah') {
                         $name = Auth::user()->admindaerah->name;
                     } elseif (auth()->user()->role == 'supir') {
                         $name = Auth::user()->supir->name;
                     } elseif (auth()->user()->role == 'penumpang') {
                         $name = Auth::user()->penumpang->name;
                     }
                 @endphp
                 @php
                     if (auth()->user()->role == 'admin') {
                         $route = route('admin.profile');
                     } elseif (auth()->user()->role == 'admindaerah') {
                         $route = route('admindaerah.profile');
                     } elseif (auth()->user()->role == 'supir') {
                         $route = route('supir.profile');
                     } elseif (auth()->user()->role == 'penumpang') {
                         $route = route('penumpang.profile');
                     }
                 @endphp
                 <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                     data-bs-toggle="dropdown">
                     <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                     <span class="d-none d-md-block dropdown-toggle ps-2">{{ $name }}</span>
                 </a><!-- End Profile Iamge Icon -->

                 <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                     <li class="dropdown-header">
                         <h6>{{ $name }}</h6>
                     </li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>

                     <li>
                         <a class="dropdown-item d-flex align-items-center" href="{{ $route }}">
                             <i class="bi bi-person"></i>
                             <span>My Profile</span>
                         </a>
                     </li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>

                     <li>
                         <a class="dropdown-item d-flex align-items-center"data-bs-toggle="modal"
                             data-bs-target="#disablebackdrop">
                             <i class="bi bi-box-arrow-right"></i>
                             <span>Sign Out</span>
                         </a>
                     </li>

                 </ul><!-- End Profile Dropdown Items -->
             </li><!-- End Profile Nav -->

         </ul>
     </nav><!-- End Icons Navigation -->

 </header><!-- End Header -->
