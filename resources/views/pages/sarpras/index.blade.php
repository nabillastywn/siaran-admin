@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Sarpras'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Sarpras</h6>
                    <a href="{{ route('admin.sarpras.create') }}" class="btn btn-primary btn-sm">Tambah Sarpras</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Slug
                                    </th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sarpras as $item)
                                <tr>
                                    <td class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</td>
                                    <td class="text-xs font-weight-bold mb-0">{{ $item->name }}</td>
                                    <td class="text-xs font-weight-bold mb-0">{{ $item->slug }}</td>
                                    <td class="text-xs font-weight-bold mb-0">
                                        <a href="{{ route('admin.sarpras.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <button onclick="confirmDelete('{{ $item->id }}')"
                                            class="btn btn-danger btn-sm">Hapus</button>
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('admin.sarpras.destroy', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-xs font-weight-bold mb-0">Tidak ada data
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $sarpras->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="px-4 pt-4">
    @if ($message = session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p class="text-white mb-0">{{ session()->get('success') }}</p>
    </div>
    @endif
    @if ($message = session()->has('error'))
    <div class="alert alert-danger" role="alert">
        <p class="text-white mb-0">{{ session()->get('error') }}</p>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You cant take back your action!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF7719',
        cancelButtonColor: '#CB0505',
        confirmButtonText: 'Yes, Delete!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection