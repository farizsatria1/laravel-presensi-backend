@extends('layouts.app')

@section('title', 'Permissions')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Permissions</h1>
            {{-- <div class="section-header-button">
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add New</a>
        </div> --}}
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Permission</div>
        </div>
</div>
<div class="section-body">
    <h2 class="section-title">Permissions</h2>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>All Permissions</h4>
                </div>
                <div class="card-body">

                    <div class="float-right">
                        <form method="GET" action="{{ route('permissions.index') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name" name="name">
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
                                <th>Date Permission</th>
                                <th>Status Permission</th>

                                <th>Action</th>
                            </tr>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permissions->firstItem() + $loop->index }}</td>
                                <td>{{ $permission->user->name }}
                                </td>
                                <td>
                                    {{ $permission->date_permission }}
                                </td>
                                <td>
                                    @if ($permission->is_approved == 1)
                                    <div class="badge badge-success">Approved</div>
                                    @elseif ($permission->is_approved == 2)
                                    <div class="badge badge-warning">Pending</div>
                                    @else
                                    <div class="badge badge-danger">Not Approved</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href='{{ route('permissions.show', $permission->id) }}' class="btn btn-sm btn-info btn-icon">
                                            <i class="fas fa-edit"></i>
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="float-right">
                        {{ $permissions->withQueryString()->links() }}
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