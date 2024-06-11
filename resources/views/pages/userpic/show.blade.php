@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Detail User PIC'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Detail User PIC</h6>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <img src="{{ $userPic->avatar }}" alt="Avatar" class="img-thumbnail"
                                style="max-width: 200px;">
                        </div>
                        <div class="col-md-9">
                            <table class="table table-striped">
                                <tr>
                                    <th>Username</th>
                                    <td>{{ $userPic->username }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $userPic->email }}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $userPic->phone_number }}</td>
                                </tr>
                            </table>
                            <a href="{{ route('admin.user-pic.edit', $userPic->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('admin.user-pic.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection