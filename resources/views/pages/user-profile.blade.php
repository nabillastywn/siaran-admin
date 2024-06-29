@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="{{ auth()->user()->avatar ?? 'Avatar'}}" alt="profile_image"
                        class="w-100 border-radius-lg shadow-sm">

                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{ auth()->user()->name ?? 'Name' }}
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                        {{ auth()->user()->role == 0 ? 'Admin' : (auth()->user()->role == 1 ? 'PIC' : 'Mahasiswa') }}
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            </div>
        </div>
    </div>
</div>
<div id="alert">
    @include('components.alert')
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                    @csrf
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Edit Profile</p>
                            <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">User Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Name</label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ old('name', auth()->user()->name) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email address</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Phone Number</label>
                                    <input class="form-control" type="text" name="phone_number"
                                        value="{{ old('phone_number', auth()->user()->phone_number) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">NIM</label>
                                    <input class="form-control" type="text" name="nim"
                                        value="{{ old('nim', auth()->user()->nim) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Class</label>
                                    <input class="form-control" type="text" name="class"
                                        value="{{ old('class', auth()->user()->class) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Major</label>
                                    <input class="form-control" type="text" name="major"
                                        value="{{ old('major', auth()->user()->major) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Study Program</label>
                                    <input class="form-control" type="text" name="study_program"
                                        value="{{ old('study_program', auth()->user()->study_program) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Avatar</label>
                                    <input class="form-control" type="file" name="avatar">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Contact Information</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Address</label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ old('address', auth()->user()->address) }}">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">About me</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">About me</label>
                                    <input class="form-control" type="text" name="about"
                                        value="{{ old('about', auth()->user()->about) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <img src="/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="javascript:;">
                                <img src="{{ auth()->user()->avatar }}"
                                    class="rounded-circle img-fluid border border-2 border-white">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="h6 text-center mt-4">
                        <h5>
                            {{ auth()->user()->name }}<span class="font-weight-light"></span>
                        </h5>
                        <div class="h6 font-weight-300 mt-4">
                            <i class="ni location_pin mr-2"></i>{{ auth()->user()->address ?? 'No Address' }}
                        </div>
                        <div class="h6 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>{{ auth()->user()->class ?? 'No Class' }}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>{{ auth()->user()->major ?? 'No Major' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection