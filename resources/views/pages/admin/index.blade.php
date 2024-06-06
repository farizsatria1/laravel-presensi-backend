@extends('layouts.app')

@section('title', 'Admin')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Admin</h1>
            <div class="section-header-button">
                <a href="{{ route('admins.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Admin</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">

            </div>
            <h2 class="section-title">Admin</h2>
            <p class="section-lead">
                You can manage all Admin, such as editing, deleting and more.
            </p>


            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="float-right">
                                <form method="GET" action="{{ route('admins.index') }}">
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
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($admins as $admin)

                                    <tr>
                                        <td>{{ $admins->firstItem() + $loop->index }}</td>
                                        <td>{{ $admin->name }}
                                        </td>
                                        <td>
                                            {{ $admin->email }}
                                        </td>
                                        <td>{{ $admin->created_at }}</td>
                                        <td>
                                            {{ $admin->role }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content">
                                                <a href='{{ route('admins.edit', $admin->id) }}' class="btn btn-sm btn-info btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="ml-2">
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
                                {{ $admins->withQueryString()->links() }}
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