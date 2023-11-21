@extends('layouts.master')

@push('style')
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Selamat datang!</h5>
                            <p>Di Platform online course</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="{{ getFile($user->avatar_url, asset('images/default-profile.jpg')) }}" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ $user->name }}</h5>
                        <p class="text-muted mb-0 text-truncate">{{ $user->username }}</p>
                    </div>

                    <div class="col-sm-8">
                        <div class="pt-4">
                            <p>
                            Pembelajaran itu adalah proses tanpa akhir. Semakin kamu belajar, semakin kamu sadar betapa sedikit yang kamu ketahui.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Transaksi terakhir</h4>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">Kursus</th>
                                    <th class="align-middle">Tanggal pemesanan</th>
                                    <th class="align-middle">Harga</th>
                                    <th class="align-middle">Status Pembayaran</th>
                                    <th class="align-middle"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($userAccessCourses as $access)
                                    <tr>
                                        <td>{{ $access->course->name }}</td>
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
                                        <td>
                                            <a href="{{ route('dashboard.student.course.show', $access->course->slug) }}" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                Detail kursus
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
@endsection

@push('script')
@endpush
