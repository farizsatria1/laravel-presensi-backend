@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Peserta</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalUsers }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pembimbing</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalPembimbing }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Admin</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalAdmin }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total User</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalAdmin + $totalPembimbing + $totalUsers}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="section-title">Profil Perusahaan</h2>
        <p class="section-lead">
            Informasi tentang perusahaan Anda.
        </p>
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Nama Perusahaan</label>
                                <p>{{ $company->name }}</p>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Alamat Perusahaan</label>
                                <p>{{ $company->address }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Email Perusahaan</label>
                                <p>{{ $company->email }}</p>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Radius KM</label>
                                <p>{{ $company->radius_km }} KM</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Latitude</label>
                                <p>{{ $company->latitude }}</p>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Longitude</label>
                                <p>{{ $company->longitude }}</p>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-6 col-12">
                                <label>Waktu Masuk</label>
                                <p>{{ $company->time_in }}</p>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Waktu Pulang</label>
                                <p>{{ $company->time_out }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">Edit Profil
                            Perusahaan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush