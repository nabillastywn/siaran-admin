@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Detail User'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Detail User</h6>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <img src="{{ $user->avatar }}" alt="Avatar" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                        <div class="col-md-9">
                            <table class="table table-striped">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $user->address }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $user->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>{{ $user->nim }}</td>
                                </tr>
                                <tr>
                                    <th>Class</th>
                                    <td>{{ $user->class }}</td>
                                </tr>
                                <tr>
                                    <th>Major</th>
                                    <td>{{ $user->major }}</td>
                                </tr>
                                <tr>
                                    <th>Study Program</th>
                                    <td>{{ $user->study_program }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                        @if ($user->role == 0)
                                        Admin
                                        @elseif ($user->role == 1)
                                        PIC
                                        @elseif ($user->role == 2)
                                        Mahasiswa
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection