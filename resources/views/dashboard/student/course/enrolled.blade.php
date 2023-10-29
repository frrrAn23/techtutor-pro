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

    .product-image {
        height: 200px; /* Set a fixed height for the product images */
        object-fit: cover; /* This property ensures the image covers the container */
    }

    .product-card {
        /* height: 450px; */
    }
</style>
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-9 m-auto">
        <div class="row mb-3">
            <div class="col-xl-4 col-sm-6">
                <div class="mt-2">
                    <h5>Kursus saya</h5>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse ($courses as $course)
                @php
                    $course->discount = $course->retail_price != 0 ? ($course->price - $course->retail_price) / $course->price * 100 : 0;
                    $course->duration_in_minutes = $course->topics->sum(function ($topic) {
                        return $topic->materials->sum('duration_in_minutes');
                    });
                    $course->total_materials = $course->topics->sum(function ($topic) {
                        return $topic->materials->count();
                    });

                    $course->rating = $course->feedbacks->avg('rating');
                @endphp

                <div class="col-xl-4 col-sm-6" onclick="window.location.href='{{ route('dashboard.student.course.show', $course->slug) }}'">
                    <div class="card course">
                        <div class="card-body">
                            <div class="product-card">
                                <div class="product-img position-relative">
                                    <img src="{{ getFile($course->thumbnail_url, asset('images/default-profile.jpg')) }}" alt="" class="img-fluid mx-auto d-block product-image">
                                </div>

                                <div class="mt-4">
                                    <h5 class="mb-2 text-truncate"><a href="javascript: void(0);" class="text-dark">{{ $course->name }} </a></h5>
                                    <div class="mb-2">
                                        @php
                                            $level = $course->level;
                                            $levelLabel = $level == 0 ? 'Pemula' : ($level == 1 ? 'Menengah' : 'Mahir');
                                            $levelColor = $level == 0 ? 'primary' : ($level == 1 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $levelColor }} font-size-12">{{ $levelLabel }}</span>

                                        <p class="ms-2 text-muted d-inline">
                                            @for ($i = 1; $i <= $course->rating; $i++)
                                                <i class="bx bxs-star text-warning"></i>
                                            @endfor
                                            @for ($i = $course->rating; $i < 5; $i++)
                                                <i class="bx bxs-star"></i>
                                            @endfor

                                            ({{ $course->feedbacks->count() }} Feedback)
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <span class="font-size-12"><i class="mdi mdi-account"></i> {{ $course->users->count() }} Siswa</span>
                                        <span class="ms-2 font-size-12"><i class="mdi mdi-book-open-page-variant"></i> {{ $course->total_materials }} Materi</span>
                                        <span class="ms-2 font-size-12"><i class="mdi mdi-clock-outline"></i> {{ $course->duration_in_minutes }} Menit</span>
                                    </div>

                                    <p>{{ Str::limit($course->summary, 88) }}</p>

                                    <div class="mt-4">
                                        <span class="badge badge-soft-success font-size-12">{{ $course->type }}</span>
                                        @foreach ($course->labels as $label)
                                            <span class="badge rounded-pill badge-soft-info font-size-12">{{ $label }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <a href="#" class="btn btn-primary btn-sm w-100 mt-3">Lihat kursus</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">
                                Belum ada kursus yang diambil
                            </h4>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
