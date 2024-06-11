@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Edit Lost Item'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Lost Item</h6>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    @if ($lostitem)
                    <form action="{{ route('admin.lost-item.update', ['lostitem' => $lostitem->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lost Item</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $lostitem->name }}"
                                required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.lost-item.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                    @else
                    <p>Lost Item not found!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection