@extends('layouts.app')

@section('title', 'Edit Izin')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Izin</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Edit Izin</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Izin</h2>
            <p class="section-lead">
                Perbarui informasi tentang izin Peserta.
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @if ($permission->user->image)
                                <div>
                                    <img src="{{ asset('storage/images/' . $permission->user->image) }}" alt="User Image" class="rounded-circle mb-5" style="max-width: 200px;">
                                </div>
                                @endif
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama Peserta</label>
                                        <p>{{ $permission->user->name }}</p>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Asal Sekolah</label>
                                        <p>{{ $permission->user->sekolah }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Tanggal Izin</label>
                                        <p>{{ $permission->date_permission }}</p>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Alasan</label>
                                        <p>{{ $permission->reason }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>status</label>
                                        <select name="is_approved" class="form-control" style="height: 40px;">
                                            <option value="1" {{ $permission->is_approved == 1 ? 'selected' : '' }}>
                                                Disetujui</option>
                                            <option value="0" {{ $permission->is_approved == 0 ? 'selected' : '' }}>
                                                Tidak Disetujui</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraries -->
<script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
@endpush
