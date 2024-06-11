@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Edit User Mahasiswa'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit User Mahasiswa</h6>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('admin.user-mhs.update', $userMhs->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $userMhs->name }}"
                                required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $userMhs->email }}" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ $userMhs->nim }}"
                                required>
                            @error('nim')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="class" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="class" name="class"
                                value="{{ $userMhs->class }}" required>
                            @error('class')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="major" class="form-label">Jurusan</label>
                            <input type="text" class="form-control" id="major" name="major"
                                value="{{ $userMhs->major }}" required>
                            @error('major')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="study_program" class="form-label">Program Studi</label>
                            <input type="text" class="form-control" id="study_program" name="study_program"
                                value="{{ $userMhs->study_program }}" required>
                            @error('study_program')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                value="{{ $userMhs->phone_number }}" required>
                            @error('phone_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            @if($userMhs->avatar)
                            <img src="{{ $userMhs->avatar }}" alt="Avatar" class="img-thumbnail mt-2"
                                style="max-height: 150px;">
                            @endif
                            @error('avatar')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.user-mhs.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection