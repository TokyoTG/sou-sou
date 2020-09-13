<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('dashboard/assets/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('dashboard/assets/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('dashboard/assets/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('dashboard/assets/site.webmanifest')}}">
  <meta name="author" content="">

  @yield('title')

  <!-- Custom fonts for this template-->
  <link href="{{asset('dashboard/assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('dashboard/assets/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>


<style>
  .bg-login-image,.bg-register-image,.bg-password-image {
  background: url("{{asset('dashboard/assets/img/YBA_Logo.png')}}");
  background-position: center;
  background-size: cover;
}

#logo{
  height: 50px;
  display: inline-block;
  width: 100px;
}

#logo img{
  width: 100%;
  border-radius: 10px;
  background: white;
  height: 100%;
}
</style>

<body class="bg-gradient-primary">

  <div class="container">
  <a href="{{route('welcome')}}"  id="logo">
      <img src="{{asset('dashboard/assets/img/YBA_Logo.png')}}" alt="logo" >
      </a>
   
        @yield('content')




  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
