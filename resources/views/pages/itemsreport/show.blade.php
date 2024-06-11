@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Detail Items Report'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Detail Items Report</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <table class="table align-items-center mb-0">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $itemsReport->userMhs->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td>{{ $itemsReport->location }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $itemsReport->status->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ \Carbon\Carbon::parse($itemsReport->created_at)->format('d-M-Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $itemsReport->description }}</td>
                            </tr>
                            <tr>
                                <th>Lampiran</th>
                                <td><a href="{{ $itemsReport->attachment }}" target="_blank">Lihat Lampiran</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection