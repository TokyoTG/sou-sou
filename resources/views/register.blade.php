@extends('layout.auth_base')

@section('title')
<title>YBA | Register </title> 
@endsection

@section("content")
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
        <div class="col-lg-7">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
            </div>
                   @if(Session::has('message'))
                                        <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
                                            {{ Session::get('message') }}</p>
                                        @endif
          <form class="user" action="{{route('signup')}}" method="POST">
            @csrf
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user" id="exampleFirstName" name="first_name" placeholder="First Name">
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control form-control-user" id="exampleLastName" name="last_name" placeholder="Last Name">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                   <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" placeholder="Email Address">
                </div>
                <div class="col-sm-6">
                  <input type="tel" class="form-control form-control-user" id="exampleLastName" name="phone_number" placeholder="Phone Number">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                </div>
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" name="password_confirmation" placeholder="Repeat Password">
                </div>
              </div>
                  <button class="btn btn-primary btn-user btn-block" type="submit">
                    Register
                  </button>
            </form>
            <hr>

            <div class="text-center">
           Already have an account ? <a class="medium" href="{{route('login')}}">Login</a>
            </div>
            <div class="text-center">
                <a class="medium" href="{{route('forgot')}}">Forgot Password?</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection