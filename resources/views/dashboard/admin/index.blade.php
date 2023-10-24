@extends('layouts.master')

@push('style')
<!-- DataTables -->
<link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h4 class="card-title">Data admin</h4>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="{{ route('dashboard.admin.create') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Tambah Admin</a>
                        </div>
                    </div>
                </div>

                <table id="datatable" class="table align-middle dt-responsive table-nowrap table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>
                                <img class="rounded-circle header-profile-user" src="{{ getFile($admin->avatar_url, asset('images/default-profile.jpg')) }}">
                            </td>
                            <td>
                                <h5 class="font-size-14 mb-1 text-dark">{{ $admin->name }}</h5>
                                <p class="text-muted mb-0">{{ $admin->username }}</p>
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <p class="badge font-size-12 m-1 @if($admin->status == 'active') badge-soft-success @elseif($admin->status == 'suspended') badge-soft-danger @else badge-soft-warning @endif">{{ $admin->status }}</p>
                            </td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('dashboard.admin.edit', $admin->id) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                    <a href="#" onclick="modalDelete('Admin', '{{ $admin->name }}', `{{ route('dashboard.admin.delete', $admin->id) }}`, '{{ url()->current() }}')" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div>
@endsection

@push('script')
<!-- Required datatable js -->
<script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>


<script>
    $(document).ready(function() {
        $("#datatable").DataTable({
            "language": {
                "paginate": {
                    "previous": "<i class='uil uil-angle-left'>",
                    "next": "<i class='uil uil-angle-right'>"
                }
            },
            "drawCallback": function() {
                $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            },
            "pagingType": "full_numbers",
        });
    });
</script>
@endpush
