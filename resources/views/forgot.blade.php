@extends('layout.auth_base')


@section("content")
<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
            <div class="col-lg-6">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Forgot Password</h1>
                  @if(Session::has('message'))
                  <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
                      {{ Session::get('message') }}</p>
                @endif
                  <p>Please enter the email associated with your account</p>
                </div>
              <form class="user" method="POST" action="{{route('forgot')}}">
                  @csrf
                  <div class="form-group">
                    <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                  </div>
                  <button href="#" class="btn btn-primary btn-user btn-block" type="submit">
                    Submit
                  </button>
                  <hr>
                </form>
                <div class="text-center">
                  Remember your password ? <a class="medium" href="{{route('login')}}">login</a>
                </div>
                <div class="text-center">
                  Don't have an account ?<a class="medium" href="{{route('register')}}"> Create an Account!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection