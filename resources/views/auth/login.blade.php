@extends('layouts.auth')

@section('title', 'Login Page')

@section('content')
    <section id="login">
      <div class="row m-0">

        <div class="col-lg-8 explore">
          <div class="explore-content">
            <h1 class="title">We Explore The New Life Much Better</h1>
            <div class="explore-images">
              <div class="img big">
                <img src="{{ url('frontend/images/login/explore4.png')}}">
              </div>
              <div class="img small">
                <img src="{{ url('frontend/images/login/explore2.png')}}">
              </div>
              <div class="img small">
                <img src="{{ url('frontend/images/login/explore1.png')}}">
              </div>
              <div class="img big">
                <img src="{{ url('frontend/images/login/explore3.png')}}">
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 login">
          <div class="login-card">
            <div class="logo">
                <a href="/">
                    <img src="{{ url('frontend/images/nomads_logo/logo_nomads.png') }}">
                </a>
            </div>
            <div id="formBody">
              <div class="form mt-4">
                <form action="{{ route('login') }}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input required value="{{ old('email') }}" name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <div class="group">
                      <input required name="password" type="password" class="form-control @error('email') is-invalid @enderror" id="password">
                      <button class="see-password" type="button" data-passwordtarget="#password">
                          <i class="fas fa-fw fa-eye-slash"></i>
                      </button>
                    </div>
                    @error('email') <small class="text-danger ml-2"> {{ $message }} </small> @enderror
                  </div>
                  <div class="checkbox">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                  </div>
                  <button class="nomads-btn px-5 my-3 mx-auto d-block">Get Started</button>
                </form>
              </div>
              <div class="text-center">
                <a class="forgot-password" href="{{ route('password.request') }}">Forgot Your Password?</a>
              </div>

              <div class="text-center">
                <a class="forgot-password" href="{{ route('register') }}" data-authtype="register">Doesn't have an account?</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
@endsection
