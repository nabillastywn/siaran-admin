@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Bullying Reports'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Bullying Reports</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Attachment</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Location</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bullyingReports as $report)
                                <tr>
                                    <td class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</td>
                                    <td class="text-xs font-weight-bold mb-0">
                                        @if ($report->attachment)
                                        <a href="{{ asset($report->attachment) }}" target="_blank">View Attachment</a>
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td class="text-xs font-weight-bold mb-0">{{ $report->location }}</td>
                                    <td class="text-xs font-weight-bold mb-0">{{ $report->status->name ?? 'N/A' }}</td>
                                    <td class="text-xs font-weight-bold mb-0">
                                        {{ \Carbon\Carbon::parse($report->created_at)->format('d-M-Y H:i') }}
                                    </td>
                                    <td class="text-xs font-weight-bold mb-0">
                                        <a href="{{ route('admin.bullying-report.show', ['bullyingReport' => $report->id]) }}"
                                            class="btn btn-info btn-sm">View Details</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-xs font-weight-bold mb-0">No bullying
                                        reports found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                @if ($bullyingReports->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&laquo;</span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $bullyingReports->previousPageUrl() }}"
                                        aria-label="Previous">&laquo;</a>
                                </li>
                                @endif

                                @foreach ($bullyingReports->getUrlRange(1, $bullyingReports->lastPage()) as $page =>
                                $url)
                                @if ($page == $bullyingReports->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endif
                                @endforeach

                                @if ($bullyingReports->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $bullyingReports->nextPageUrl() }}"
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
@endsection