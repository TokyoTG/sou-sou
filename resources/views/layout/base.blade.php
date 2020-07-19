

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  @yield('title_page')

  <!-- Custom fonts for this template-->
  <link href="{{asset('dashboard/assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('dashboard/assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<style>
  .nav-tabs .nav-link.active{
    border-left: 3px solid #4e73df;
  }

  .fa-eye{
    font-size: 1.2em;
  }
  td{
    text-align: center;
  }

  a:hover{
    text-decoration: none;
  }

  
</style>

</head>

@php

   function is_admins(){
        return Cookie::get('role') !== null && Cookie::get('role') == "admin";
    }

    function is_members(){
        return Cookie::get('role') !== null && Cookie::get('role') == "member";
    }
@endphp

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard.index')}}">
        <div class="sidebar-brand-icon rotate-n-0">
          <i class="fas fa-user-circle"></i>
        </div>
        <div class="sidebar-brand-text mx-2">
          @if (Cookie::get('full_name') !== null)
         {{ Cookie::get('full_name') }}  
          @endif
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="{{route('dashboard.index')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Menu
      </div>

   

@if(is_admins())
        <li class="nav-item">
            <a class="nav-link" href="{{route('users.index')}}">
            <i class="fa-fw fa fa-users"></i>
            <span>Users</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('wait_list.index')}}">
           <i class="menu-icon fa fa-list-alt"></i>
            <span>Wait List</span></a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{route('dashboard.complaints')}}">
            <i class="menu-icon fa fa-list-alt"></i>
            <span>Approved List</span></a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link" href="{{route('groups.index')}}">
           <i class="fa-fw fa fa-folder"></i>
            <span>Groups</span></a>
      </li>
@endif


    
    
@if(is_members())
        {{-- <li class="nav-item">
          <a class="nav-link" href="{{route('groups.index')}}">
          <i class="fa-fw fa fa-folder"></i>
            <span>My Groups</span></a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{route('user_list')}}">
            <i class="fa-fw fa fa-user-plus"></i>
            <span>Wait List</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('tasks.index')}}">
           <i class="menu-icon fa fa-bell"></i>
            <span>Tasks</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('payments')}}">
           <i class="menu-icon fa fa-bell"></i>
            <span>Verify Payments</span></a>
        </li>
@endif
      <!-- Nav Item - Charts -->
      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="{{route('users.edit',Cookie::get('id'))}}">
          <i class="menu-icon fa fa-cogs"></i>
          <span>Settings</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            @php
                $tasks = Session::get('tasks');
            @endphp

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
              @if (count($tasks) > 0)
                  <span class="badge badge-danger badge-counter">{{count($tasks)}}</span>
              @endif
              
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  New Tasks
                </h6>
                @isset($tasks)
                  @if (count($tasks) > 0)
                      @foreach ($tasks as $item)
                      <a class="dropdown-item d-flex align-items-center" href="{{route('tasks.show',$item->id)}}">
                        <div class="mr-3">
                          <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                          </div>
                        </div>
                        <div>
                          <div class="small text-gray-500">{{date("D d M Y h:i:sa",strtotime($item->created_at))  }}</div>
                          {{$item->title}}
                        </div>
                      </a>
                      @endforeach
                  @else
                  
                  @endif
                    
                @endisset
                
                    <a class="dropdown-item text-center small text-gray-500" href="{{route('tasks.index')}}">Show All Tasks</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Cookie::get('full_name')}}</span>
              <div class="sidebar-brand-icon rotate-n-0">
                <i class="fas fa-user-circle"></i>
              </div>
                {{-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> --}}
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('users.edit',Cookie::get('id'))}}">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{route('logout')}}">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          @yield('title')
          @yield('newBtn')
          </div>   
           @yield('contents')
          </div>
        <!-- /.container-fluid -->
      
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Sou Sou 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('dashboard/assets/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('dashboard/assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('dashboard/assets/js/sb-admin-2.min.js')}}"></script>
  @yield('custom_js')
  <script>
    let links = [...document.getElementsByClassName('nav-item')];
   var loc = window.location.href;
      $(document).ready(()=>{
        links.forEach(link=>{
        if(link.firstElementChild.getAttribute('href')  == loc){
          link.classList.add('active');

        }
      })
      })
      setTimeout(function(){
        $('.alert').hide();
      },1000)
  </script>
</body>

</html>

<body>