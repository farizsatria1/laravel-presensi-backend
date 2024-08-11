@extends('layouts.app')

@section('title', 'Presensi')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Presensi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Presensi</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Presensi</h2>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="float-right">
                                <form method="GET" action="{{ route('attendances.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama" name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Pulang</th>
                                        <th>Latlong Masuk</th>
                                        <th>Latlong Pulang</th>
                                        <th>Status</th>
                                    </tr>
                                    @foreach ($attendances as $attendance)
                                    <tr>

                                        <td>{{ $attendance->user->name }}
                                        </td>
                                        <td>
                                            {{ $attendance->date }}
                                        </td>
                                        <td>
                                            {{ $attendance->time_in }}
                                        </td>
                                        <td>
                                            {{ $attendance->time_out }}
                                        </td>
                                        <td>
                                            {{ $attendance->latlon_in }}
                                        </td>
                                        <td>
                                            {{ $attendance->latlon_out }}
                                        </td>
                                        <td>
                                            @if ($attendance->status == 1)
                                            <div class="badge badge-success">Tepat Waktu</div>
                                            @else
                                            <div class="badge badge-danger">Terlambat</div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach


                                </table>
                            </div>
                            <div class="float-right">
                                {{ $attendances->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush