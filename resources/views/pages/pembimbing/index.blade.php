@extends('layouts.app')

@section('title', 'Pembimbing')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pembimbing</h1>
            <div class="section-header-button">
                <a href="{{ route('pembimbings.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Pembimbing</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">

            </div>
            <h2 class="section-title">Pembimbing</h2>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="float-right">
                                <form method="GET" action="{{ route('pembimbings.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="name">
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
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Profile</th>
                                        <th>Action</th>
                                    </tr>
                                     @foreach ($pembimbings as $pembimbing)
                                    <tr>
                                    <td>{{ $pembimbings->firstItem() + $loop->index }}</td>
                                        <td>{{ $pembimbing->name }}
                                        </td>
                                        <td>
                                            {{ $pembimbing->email }}
                                        </td>
                                        <td>{{ $pembimbing->created_at }}</td>
                                        <td>
                                            <img class="mb-2 mt-2" src="{{ asset('storage/images/' . $pembimbing->image) }}" alt="{{ $pembimbing->name }}" width="100">
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content">
                                                <a href='{{ route('pembimbings.edit', $pembimbing->id) }}' class="btn btn-sm btn-info btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('pembimbings.destroy', $pembimbing->id) }}" method="POST" class="ml-2">
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                        <i class="fas fa-times"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $pembimbings->withQueryString()->links() }}
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