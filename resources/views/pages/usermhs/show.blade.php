@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Detail User Mahasiswa'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Detail User Mahasiswa</h6>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <img src="{{ $userMhs->avatar }}" alt="Avatar" class="img-thumbnail">
                        </div>
                        <div class="col-md-9">
                            <table class="table table-striped">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $userMhs->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $userMhs->email }}</td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>{{ $userMhs->nim }}</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>{{ $userMhs->class }}</td>
                                </tr>
                                <tr>
                                    <th>Jurusan</th>
                                    <td>{{ $userMhs->major }}</td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <td>{{ $userMhs->study_program }}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $userMhs->phone_number }}</td>
                                </tr>
                            </table>
                            <a href="{{ route('admin.user-mhs.edit', $userMhs->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('admin.user-mhs.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection