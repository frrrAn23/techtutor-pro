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
                        <h4 class="card-title">Data kategori kursus</h4>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="{{ route('dashboard.admin.course-category.create') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Tambah Kategori Kursus</a>
                        </div>
                    </div>
                </div>

                <table id="datatable" class="table align-middle dt-responsive table-nowrap table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">#</th>
                            <th>User</th>
                            <th>Kursus</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($userAccessCourses as $access)
                        <tr>
                            <td>
                                {{ $access->user->name }}
                            </td>
                            <td>{{ $access->course->name }}</td>
                            <td>
                                {{ $category->courses->count() }}
                            </td>
                            <td>
                                {{ date('d M Y', strtotime($access->purchased_at)) }}
                            </td>
                            <td>
                                @if ($access->course_retail_price > 0)
                                    Rp. {{ number_format($access->course_retail_price, 0, ',', '.') }}
                                @elseif ($access->course_price > 0)
                                    Rp. {{ number_format($access->course_price, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </td>
                            <td>
                                @if ($access->status == App\Enums\UserAccessCourseStatusEnum::PENDING)
                                    <span class="badge badge-pill badge-soft-secondary font-size-11">Menunggu Konfirmasi</span>
                                @elseif ($access->status == App\Enums\UserAccessCourseStatusEnum::UNPAID)
                                    <span class="badge badge-pill badge-soft-warning font-size-11">Lanjutkan Pembayaran</span>
                                @elseif ($access->status == App\Enums\UserAccessCourseStatusEnum::ACTIVE)
                                    <span class="badge badge-pill badge-soft-success font-size-11">Pembelian Berhasil</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($categories as $category)
<div class="modal fade list-courses-{{ $category->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">List kursus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    @forelse ($category->courses as $course)
                        <li>{{ $course->name }}</li>
                    @empty
                        <li>Tidak ada kursus</li>
                    @endforelse
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
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
