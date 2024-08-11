@extends('layouts.app')

@section('title', 'Add Peserta')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Peserta</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Peserta</a></div>
                <div class="breadcrumb-item">Buat</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Peserta</h2>
            <div class="card">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <!-- Nama -->
                        <div class="form-group">
                            <label>Name</label>
                            <input placeholder="Masukkan Nama" type="text" class="form-control @error('name')
                                is-invalid
                            @enderror" name="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <input placeholder="Masukkan Email" type="email" class="form-control @error('email')
                                is-invalid
                            @enderror" name="email">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                                <input placeholder="Masukkan Password" type="password" class="form-control @error('password')
                                is-invalid
                            @enderror" name="password">
                            </div>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Asal Sekolah -->
                        <div class="form-group">
                            <label>Asal Sekolah</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-university"></i>
                                    </div>
                                </div>
                                <input placeholder="Asal Sekolah" type="text" class="form-control @error('sekolah')
                                is-invalid
                            @enderror" name="sekolah">
                            </div>
                            @error('sekolah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-week"></i>
                                    </div>
                                </div>
                                <input placeholder="Tanggal Mulai" type="date" class="form-control @error('tgl_mulai')
                                is-invalid
                            @enderror" name="tgl_mulai">
                            </div>
                            @error('tgl_mulai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Pembimbing -->
                        <div class="form-group">
                            <label for="participant">Nama Pembimbing:</label>
                            <select class="form-control" name="pembimbing_id">
                                <option value="">--Pilih Pembimbing--</option>
                                @foreach($pembimbingList as $pembimbingId => $pembimbingName)
                                <option value="{{ $pembimbingId }}">
                                    {{ $pembimbingName }}
                                </option>
                                @endforeach
                            </select>
                            @error('pembimbing_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="participant">Status:</label>
                            <select class="form-control" name="status">
                                <option value="aktif">Aktif</option>
                                <option value="non-aktif">Tidak Aktif</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Divisi -->
                        <div class="form-group">
                            <label class="form-label">Divisi</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="divisi" value="web" class="selectgroup-input" checked="">
                                    <span class="selectgroup-button">Web</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="divisi" value="mobile" class="selectgroup-input">
                                    <span class="selectgroup-button">Mobile</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="divisi" value="multimedia" class="selectgroup-input">
                                    <span class="selectgroup-button">Multimedia</span>
                                </label>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div class="form-group">
                            <label for="image">Gambar Profile</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror mb-3" id="image" name="image" onchange="previewImage();">
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            <img id="preview" src="{{ asset('img/img-default.jpg') }}" alt="your image" width="200" />
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection
<script>
    function previewImage() {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        }
        reader.readAsDataURL(document.getElementById('image').files[0]);
    }
</script>
@push('scripts')
@endpush