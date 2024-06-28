@extends('layouts.app')

@section('title', 'Edit User')

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
            <h1>Edit Peserta</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Peserta</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Peserta</h2>
            <div class="card">
                <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Nama -->
                        <div class="form-group">
                            <label>Name</label>
                            <input placeholder="Masukkan Nama" type="text" class="form-control @error('name')
                                is-invalid
                            @enderror" name="name" value="{{ old('name', $user->name) }}">
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
                                @enderror" name="email" value="{{ old('email', $user->email) }}">
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
                                <input type="password" class="form-control @error('password')
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
                                @enderror" name="sekolah" value="{{ old('sekolah', $user->sekolah) }}">
                                @error('sekolah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pembimbing -->
                        <div class="form-group">
                            <label for="participant">Nama Pembimbing:</label>
                            <select class="form-control" name="pembimbing_id">
                                <option value="">--Pilih Pembimbing--</option>
                                @foreach($pembimbingList as $pembimbingId => $pembimbingName)
                                <option value="{{ $pembimbingId }}" {{ old('pembimbing_id', $user->pembimbing_id) == $pembimbingId ? 'selected' : '' }}>
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

                        <!-- Gambar -->
                        <div class="form-group">
                            <label for="image">Gambar Profile</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror mb-3" id="image" name="image" onchange="previewImage();">
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            <img id="preview" src="{{ $user->image ? asset('storage/images/' . $user->image) :  asset('img/img-default.jpg') }}" alt="your image" width="200" />
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
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
