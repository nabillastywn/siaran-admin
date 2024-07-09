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
                        <div class="card card-plain mt-5">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Email Verification</h4>
                            </div>
                            <div class="card-body">
                                @if ($status == 'success')
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                                @elseif ($status == 'info')
                                <div class="alert alert-info">
                                    {{ $message }}
                                </div>
                                @elseif ($status == 'error')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
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