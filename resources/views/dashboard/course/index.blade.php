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
                        <h4 class="card-title">Data kursus</h4>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="{{ route('dashboard.course.create') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Tambah Kursus</a>
                        </div>
                    </div>
                </div>

                <table id="datatable" class="table align-middle dt-responsive table-nowrap table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">#</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Level</th>
                            <th>Harga</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->courseCategory->name }}</td>
                            <td>{{ App\Enums\CourseLevelEnum::getLabel($course->level) }}</td>
                            <td>
                                @if ($course->retail_price != 0)
                                    <span class="text-muted me-2">
                                        <del>{{ number_format($course->retail_price, 0, ',', '.') }}</del>
                                    </span>
                                @endif

                                {{ number_format($course->price, 0, ',', '.') }}
                            </td>
                            <td>{{ $course->type }}</td>
                            <td>
                                <p class="badge font-size-12 m-1 @if($course->status == 'active') badge-soft-success @elseif($course->status == 'inactive') badge-soft-danger @elseif($course->status == 'draft') badge-soft-secondary @else badge-soft-warning @endif">{{ $course->status }}</p>
                            </td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('dashboard.course.show', $course->id) }}" class="text-primary"><i class="mdi mdi-eye font-size-18"></i></a>
                                    <a href="{{ route('dashboard.course.edit', $course->id) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                    <a href="#" onclick="modalDelete('Kursus', '{{ $course->name }}', `{{ route('dashboard.course.delete', $course->id) }}`, '{{ url()->current() }}')" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
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
