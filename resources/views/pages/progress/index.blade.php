@extends('layouts.app')

@section('title', 'Progress')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Progress</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Progress</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Progress</h2>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="float-left">
                                <form method="GET" action="{{ route('progress.index') }}">
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
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Judul</th>
                                            <th>Isi</th>
                                            <th>Trainer</th>
                                            <th>Status</th>
                                            <th>Gambar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($progresses as $progress)
                                        <tr>
                                            <td>{{ $progress->date }}</td>
                                            <td>{{ $progress->user ? $progress->user->name : 'User tidak ditemukan' }}</td>
                                            <td>{{ $progress->judul }}</td>
                                            <td>{{ $progress->isi }}</td>
                                            <td>{{ $progress->trainer_pembimbing ? $progress->trainerPembimbing->name : ($progress->trainerPeserta ? $progress->trainerPeserta->name : 'Trainer tidak ditemukan') }}</td>
                                            <td>
                                                @if($progress->status == 0)
                                                <div class="badge badge-danger">Ditolak</div>
                                                @elseif($progress->status == 1)
                                                <div class="badge badge-success">Disetujui</div>
                                                @elseif($progress->status == 2)
                                                <div class="badge badge-warning">Pending</div>
                                                @elseif($progress->status == 3)
                                                <div class="badge badge-warning">Revisi</div>
                                                @else
                                                Tidak diketahui
                                                @endif
                                            </td>
                                            <td>
                                                @if($progress->image)
                                                <img
                                                    src="{{ asset('storage/progress/' . $progress->image) }}"
                                                    alt="Progress Image"
                                                    class="progress-image"
                                                    style="width: 100px; height: 100px; margin-top: 10px; cursor: pointer; object-fit: cover;"
                                                    data-toggle="modal"
                                                    data-target="#imageModal"
                                                    @php
                                                    $imageUrl=asset('storage/progress/' . $progress->image);
                                                @endphp
                                                onclick="setImageModal('{{ $imageUrl }}')">
                                                @else
                                                <span>No Image</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No progress found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $progresses->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal for displaying full-size images -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Progress Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Progress Image" class="img-fluid">
                <p id="modalCaption"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- JS Libraries -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>

<!-- Script for handling image modal -->
<script>
    function setImageModal(src) {
        document.getElementById('modalImage').src = src;
        $('#imageModal').modal('show');
    }
</script>
@endpush