@extends('layouts.app')

@section('content')
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            @include('layouts.navbars.guest.navbar')
        </div>
    </div>
</div>
<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Forgot Password</h4>
                                <p class="mb-0">Please Enter Your Email and We’ll Send You Verification Link</p>
                            </div>
                            <div class="card-body">
                                @include('components.alert')
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Send Password Reset Link
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
                                background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">SIARAN</h4>
                            <p class="text-white position-relative">Sistem Layanan Pengaduan dan Pelaporan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection