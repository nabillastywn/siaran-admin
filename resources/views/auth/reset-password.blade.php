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
                                <img src="{{ asset('img/SIARAN.png') }}" alt="SIARAN" class="img-fluid mb-4" style="height: auto; width: 150px;">
                                <h4 class="font-weight-bolder">Reset Password</h4>
                                <p class="mb-0">Please enter your new password</p>
                            </div>
                            <div class="card-body">
                                <form id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus disabled>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter your new password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirm">Confirm New Password</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your new password">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="resetPasswordBtn">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div id="alert">
                                @include('components.alert')
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#resetPasswordForm').on('submit', function(event) {
            event.preventDefault();

            var formData = {
                token: $('input[name="token"]').val(),
                email: $('input[name="email"]').val(),
                password: $('input[name="password"]').val(),
                password_confirmation: $('input[name="password_confirmation"]').val()
            };

            $.ajax({
                type: 'POST',
                url: 'http://localhost:8000/api/password/reset',
                data: formData,
                success: function(response) {
                    // Handle success response (e.g., show success message)
                    console.log(response);
                    $('#alert').html('<div class="alert alert-success">Password reset successful!</div>');

                    // Reset form fields
                    $('#resetPasswordForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    // Handle error response (e.g., show error message)
                    var errorMessage = xhr.responseJSON.message || 'Something went wrong!';
                    $('#alert').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                }
            });
        });
    });
</script>