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
                  <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                </div>
                <form class="user">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="exampleInputPassword" placeholder="Enter Password">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Enter Password">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Confirm Password">
                  </div>
                  <div class="form-group">
                  <button href="#" class="btn btn-primary btn-user btn-block" type="submit">
                    Submit
                  </button>
                  <hr>
                </form>
                <div class="text-center">
                  Remember password ? <a class="medium" href="">Login</a>
                </div>
                <div class="text-center">
                  Don't have an account ?<a class="medium" href="register.html"> Create an Account!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection