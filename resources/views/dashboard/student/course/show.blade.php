@extends('layouts.master')

@push('style')
<style>
    .course {
        transition: transform 0.2s;
    }

    .course:hover {
        transform: scale(1.05);
        cursor: pointer;
    }
</style>
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="product-detai-imgs">
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <img src="{{ getFile($course->thumbnail_url, asset('images/default-profile.jpg')) }}" alt="" class="img-fluid mx-auto d-block w-100">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                @if ($access)
                                    @if($access->status == App\Enums\UserAccessCourseStatusEnum::UNPAID)
                                        @if ($access->payment_status == App\Enums\UserAccessCourseStatusPaymentEnum::EXPIRED)
                                            <div class="alert alert-danger mt-2" role="alert">
                                                Order anda yang sebelumnya telah kadaluarsa, silahkan melakukan order ulang
                                            </div>

                                            <form action="{{ route('dashboard.student.course.enroll', $course->slug) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success waves-effect waves-light me-1 w-100">
                                                    <i class="mdi mdi-cart me-1"></i> Beli Kelas
                                                </button>
                                            </form>
                                        @else
                                            <button onclick="pay(event)" class="btn btn-warning waves-effect waves-light mt-4 me-1 w-100">
                                                Lanjutkan Pembayaran
                                            </button>
                                        @endif
                                    @elseif ($access->status == App\Enums\UserAccessCourseStatusEnum::PENDING)
                                        <div class="alert alert-warning mt-4" role="alert">
                                            Menunggu konfirmasi
                                        </div>
                                    @elseif ($access->status == App\Enums\UserAccessCourseStatusEnum::ACTIVE)
                                        <a href="{{ route('dashboard.student.course.material.show', ['slugCourse' => $course->slug, 'slugMaterial' => $continueMaterialSlug]) }}" class="btn btn-primary waves-effect waves-light mt-4 me-1 w-100">
                                            @if ($access->last_material_id == null)
                                                Mulai Kelas
                                            @else
                                                Lanjutkan Kelas
                                            @endif
                                        </a>

                                    @endif
                                @else
                                    <form action="{{ route('dashboard.student.course.enroll', $course->slug) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-4 me-1 w-100">
                                            <i class="mdi mdi-cart me-1"></i> Beli Kelas
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="mt-4 mt-xl-3">
                            <p class="text-primary">{{ $course->courseCategory->name }}</a>
                            <h4 class="mt-1 mb-3">{{ $course->name }}</h4>

                            <p class="text-muted float-start me-3">
                                    @for ($i = 1; $i <= $rating; $i++)
                                        <i class="bx bxs-star text-warning"></i>
                                    @endfor
                                    @for ($i = $rating; $i < 5; $i++)
                                        <i class="bx bxs-star"></i>
                                    @endfor
                            </p>
                            <p class="text-muted mb-3">({{ $course->feedbacks->count() }} Feedback)</p>

                            <div class="mb-4">
                                @php
                                    $level = $course->level;
                                    $levelLabel = $level == 0 ? 'Pemula' : ($level == 1 ? 'Menengah' : 'Mahir');
                                    $levelColor = $level == 0 ? 'primary' : ($level == 1 ? 'warning' : 'danger');
                                @endphp
                                <span class="badge rounded-pill bg-{{ $levelColor }} font-size-12">{{ $levelLabel }}</span>

                                <span class="ms-2 font-size-12"><i class="mdi mdi-account"></i> {{ $course->users->count() }} Siswa</span>
                                <span class="ms-2 font-size-12"><i class="mdi mdi-book-open-page-variant"></i> {{ $totalMaterial }} Materi</span>
                                <span class="ms-2 font-size-12"><i class="mdi mdi-clock-outline"></i> {{ $durationInMinute }} Menit</span>
                            </div>

                            @if ($course->discount > 0)
                                <h6 class="text-success text-uppercase">Diskon {{ number_format($course->discount, 1) }} % </h6>
                                <h5 class="mb-4">Harga : <span class="text-muted me-2"><del>Rp. {{ number_format($course->price, 0, ',', '.') }}</del></span> <b>Rp. {{ number_format($course->retail_price, 0, ',', '.') }}</b></h5>
                            @else
                                @if ($course->price == 0)
                                    <h5 class="mb-4"><b>Gratis</b></h5>
                                @else
                                    <h5 class="mb-4">Harga : <b>Rp. {{ number_format($course->price, 0, ',', '.') }}</b></h5>
                                @endif
                            @endif

                            <p class="text-muted mb-4">{{ $course->summary }}</p>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div>
                                        <p><span class="text-muted">Type:</span> {{ $course->type }}</p>
                                        <p><span class="text-muted">Level:</span> {{ App\Enums\CourseLevelEnum::getLabel($course->level) }}</p>
                                        @foreach ($course->labels as $label)
                                            <span class="badge rounded-pill badge-soft-info font-size-12">{{ $label }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Tentang Kelas :</h5>

                {!! $course->description !!}
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-0">Daftar Materi</h4>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="mt-4">
                            <div class="accordion" id="accordionTopic">
                                @foreach ($topics->sortBy('order', 1) as $topic)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $topic->id }}">
                                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $topic->id }}" aria-expanded="false" aria-controls="collapse-{{ $topic->id }}">
                                                {{ $topic->name }}
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $topic->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $topic->id }}" data-bs-parent="#accordionTopic" style="">
                                            <div class="accordion-body p-1">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach ($topic->materials->sortBy('order', 1) as $material)
                                                            <tr class="text-muted">
                                                                <td class="col-1">
                                                                    @if ($course->type == App\Enums\CourseTypeEnum::TEXT)
                                                                        <i class="bx bx-file"></i>
                                                                    @elseif($course->type == App\Enums\CourseTypeEnum::VIDEO)
                                                                        <i class="bx bx-play-circle"></i>
                                                                    @endif
                                                                </td>
                                                                <td class="col-auto">
                                                                    <p class="d-inline">{{ $material->name }}</p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5>Feedbacks :</h5>

                @forelse ($feedbacks as $feedback)
                    <div class="d-flex py-3 border-bottom">
                        <div class="flex-shrink-0 me-3">
                            <img src="{{ getFile($feedback->user->avatar_url, asset('images/default-profile.jpg')) }}" class="avatar-xs rounded-circle" alt="img">
                        </div>

                        <div class="flex-grow-1">
                            <h5 class="mb-1 font-size-15">{{ $feedback->user->name }}</h5>
                            <p class="text-muted">{{ $feedback->comment }}</p>

                            <p class="text-muted float-end me-3">
                                @for ($i = 1; $i <= $feedback->rating; $i++)
                                    <i class="bx bxs-star text-warning"></i>
                                @endfor
                                @for ($i = $feedback->rating; $i < 5; $i++)
                                    <i class="bx bxs-star"></i>
                                @endfor
                            </p>

                            <div class="text-muted font-size-12"><i class="far fa-calendar-alt text-primary me-1"></i>
                                    {{ $feedback->created_at->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    Belum ada feedback
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
        const payButton = document.querySelector('#pay-button');

        function pay(event) {
            event.preventDefault();

            @if ($access && $access->snap_token)
                snap.pay('{{ $access->snap_token }}');
            @endif
        }
    </script>
@endpush
