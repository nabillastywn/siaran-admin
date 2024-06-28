@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Lost Item'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Lost Items</h6>
                    <a href="{{ route('admin.lost-item.create') }}" class="btn btn-primary btn-sm">Tambah Lost Item</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Slug
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lostitems as $item)
                                <tr>
                                    <td class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</td>
                                    <td class="text-xs font-weight-bold mb-0">{{ $item->name }}</td>
                                    <td class="text-xs font-weight-bold mb-0">{{ $item->slug }}</td>
                                    <td class="text-xs font-weight-bold mb-0">
                                        <a href="{{ route('admin.lost-item.edit', ['lostitem' => $item->id]) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <button onclick="confirmDelete('{{ $item->id }}')"
                                            class="btn btn-danger btn-sm">Hapus</button>
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('admin.lost-item.destroy', $item->id) }}" method="POST"
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
                        {{ $lostitems->links() }}
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                @if ($lostitems->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&laquo;</span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $lostitems->previousPageUrl() }}"
                                        aria-label="Previous">&laquo;</a>
                                </li>
                                @endif

                                @foreach ($lostitems->getUrlRange(1, $lostitems->lastPage()) as $page => $url)
                                @if ($page == $lostitems->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endif
                                @endforeach

                                @if ($lostitems->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $lostitems->nextPageUrl() }}"
                                        aria-label="Next">&raquo;</a>
                                </li>
                                @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&raquo;</span>
                                </li>
                                @endif
                            </ul>
                        </nav>
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
        text: "You can't take back your action!",
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